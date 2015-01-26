<?php

class ReservationController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            // get all the data    
            $checkInDate = Input::get('checkIn');
            $checkOutDate = Input::get('checkOut');
            //get check in & check out date
            $startDate = strtotime($checkInDate);
            $endDate = strtotime($checkOutDate);
            $numberDays = intval((abs($endDate - $startDate))/86400);
            
            $adultQty = Input::get('adultQty');
            $childQty = Input::get('childQty');
            $totalQty = $adultQty+$childQty;
            $roomQty = Input::get('roomQty');
            
            $searchingDates = new Reservation();
            $searchingDates->checkInDate = $checkInDate;
            $searchingDates->checkOutDate = $checkOutDate;
            $searchingDates->adultQty = $adultQty;
            $searchingDates->childQty = $childQty;
            $searchingDates->roomQty = $roomQty;
            $searchingDates->night = $numberDays;
            $reservations = Reservation::getQueryReservation($checkInDate, $checkOutDate, $totalQty, $roomQty);
            
            if(Request::ajax())
            {
                $html = View::make('reservations.list-reservations')->with('reservations', $reservations)->with('searchingDates', $searchingDates)->render();
                return Response::json(array('html' => $html));
            }
            
            $this->layout = View::make('frontend.reservations.index-reservation')->with('reservations', $reservations)->with('searchingDates', $searchingDates);
            $this->layout->title = trans('syntara::all.frontend.home');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.reservation');
	}
        
        public function getReservationDate($reservations, $roomavailabilitydate)
        {
            $allDate = null;
            foreach($reservations as $roomavailability)
            {
                foreach($roomavailabilitydate as $roomdate)
                {
                    if($roomavailability->roomavailability_datetime == $roomdate->roomavailability_datetime
                            && $roomdate->occupancy_id == $roomavailability->occupancy_id){
                        $allDate = $allDate.$roomdate->roomavailability_day.", ";
                    }
                }                
                $roomavailability->roomavailability_date = rtrim($allDate, ", ");
                $allDate=null;
            }
            return $reservations;
        }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            
            $reservations = Reservation::all();
            $roomtypes = RoomType::lists('roomtype_name', 'roomtype_id');
            
            $this->layout = View::make('reservations.new-roomavailability', array('reservations' => $reservations, 'roomtypes' => $roomtypes));
            $this->layout->title = trans('syntara::reservations.new');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.create_room_availability');
	}
        
        public function setDetailAvailability($startDateParam, $endDateParam)
        {
            //$now = new DateTime();            
            $roomAvailabilities = Reservation::all();
            $roomtypes = RoomType::lists('roomtype_name', 'roomtype_id');
            
            $startDate = new DateTime($startDateParam);            
            $endDate = new DateTime($endDateParam);
            $endDate = $endDate->modify( '+1 day' ); 
            
            $period = new DatePeriod($startDate, new DateInterval('P1D'), $endDate);
            
            foreach($period as $date){
                $roomAvailability = new Reservation();
                $roomAvailability->roomavailability_date = $date->format("d/m/Y");
                $roomAvailability->roomavailability_day = $date->format("D");
                $roomAvailability->roomavailability_reserved = 0;
                $roomAvailability->roomavailability_guaranteed = 0;
                $roomAvailability->roomavailability_number = 3;
                $roomAvailability->roomavailability_minstay = 1;
                $roomAvailability->roomavailability_closeout = '';
                $roomAvailability->roomavailability_noarrival = '';
                $roomAvailability->roomavailability_promoblackout = '';
                
                $roomAvailabilities[] = $roomAvailability;
            }
                     
            if(Request::ajax())
            {
                //$view = View::make('reservations.new-roomavailability')->with('roomtypes', $roomtypes)->with('reservations', $roomAvailabilities);
                //$view = $view->renderSections(); 
                //return join($view,''); 
                //return $view;
                return View::make('table-availability')->with('roomAvailabilities', $roomAvailabilities);                 
            }
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
                    'start_date' => array('required', 'date_format:"d-m-Y"', 'before:end_date'),
                    'end_date' => array('required', 'date_format:"d-m-Y"', 'after:start_date')
                );
                $messages = array(
                    'days.required' => 'Please select at least one day',
                    'start_date.required' => 'Please select Start Date',
                    'end_date.required' => 'Please select End Date',
                    'required' => 'The room rate for :attribute occupancy is required.',
                );
                //validate
                $validator = Validator::make(Input::all(), $rules);
                if ($validator->fails()) {
                    return Response::json(array('roomPriceCreated' => false, 'errorMessages' => $validator->messages()));
                }
                
                //if passes validation, continue
                $dates = Input::get('roomavailability_date');
                $numbers = Input::get('roomavailability_number');
                $reserves = Input::get('roomavailability_reserved');
                $guaranteed = Input::get('roomavailability_guaranteed');
                $minstay = Input::get('roomavailability_minstay');
                $closeout = Input::get('roomavailability_closeout');
                $noarrival = Input::get('roomavailability_noarrival');
                $promoblackout = Input::get('roomavailability_promoblackout');
                $roomAvailabilities = Input::all();
                //var_dump($roomAvailabilities);exit();
                $now = new DateTime();
                $index = 0;
                foreach($dates as $date){
                    $roomAvailability = new Reservation();
                    $roomAvailability->roomavailability_id = $now;
                    $roomAvailability->roomavailability_date = $date;
                    $roomAvailability->roomtype_id = Input::get('roomtype_name');                    
                    $roomAvailability->roomavailability_number = $numbers[$index];
                    $roomAvailability->roomavailability_reserved = $reserves[$index];
                    $roomAvailability->roomavailability_guaranteed = $guaranteed[$index];
                    
                    $roomAvailability->roomavailability_minstay = $minstay[$index];
                    
//                    if($closeout[$index]== ''){
//                        if(null!= $closeout[$index+1] && $closeout[$index+1] != ''){
//                            $roomAvailability->roomavailability_closeout = $closeout[$index+1];
//                        }
//                        else{
//                            $roomAvailability->roomavailability_closeout = 1;                    
//                        }
//                    }
//                    else {
                        $roomAvailability->roomavailability_closeout = $closeout[$index];                    
//                    }
//                    
//                    if($noarrival[$index]== ''){
//                        if(null!= $noarrival[$index+1] && $noarrival[$index+1] != ''){
//                            $roomAvailability->roomavailability_noarrival = $noarrival[$index+1];
//                        }
//                        else{
//                            $roomAvailability->roomavailability_noarrival = 1;                    
//                        }
//                    }
//                    else {
                        $roomAvailability->roomavailability_noarrival = $noarrival[$index];                    
//                    }
//                    
//                    if($promoblackout[$index]== ''){
//                        if(null!= $promoblackout[$index+1] && $promoblackout[$index+1] != ''){
//                            $roomAvailability->roomavailability_promoblackout = $promoblackout[$index+1];
//                        }
//                        else{
//                            $roomAvailability->roomavailability_promoblackout = 1;                    
//                        }
//                    }
//                    else {
                        $roomAvailability->roomavailability_promoblackout = $promoblackout[$index];                    
//                    }
                    
                    $roomAvailability->save();
                    $index++;
                }                
            } catch (Exception $exc) {
                var_dump($exc->getMessage());
                return Response::json(array('roomAvailabilityCreated' => false, 'message' => trans('syntara::reservations.messages.exception-catched'), 'messageType' => 'danger'));
            }
            return json_encode(array('roomAvailabilityCreated' => true, 'redirectUrl' => URL::route('listRoomAvailabilities')));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{   
            $occupancy = Reservation::find($id);
            
            $this->layout = View::make('reservations.show-occupancy')->with(array('occupancy' => $occupancy));
            $this->layout->title = trans('syntara::reservations.types.detail');
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
            //get reservations and occupancyfeatures
            $occupancy = Reservation::find($id);
            //2. store the updated value to reservations table
            $occupancy->occupancy_description = Input::get('occupancy_description');
            if($occupancy->save()){
                return Response::json(array('occupancyUpdated' => true, 'message' => trans('syntara::reservations.messages.update-success'), 'messageType' => 'success'));
            }
            else 
            {
                return Response::json(array('occupancyUpdated' => false, 'message' => trans('syntara::reservations.messages.update-fail'), 'messageType' => 'danger'));
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
                $occupancy = Reservation::find($id);
                //check whether the record exists or not
                if($occupancy){
                    $occupancy->delete();
                }
            }
            catch(Exception $e)
            {
                return Response::json(array('deleteReservation' => false, 'message' => trans('syntara::reservations.messages.not-found'), 'messageType' => 'danger'));
            }
            return Response::json(array('deleteReservation' => true, 'message' => trans('syntara::reservations.messages.remove-success'), 'messageType' => 'success'));
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
