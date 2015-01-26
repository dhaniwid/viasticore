<?php

class BookingController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            $this->layout = View::make('frontend.rateavailabilities.index-rateavailability')->with('rateavailabilities', $rateavailabilities)->with('searchingDates', $searchingDates);
            $this->layout->title = trans('syntara::rateavailabilities.list');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.room-availability');
	}        

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($json)
	{            
            $objParam = base64_decode($json);       
            $booking = json_decode($objParam);
            //get check in & check out date
            $startDate = strtotime($booking->check_in);
            $endDate = strtotime($booking->check_out);
            $numberDays = intval((abs($endDate - $startDate))/86400);
            $booking->night = $numberDays;
            
            $view =  View::make('frontend\bookings.index-booking', array('booking' => $booking));
            $view->title = trans('syntara::bookings.bookingDetail');
            $view->breadcrumb = Config::get('syntara::breadcrumbs.booking');
            return $view;            
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
                    'title' => array('required'),
                    'name' => array('required'),
                    'email' => array('required'),
                    'nationality' => array('required'),
                    'phoneNo' => array('required')
                );
//                $messages = array(
//                    'days.required' => 'Please select at least one day',
//                    'start_date.required' => 'Please select Start Date',
//                    'end_date.required' => 'Please select End Date',
//                    'required' => 'The room rate for :attribute occupancy is required.',
//                );
                //validate
                $validator = Validator::make(Input::all(), $rules);
                if ($validator->fails()) {
                    return Response::json(array('bookingCreated' => false, 'errorMessages' => $validator->messages()));
                }
                //get input from bookings page
                $booking = new Booking();
                //if passes validation, continue
                //var_dump(Input::get('paymentType'));exit();
                $paymentType = Input::get('paymentType');
                if($paymentType == 'Bank Transfer'){
                    
                }else if($paymentType == 'Visa'){
                    
                }else if($paymentType == 'MasterCard'){
                    
                }else if($paymentType == 'Klik BCA'){
                    
                }else if($paymentType == 'BCA KlikPay'){
                    
                }else if($paymentType == 'Epay BRI'){
                    
                }else if($paymentType == 'CIMB Clicks'){
                    
                }                
                $date = new Date();
                $sequence = DB::select("SELECT nextval('public.roomtype_id_seq') as id");
                $booking->booking_id = "BID".$date->hour.$date->minute.$date->second.$sequence[0]->id;
                $booking->booking_date = $date->format('Y-m-d');
                $booking->booking_time = $date->format('H:i:s');
                $booking->booking_arrival_plan = Input::get('checkIn');
                $booking->booking_night = Input::get('nightStay');
                $booking->booking_adult = Input::get('numberOfGuest');
                $booking->booking_child = 0;
                $booking->booking_totalroom = Input::get('numberOfRoom');
                $booking->booking_totalprice = Input::get('totalprice');
                $booking->booking_fullprice = Input::get('totalprice');
                $booking->booking_reserve = true;
                $booking->booking_guaranteed = false;
                $booking->booking_approved = false;
                $booking->booking_cancelled = false;
                $booking->booking_expired = false;
//                var_dump($booking);exit();
                $booking->save();
            } catch (Exception $exc) {
                var_dump($exc->getMessage());
                return Response::json(array('bookingCreated' => false, 'message' => trans('syntara::bookings.messages.exception-catched'), 'messageType' => 'danger'));
            }
            return json_encode(array('bookingCreated' => true, 'redirectUrl' => URL::route('showBookingResult'), 'bookingId' => $booking->booking_id));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{   
            $this->layout = View::make('frontend.results.index-result')->with(array('bookingId' => $id));
            $this->layout->title = trans('syntara::bookings.success');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.booking_finished');
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
            //get bookings and occupancyfeatures
            $occupancy = Booking::find($id);
            //2. store the updated value to bookings table
            $occupancy->occupancy_description = Input::get('occupancy_description');
            if($occupancy->save()){
                return Response::json(array('occupancyUpdated' => true, 'message' => trans('syntara::bookings.messages.update-success'), 'messageType' => 'success'));
            }
            else 
            {
                return Response::json(array('occupancyUpdated' => false, 'message' => trans('syntara::bookings.messages.update-fail'), 'messageType' => 'danger'));
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
                $occupancy = Booking::find($id);
                //check whether the record exists or not
                if($occupancy){
                    $occupancy->delete();
                }
            }
            catch(Exception $e)
            {
                return Response::json(array('deleteBooking' => false, 'message' => trans('syntara::bookings.messages.not-found'), 'messageType' => 'danger'));
            }
            return Response::json(array('deleteBooking' => true, 'message' => trans('syntara::bookings.messages.remove-success'), 'messageType' => 'success'));
	}

}
