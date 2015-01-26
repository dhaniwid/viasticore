<?php

class RoomTypeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            // get all the roomFeatures
            $roomTypes = RoomType::all();
            //$roomTypes = new RoomType();
            //$roomTypes = $roomTypes->paginate(Config::get('syntara::config.item-perge-page'));
            // ajax request : reload only content container
            if(Request::ajax())
            {
                $html = View::make('roomtypes.list-roomtypes')->with('roomtypes', $roomTypes)->render();

                return Response::json(array('html' => $html, 'redirectUrl' => URL::route('newRoomPrice')));
            }
            
            $this->layout = View::make('roomtypes.index-roomtype')->with('roomtypes', $roomTypes);
            $this->layout->title = trans('syntara::rooms.features.list');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.roomtypes');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            $roomfeatures = RoomFeature::all();
            
            $this->layout = View::make('roomtypes.new-roomtype', array('roomfeatures' => $roomfeatures));
            $this->layout->title = trans('syntara::rooms.features.new');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.create_room_feature');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
            $rules = array(
                'roomtype_name' => 'required',
                'roomtype_maxoccupancy' => 'required',
                'roomtype_minavailability' => 'required',
                'roomtype_roomsize' => 'required',
                'roomtype_description' => 'required',                
            );
            $validator = Validator::make(Input::all(), $rules);

            // process the login
            if ($validator->fails()) {
                return Redirect::to('dashboard/roomType/new')
                    ->withErrors($validator)
                    ->withInput(Input::except('password'));                
                //return Response::json(array('roomCreated' => false, 'errorMessages' => $validator->messages()));
            } else {
                // store
                $room = new RoomType;
                $sequence = DB::select("SELECT nextval('public.roomtype_id_seq') as id");
                
                if($sequence[0]!=null)
                {
                    $room->roomtype_id = "R" . ($sequence[0]->id);
                    $room->roomtype_name = Input::get('roomtype_name');
                    $room->roomtype_maxoccupancy = Input::get('roomtype_maxoccupancy');
                    $room->roomtype_minimumavailability = Input::get('roomtype_minavailability');
                    $room->roomtype_size = (Input::get('roomtype_roomsize')==null? 0 : Input::get('roomtype_roomsize'));
                    $room->roomtype_extrabed = (Input::get('roomtype_extrabed')==null? 0 : Input::get('roomtype_extrabed'));
                    $room->roomtype_extrabedprice = (Input::get('roomtype_extrabedprice')==null? 0 : Input::get('roomtype_extrabedprice'));
                    $room->roomtype_lowestprice = (Input::get('roomtype_lowestprice')==null? 0 : Input::get('roomtype_lowestprice'));
                    $room->roomtype_activestatus = (Input::get('roomtype_activestatus')==null? 0 : Input::get('roomtype_activestatus'));
                    $room->roomtype_description = Input::get('roomtype_description');
                    $room->save();

                    //get room features
                    $roomFeatures = Input::get('room_features');
                    foreach ($roomFeatures as $roomFeature)
                    {
                        //store to roomcontents table
                        $roomContent = new RoomContent;
                        $roomContent->roomtype_id = $room->roomtype_id;
                        $roomContent->roomfeature_id = $roomFeature;
                        $roomContent->checked = true;
                        $roomContent->save();
                    }
                    // redirect
                    Session::flash('message', 'New room successfully added');
                    return Redirect::to('dashboard/roomTypes');
                }   
                else{
                    // redirect with error
                    Session::flash('message', 'Could not get sequence number');
                    return Redirect::to('dashboard/roomTypes');
                }
            }
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{   
            $room = RoomType::find($id);
            $roomcontents = DB::select('select f.roomfeature_id, f.roomfeature_name, c.roomtype_id, c."checked"
                                        from roomfeatures f
                                        left join room_contents c on f.roomfeature_id = c.roomfeature_id
                                        and c.roomtype_id = ?
                                        order by f.roomfeature_id', [$id]);
            $roomimages = RoomImage::findMany([$id]);
            
            $this->layout = View::make('roomtypes.show-roomtype')->with(array('roomimages'=>$roomimages))->with(array('roomcontents' => $roomcontents))->with(array('room' => $room));
            $this->layout->title = trans('syntara::rooms.types.detail');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.room_type_detail');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            $rules = array(
                'roomtype_name' => 'required',
                'roomtype_maxoccupancy' => 'required',
                'roomtype_minavailability' => 'required',
                'roomtype_roomsize' => 'required',
                'roomtype_description' => 'required',                
            );
            $validator = Validator::make(Input::all(), $rules);

            // process the login
            if ($validator->fails()) {
                return Response::json(array('roomUpdated' => false, 'errorMessages' => $validator->messages()));
            } 
            
            
            //1. store to roomcontents table
            //before that, delete the existing records
            $oldRoomContent = RoomContent::find($id);            
            if($oldRoomContent){
                if(!$oldRoomContent->delete())
                {
                    return Response::json(array('roomUpdated' => false, 'message' => trans('syntara::rooms.messages.update-fail'), 'messageType' => 'danger'));
                }                
            }            
            //get roomtypes and roomfeatures
            $room = RoomType::find($id);
            $roomFeatures = Input::get('room_features');
            foreach ($roomFeatures as $roomFeature)
            {
                //store to roomcontents table
                $newRoomContent = new RoomContent;
                $newRoomContent->roomtype_id = $room->roomtype_id;
                $newRoomContent->roomfeature_id = $roomFeature;
                $newRoomContent->checked = true;                
                $newRoomContent->save();
            }
            
            //2. store the updated value to roomtypes table
            $room->fill((Input::all()));
            //print_r($room->roomtype_activestatus);exit();
            if($room->roomtype_activestatus){
                $room->roomtype_activestatus = true;
            }
            else{
                $room->roomtype_activestatus = false;
            }
            
            if($room->save()){
                return Response::json(array('roomUpdated' => true, 'message' => trans('syntara::rooms.messages.update-success'), 'messageType' => 'success'));
            }
            else 
            {
                return Response::json(array('roomUpdated' => false, 'message' => trans('syntara::rooms.messages.update-fail'), 'messageType' => 'danger'));
            }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
            try{                
                //delete room contents first
                $roomContents = RoomContent::find($id);
                //check whether the record exists or not
                if($roomContents){
                    $roomContents->delete();
                }
                //then delete room images
                $roomImages = RoomImage::find($id);
                //check whether the record exists or not
                if($roomImages){
                    $roomImages->delete();
                }
                //finally delete the room types
                $room = RoomType::find($id);
                //check whether the record exists or not
                if($room){
                    $room->delete();
                }
            }
            catch(Exception $e)
            {
                return Response::json(array('deleteRoomType' => false, 'message' => trans('syntara::rooms.messages.not-found'), 'messageType' => 'danger'));
            }
            return Response::json(array('deleteRoomType' => true, 'message' => trans('syntara::rooms.messages.remove-success'), 'messageType' => 'success'));
	}

}
