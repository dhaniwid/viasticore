<?php

class RoomPriceController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            // get all the roomprices data            
            $roomprices = DB::select(RoomPrice::getQueryRoomPrice());
            $roompricedate = DB::select(RoomPrice::getQueryRoomPriceDate());
            $this->getRoomPriceDate($roomprices, $roompricedate);
            
            if(Request::ajax())
            {
                $html = View::make('roomprices.list-roomprices')->with('roomprices', $roomprices)->render();
                return Response::json(array('html' => $html));
            }
            
            $this->layout = View::make('roomprices.index-roomprice')->with('roomprices', $roomprices)->with('roompricedate', $roompricedate);
            $this->layout->title = trans('syntara::roomprices.list');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.roomprices');
	}
        
        public function getRoomPriceDate($roomprices, $roompricedate)
        {
            $allDate = null;
            foreach($roomprices as $roomprice)
            {
                foreach($roompricedate as $roomdate)
                {
                    if($roomprice->roomprice_datetime == $roomdate->roomprice_datetime
                            && $roomdate->occupancy_id == $roomprice->occupancy_id){
                        $allDate = $allDate.$roomdate->roomprice_day.", ";
                    }
                }                
                $roomprice->roomprice_date = rtrim($allDate, ", ");
                $allDate=null;
            }
            return $roomprices;
        }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            
            $roomprices = RoomPrice::all();
            $roomtypes = RoomType::lists('roomtype_name', 'roomtype_id');
            
            $this->layout = View::make('roomprices.new-roomprice', array('roomprices' => $roomprices, 'roomtypes' => $roomtypes));
            $this->layout->title = trans('syntara::roomprices.new');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.create_room_price');
	}
        
        public function setDetailPrice($roomtypeId)
        {
            // to retrieve occupancy_id
            $roomtype = RoomType::find($roomtypeId);
            $roomtype_occupancy = $roomtype->roomtype_maxoccupancy;
            $occupancies = Occupancy::orderBy('occupancy_id', 'asc')->paginate($roomtype_occupancy);
            
            if(Request::ajax())
            {
                //$html = View::make('roomprices.new-roomprice')->with('roomtypes', $roomtypes)->with('roomprices', $roomprices)->with('occupancies', $occupancies)->render();
                return View::make('table-rate')->with('occupancies', $occupancies);                 
            }
        }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($occupancies)
	{
            try {
                $rules = array(
                    'start_date' => array('required', 'date_format:"d-m-Y"', 'before:end_date'),
                    'end_date' => array('required', 'date_format:"d-m-Y"', 'after:start_date'),
                    'days' => array('required')
                );
                $messages = array(
                    'days.required' => 'Please select at least one day',
                    'start_date.required' => 'Please select Start Date',
                    'end_date.required' => 'Please select End Date',
                    'required' => 'The room rate for :attribute occupancy is required.',
                );
                
                //retrieve occupancy
                $roomtype = RoomType::find(Input::get('roomtype_name'));
                $roomtype_occupancy = $roomtype->roomtype_maxoccupancy;
                $occupancies = Occupancy::orderBy('occupancy_id', 'asc')->paginate($roomtype_occupancy);
                //validate occupancy description manually
                foreach($occupancies as $occupancy){
                    $field_name = ($occupancy->occupancy_description);
                    $rules[$field_name] = array('required');
                }

                $validator = Validator::make(Input::all(), $rules, $messages);
                if ($validator->fails()) {
                    return Response::json(array('roomPriceCreated' => false, 'errorMessages' => $validator->messages()));
                }
                
                //if passes validation, continue
                // retrieve difference value from date_from and date_to fields
                // get today's date to be inserted as key
                $now = new DateTime();

                $startDate = new DateTime(Input::get('start_date'));
                $endDate = new DateTime(Input::get('end_date'));
                $endDate = $endDate->modify( '+1 day' ); 
                $period = new DatePeriod($startDate, new DateInterval('P1D'), $endDate);                    
                
                //only insert checked day
                $daysChecked = Input::get('days');
                
                //loop for inserting each occupancy id
                foreach($occupancies as $occupancy){
                    foreach($period as $date){
                        //loop again just to check only days checked to be inserted
                        foreach($daysChecked as $day){
                             if($date->format("D") == $day){
                                $roomPrice = new RoomPrice();
                                $roomPrice->roomprice_datetime = $now;           
                                $roomPrice->roomprice_date = $date->format("d-m-Y"); 
                                $roomPrice->roomprice_day = $date->format("D");
                                $roomPrice->occupancy_id = $occupancy->occupancy_id;
                                $roomPrice->roomtype_id = Input::get('roomtype_name');
                                $roomPrice->roomprice_rate = Input::get($occupancy->occupancy_description);
                                $roomPrice->roomprice_breakfast = Input::get('breakfast');
                                $roomPrice->save();                
                             }
                        }
                    }   
                }
                //loop for roomavailabilty
                //only insert first occupancy
                foreach($period as $date){
                    //loop again just to check only days checked to be inserted
                    foreach($daysChecked as $day){
                         if($date->format("D") == $day){
                            $roomAvailability = new RoomAvailability();
                            $roomAvailability->roomavailability_id = $now;
                            $roomAvailability->roomavailability_date = $date->format("d-m-Y"); 
                            $roomAvailability->roomtype_id = Input::get('roomtype_name');
                            $roomAvailability->roomavailability_number = Input::get('allotment');
                            $roomAvailability->roomavailability_minstay = Input::get('minstay');
                            $roomAvailability->save();
                         }
                    }
                }
                   
            } catch (Exception $exc) {
                var_dump($exc->getMessage());
                return Response::json(array('roomPriceCreated' => false, 'message' => trans('syntara::roomprices.messages.exception-catched'), 'messageType' => 'danger'));
            }
            return json_encode(array('roomPriceCreated' => true, 'redirectUrl' => URL::route('listRoomPrices')));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{   
            $occupancy = RoomPrice::find($id);
            
            $this->layout = View::make('roomprices.show-occupancy')->with(array('occupancy' => $occupancy));
            $this->layout->title = trans('syntara::roomprices.types.detail');
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
            //get roomprices and occupancyfeatures
            $occupancy = RoomPrice::find($id);
            //2. store the updated value to roomprices table
            $occupancy->occupancy_description = Input::get('occupancy_description');
            if($occupancy->save()){
                return Response::json(array('occupancyUpdated' => true, 'message' => trans('syntara::roomprices.messages.update-success'), 'messageType' => 'success'));
            }
            else 
            {
                return Response::json(array('occupancyUpdated' => false, 'message' => trans('syntara::roomprices.messages.update-fail'), 'messageType' => 'danger'));
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
                $occupancy = RoomPrice::find($id);
                //check whether the record exists or not
                if($occupancy){
                    $occupancy->delete();
                }
            }
            catch(Exception $e)
            {
                return Response::json(array('deleteRoomPrice' => false, 'message' => trans('syntara::roomprices.messages.not-found'), 'messageType' => 'danger'));
            }
            return Response::json(array('deleteRoomPrice' => true, 'message' => trans('syntara::roomprices.messages.remove-success'), 'messageType' => 'success'));
	}
        
        function createDateRangeArray($strDateFrom,$strDateTo)
        {
            // takes two dates formatted as YYYY-MM-DD and creates an
            // inclusive array of the dates between the from and to dates.

            // could test validity of dates here but I'm already doing
            // that in the main script

            $aryRange=array();

            $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
            $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

            if ($iDateTo>=$iDateFrom)
            {
                array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
                while ($iDateFrom<$iDateTo)
                {
                    $iDateFrom+=86400; // add 24 hours
                    array_push($aryRange,date('Y-m-d',$iDateFrom));
                }
            }
            return $aryRange;
        }

}
