<?php

class OccupancyController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            // get all the occupancies data
            
            $occupancies = DB::select('select o.* from occupancies o where 1=1
                            order by o.occupancy_id');
            //$occupancies = new Occupancy();
            //$occupancies = $occupancies->paginate(Config::get('syntara::config.item-perge-page'));
            // ajax request : reload only content container
            if(Request::ajax())
            {
                $html = View::make('occupancies.list-occupancies')->with('occupancies', $occupancies)->render();
                return Response::json(array('html' => $html));
            }
            
            $this->layout = View::make('occupancies.index-occupancy')->with('occupancies', $occupancies);
            $this->layout->title = trans('syntara::occupancies.list');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.occupancies');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            $occupancy = Occupancy::all();
            
            $this->layout = View::make('occupancies.new-occupancy', array('occupancy' => $occupancy));
            $this->layout->title = trans('syntara::occupancies.new');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.create_occupancy');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
            try {
                $rules = array(
                    'occupancy_id' => 'required',
                    'occupancy_description' => 'required'
                );
                $validator = Validator::make(Input::all(), $rules);
                // process the login
                if ($validator->fails()) {
                    return Response::json(array('occupancyCreated' => false, 'errorMessages' => $validator->messages()));
                } else {
                    // store
                    $occupancy = new Occupancy;
                    $occupancy->occupancy_id = Input::get('occupancy_id');
                    $occupancy->occupancy_description = Input::get('occupancy_description');

                    if($occupancy->save())
                    {
                        Session::flash('type', 'success');
                        Session::flash('message', trans('syntara::occupancies.messages.save-success'));
                        return json_encode(array('occupancyCreated' => true, 'message' => trans('syntara::occupancies.messages.save-success'), 'messageType' => 'success', 'redirectUrl' => URL::route('listOccupancies')));
                    }
                    else{
                        return Response::json(array('occupancyCreated' => false, 'message' => trans('syntara::occupancies.messages.exists'), 'messageType' => 'danger'));
                    }
                }
            } catch (Exception $exc) {
                //return Response::json(array('occupancyCreated' => false, 'message' => trans('syntara::occupancies.messages.exception-catched'), 'messageType' => 'danger'));                
                return json_encode(array('occupancyCreated' => false, 'message' => trans('syntara::occupancies.messages.exists'), 'messageType' => 'danger'));
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
            $occupancy = Occupancy::find($id);
            
            $this->layout = View::make('occupancies.show-occupancy')->with(array('occupancy' => $occupancy));
            $this->layout->title = trans('syntara::occupancies.types.detail');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.occupancy_detail');
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
                'occupancy_description' => 'required'              
            );
            $validator = Validator::make(Input::all(), $rules);
            // process the login
            if ($validator->fails()) {
                return Response::json(array('occupancyUpdated' => false, 'errorMessages' => $validator->messages()));
            }          
            //get occupancies and occupancyfeatures
            $occupancy = Occupancy::find($id);
            //2. store the updated value to occupancies table
            $occupancy->occupancy_description = Input::get('occupancy_description');
            if($occupancy->save()){
                return Response::json(array('occupancyUpdated' => true, 'message' => trans('syntara::occupancies.messages.update-success'), 'messageType' => 'success'));
            }
            else 
            {
                return Response::json(array('occupancyUpdated' => false, 'message' => trans('syntara::occupancies.messages.update-fail'), 'messageType' => 'danger'));
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
                //find and delete occupancy
                $occupancy = Occupancy::find($id);
                //check whether the record exists or not
                if($occupancy){
                    $occupancy->delete();
                }
            }
            catch(Exception $e)
            {
                return Response::json(array('deleteOccupancy' => false, 'message' => trans('syntara::occupancies.messages.not-found'), 'messageType' => 'danger'));
            }
            return Response::json(array('deleteOccupancy' => true, 'message' => trans('syntara::occupancies.messages.remove-success'), 'messageType' => 'success'));
	}

}
