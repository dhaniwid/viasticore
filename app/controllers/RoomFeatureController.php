<?php

class RoomFeatureController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            // get all the roomFeatures
            $roomFeatures = RoomFeature::all();
            
            Session::flash('message', 'There are '+$roomFeatures->count()+' available for this date');
            
            if(Request::ajax())
            {
                $html = View::make('roomfeatures.list-roomfeatures')->with('roomfeatures', $roomFeatures)->render();

                return Response::json(array('html' => $html, 'redirectUrl' => URL::route('listRoomFeatures')));
            }
            
            $this->layout = View::make('roomfeatures.index-roomfeature')->with('roomfeatures', $roomFeatures);
            $this->layout->title = trans('syntara::rooms.features.list');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.roomfeatures');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            $this->layout = View::make('roomfeatures.new-roomfeature');
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
                'roomfeature_name' => 'required',
                'roomfeature_description' => 'required'
            );
            $validator = Validator::make(Input::all(), $rules);

            // process the login
            if (!$validator->passes()) {
                //return Redirect::to('dashboard/roomFeature/new')
                    //->withErrors($validator)
                    //->withInput(Input::except('password'));                
                return Response::json(array('roomCreated' => false, 'errorMessages' => $validator->messages()));
            } else {
                // store
                try{
                    $room = new RoomFeature;

                    //$room->roomtype_id = $roomtypes;
                    $room->roomfeature_name = Input::get('roomfeature_name');
                    $room->roomfeature_description = Input::get('roomfeature_description');
                    $room->save();

                    // redirect
//                    Session::flash('message', 'New room feature successfully added');
//                    return Redirect::to('dashboard/roomFeatures');
                }
                catch(Exception $e)
                {
                    var_dump($e->getMessage());
                    return Response::json(array('roomFeatureCreated' => false, 'message' => trans('syntara::rooms.messages.exception-catched'), 'messageType' => 'danger'));
                }
                    Session::flash('type', 'success');
                    Session::flash('message', trans('syntara::rooms.messages.add-success'));
                    return json_encode(array('roomFeatureCreated' => true, 'redirectUrl' => URL::route('listRoomFeatures'), 'message' => trans('syntara::rooms.messages.add-success'), 'messageType' => 'success'));
                    //return Response::json(array('roomFeatureCreated' => true, 'message' => trans('syntara::rooms.messages.add-success'), 'messageType' => 'success'));
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
            
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
            $room = RoomFeature::find($id);
            $this->layout = View::make('roomfeatures.show-roomfeature', array('room' => $room));
            $this->layout->title = trans('syntara::all.edit');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.edit_room_feature');
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            // validate
            // read more on validation at http://laravel.com/docs/validation
            $rules = array(
                'roomfeature_name' => 'required'
            );
            $validator = Validator::make(Input::all(), $rules);

            // process the login
            if ($validator->fails()) {
                return Redirect::to('roomfeature/' . $id . '')
                    ->withErrors($validator)
                    ->withInput(Input::except('password'));
            } else {
                // store
                $room = RoomFeature::find($id);
                $room->roomfeature_name = Input::get('roomfeature_name');
                $room->roomfeature_description = Input::get('roomfeature_description');
                $room->save();

                // redirect
                Session::flash('message', 'Successfully updated room!');
                return Redirect::to('dashboard/roomFeatures');
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
                //finally delete the room feature
                $room = RoomFeature::find($id);
                //check whether the record exists or not
                if($room){
                    $room->delete();
                }
            }
            catch(Exception $e)
            {
                var_dump($e->getMessage());
                return Response::json(array('deleteRoomFeature' => false, 'message' => trans('syntara::rooms.messages.not-found'), 'messageType' => 'danger'));
            }
            return Response::json(array('deleteRoomFeature' => true, 'message' => trans('syntara::rooms.messages.remove-success'), 'messageType' => 'success'));
	}

}
