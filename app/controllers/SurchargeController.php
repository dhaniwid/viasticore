<?php

class SurchargeController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            // get all the surchargeFeatures
            $surcharges = Surcharge::all();
            if(Request::ajax())
            {
                $html = View::make('surcharges.list-surcharges')->with('surcharges', $surcharges)->render();

                return Response::json(array('html' => $html, 'redirectUrl' => URL::route('listSurcharges')));
            }

            $this->layout = View::make('surcharges.index-surcharge')->with('surcharges', $surcharges);
            $this->layout->title = trans('syntara::surcharges.surcharges.list');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.surcharges');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            $this->layout = View::make('surcharges.new-surcharge');
            $this->layout->title = trans('syntara::surcharges.surcharges.new');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.create_surcharge');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
            $rules = array(
                'surcharge_description' => 'required'
            );
            $validator = Validator::make(Input::all(), $rules);

            // process the login
            if (!$validator->passes()) {                
                return Response::json(array('surchargeCreated' => false, 'errorMessages' => $validator->messages()));
            } else {
                // store
                $surcharge = new Surcharge;                
                $surcharge->surcharge_description = Input::get('surcharge_description');
                $surcharge->save();
                
                // redirect
                Session::flash('message', 'New surcharge successfully added');
                return Redirect::to('dashboard/surcharges');
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
            $surcharge = Surcharge::find($id);
            $this->layout = View::make('surcharges.show-surcharge', array('surcharge' => $surcharge));
            $this->layout->title = trans('syntara::all.edit');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.edit_surcharge');
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
                'surcharge_desecription' => 'required'
            );
            $validator = Validator::make(Input::all(), $rules);

            // process the login
            if ($validator->fails()) {
                return Response::json(array('surchargeCreated' => false, 'errorMessages' => $validator->messages()));
            } else {
                // store
                $surcharge = Surcharge::find($id);
                $surcharge->surcharge_description = Input::get('surcharge_description');
                $surcharge->save();

                // redirect
                Session::flash('message', 'Successfully updated surcharge!');
                return Redirect::to('dashboard/surcharges');
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
                //finally delete the room types
                $surcharge = Surcharge::find($id);
                //check whether the record exists or not
                if($surcharge){
                    $surcharge->delete();
                }
            }
            catch(Exception $e)
            {
                return Response::json(array('deleteSurcharge' => false, 'message' => trans('syntara::rooms.messages.not-found'), 'messageType' => 'danger'));
            }
            return Response::json(array('deleteSurcharge' => true, 'message' => trans('syntara::rooms.messages.remove-success'), 'messageType' => 'success'));
	}

}
