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
            $roomTypes = RoomType::lists('roomtype_name', 'roomtype_id');        
            if(Request::ajax())
            {
                $html = View::make('roomprices.list-roomprices')->with('roomprices', $roomprices)
                        ->with('roomtypes',$roomTypes)->render();
                return Response::json(array('html' => $html));
            }
            
            $this->layout = View::make('roomprices.index-roomprice')
                    ->with('roomtypes',$roomTypes)->with('roomtype_id','')
                    ->with('start_date',null)->with('end_date',null)
                    ->with('roomprices', $roomprices)->with('roompricedate', $roompricedate);
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
        
        /*public function update(){
            $test = Input::get('Single');
            print_r($test);
        }*/
        
        /**
         * 
         */
        public function search(){
            $rules = array(
                'start_date' => array('required', 'date_format:"d-m-Y"', 'before:end_date'),
                'end_date' => array('required', 'date_format:"d-m-Y"', 'after:start_date'),
                'roomtype_id' => array('required')
            );
            $messages = array(
                'start_date.required' => 'Please select Start Date',
                'end_date.required' => 'Please select End Date',
                'required' => 'The  :attribute is required.',
            );
            $validator = Validator::make(Input::all(), $rules, $messages);
            if ($validator->fails()) {
                return Response::json(array('roomPriceCreated' => false, 'errorMessages' => $validator->messages()));
            }
            
            $roomtypes = RoomType::lists('roomtype_name', 'roomtype_id');
            $occ_master = Occupancy::orderBy('occupancy_id')->get();
            $roomtype_id = Input::get('roomtype_id');
            $param_price_from = Input::get('start_date');
            $param_price_to = Input::get('end_date');            
            $price_from = date("Y-m-d", strtotime($param_price_from));
            $price_to = date("Y-m-d", strtotime($param_price_to));
            
            //ambil room type, cek berapa occupancies
            $room_occ = 0;
            $room_types = RoomType::where('roomtype_id','=',$roomtype_id)->get();
            foreach($room_types as $room){
                $room_occ = $room->roomtype_maxoccupancy;
            }
            
            //buat blank obj buat tanggal yg kosong
            $blankRoomPriceObj = new stdClass();
            $blankRoomPriceObj->roomprice_rate = 0;
            $blankRoomPriceObj->roomprice_breakfast = 0;                    
            $blankRoomPriceObj->roomprice_extrabed = 0;
            $blankRoomPriceObj->roomprice_status = '';
            $blankRoomPriceObj->roomprice_day = '';

            $priceList = array();
            for ($x = 0; $x < $room_occ; $x++) {
                $occupancy_id = $x+1;
                $roomprice = RoomPrice::where('roomtype_id', '=', $roomtype_id)
                            ->where('roomprice_date', '>=', $price_from)
                            ->where('roomprice_date', '<=', $price_to)
                            ->where('occupancy_id', '=', $occupancy_id)
                            ->orderBy('roomprice_date')->get();
                
                //bikin map, keynya date buat mapping ke 
                //range tanggal dari user
                $array_rp = array();
                foreach($roomprice as $rp){
                    $roomPriceObj = new stdClass();
                    $roomPriceObj->roomprice_rate = $rp->roomprice_rate;
                    $roomPriceObj->roomprice_breakfast = 
                            empty($rp->roomprice_breakfast)?0:$rp->roomprice_breakfast;
                    $roomPriceObj->roomprice_extrabed = $rp->roomprice_extrabed;
                    $roomPriceObj->roomprice_date = $rp->roomprice_date;
                    $roomPriceObj->roomprice_status = $rp->roomprice_status;
                    $array_rp[$rp->roomprice_date] = $roomPriceObj;
                }
                
                //ditampilkan perhari, jika ada yang null (price belum tersedia)
                //ditampilkan nol
                //bikin array perhari dari range yang dikasih ketika search biar 
                //di view tinggal nampil
                $endDate = new DateTime($param_price_to);
                $endDate = $endDate->modify( '+1 day' );
                $period = new DatePeriod(new DateTime($param_price_from), 
                        new DateInterval('P1D'), $endDate);
                foreach($period as $day){
                    $priceList[$day->format("Y-m-d")][$occupancy_id] = 
                            empty($array_rp[$day->format("Y-m-d")])?$blankRoomPriceObj:$array_rp[$day->format("Y-m-d")];
                }
                
            }           
            
            //tampilan
            $occText = array();
            foreach($occ_master as $occ){
                array_push($occText,$occ->occupancy_description);
            }
            $this->layout = View::make('roomprices.index-roomprice', array('pricelist' => $priceList, 
                'roomtypes' => $roomtypes,'roomtype_id'=>$roomtype_id,
                'start_date'=>$param_price_from,'end_date'=>$param_price_to,
                'room_occ'=>$room_occ,'occText'=>$occText,'listView'=>1));            
            $this->layout->title = trans('syntara::roomprices.edit');
            $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.edit_room_price');
        }
        
        public function edit(){
            $rules = array(
                'start_date' => array('required', 'date_format:"d-m-Y"', 'before:end_date'),
                'end_date' => array('required', 'date_format:"d-m-Y"', 'after:start_date'),
                'roomtype_id' => array('required')
            );
            $messages = array(
                'start_date.required' => 'Please select Start Date',
                'end_date.required' => 'Please select End Date',
                'required' => 'The  :attribute is required.',
            );
            $validator = Validator::make(Input::all(), $rules, $messages);
            if ($validator->fails()) {
                return Response::json(array('roomPriceCreated' => false, 'errorMessages' => $validator->messages()));
            }


            $startDate = new DateTime(Input::get('start_date'));
            $endDate = new DateTime(Input::get('end_date'));
            $roomtype_id = Input::get('roomtype_id');
            
            $roomtypes = RoomType::where('roomtype_id', '=',$roomtype_id)->get();
            $room_occ = 0;
            foreach($roomtypes as $room){
                $room_occ = $room->roomtype_maxoccupancy;
            }
            $occText = array();
            $occ_master = Occupancy::orderBy('occupancy_id')->get();
            for($counter=0;$counter<$room_occ;$counter++){
                array_push($occText,$occ_master[$counter]->occupancy_description);
            }
            $now = new DateTime();
            /*$test = Input::get('Double');
            print_r($test);*/
            DB::beginTransaction();
            try{
                for($counter=0;$counter<$room_occ;$counter++){
                    //delete semua dulu, baru insert
                    RoomPrice::where('roomprice_date', '>=', $startDate)->
                            where('roomtype_id', '=', $roomtype_id)->
                            where('roomprice_date', '<=', $endDate)->
                            where('occupancy_id','=',($counter+1))->
                            delete();
                    
                    $edit_data = Input::get($occ_master[$counter]->occupancy_description);
                    foreach($edit_data as $key=>$data){
                        /*print_r($data);
                        echo " key ".$key." ".$occ_master[$counter]->occupancy_description."<BR>";*/
                        $roomPrice = new RoomPrice();
                        $roomPrice->roomprice_datetime = $now;           
                        $roomPrice->roomprice_date = $key; 
                        $roomPrice->roomprice_day = '';
                        $roomPrice->occupancy_id = $counter+1;
                        $roomPrice->roomtype_id = $roomtype_id;
                        $roomPrice->roomprice_rate = $data['rate'];
                        $roomPrice->roomprice_breakfast = $data['breakfast'];
                        $roomPrice->roomprice_extrabed = empty($data['extrabed'])?0:$data['extrabed'];
                        $roomPrice->roomprice_status = empty($data['status'])?null:$data['status'];
                        $roomPrice->save();
                    }
                    
                }
                
            } catch (Exception $ex) {
                DB::rollback();
                $msg = $ex->getMessage();
                return json_encode(array('roomPriceUpdated' => false, 
                    'message' => $msg, 'messageType' => 'danger', 
                    'redirectUrl' => URL::route('listRoomPrices')));
            }
            DB::commit();
            return json_encode(array('roomPriceUpdated' => true, 
                'message' => trans('syntara::roomprices.messages.update-success'), 
                'messageType' => 'success','redirectUrl' => URL::route('listRoomPrices')));
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
                $messages['min'] = 'The :attribute quintuple must be at least '.number_format($roomtype->roomtype_lowestprice);
                $roomtype_occupancy = $roomtype->roomtype_maxoccupancy;
                $occupancies = Occupancy::orderBy('occupancy_id', 'asc')->paginate($roomtype_occupancy);
                                
                //validate occupancy description manually
                foreach($occupancies as $occupancy){
                    $field_name = ($occupancy->occupancy_description);
                    $rules[$field_name] = array('required','integer','min:'.$roomtype->roomtype_lowestprice);
                }
;
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
                                $roomPrice->roomprice_date = $date->format("Y-m-d"); 
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
                            $roomAvailability->roomavailability_date = $date->format("Y-m-d"); 
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
