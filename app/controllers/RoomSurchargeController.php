<?php

class RoomSurchargeController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        // get all the roomsurcharge data
        $rs = RoomSurcharge::join("surcharge", "surcharge.surcharge_id", "=", "roomsurcharge.surcharge_id")
                        ->join("roomtypes", "roomtypes.roomtype_id", "=", "roomsurcharge.roomtype_id")
                        ->orderBy('rs_datetime', 'asc')->orderBy('rs_date', 'asc')->get();
        $roomsurcharges = $this->getRoomSurcharge($rs);

        if (Request::ajax()) {
            $html = View::make('roomsurcharge.list-roomsurcharge')->with('roomsurcharge', $roomsurcharges)->render();

            return Response::json(array('html' => $html, 'redirectUrl' => URL::route('newRoomPrice')));
        }

        $this->layout = View::make('roomsurcharge.index-roomsurcharge')->
                with('roomsurcharge', $roomsurcharges);
        $this->layout->title = trans('syntara::roomsurcharge.list');
        $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.room_surcharge');
    }

    /**
     * 
     * @param type $rs
     * @return array
     */
    public function getRoomSurcharge($rs) {
        $prev_rs_datetime = 0;
        $prev_sid = 0;
        $surcharge_list = array();
        $dow = array();
        $surcharge_row = '';
        foreach ($rs as $row) {

            //digroup berdasarkan surcharge id dan rs_datetime(waktu dibuat)
            if ($prev_rs_datetime !== $row->rs_datetime &&
                    $prev_sid !== $row->surcharge_id) {
                if ($surcharge_row !== '') {
                    array_push($surcharge_list, $surcharge_row);
                }
                $dow = array(0, 0, 0, 0, 0, 0, 0); //day of week
                $surcharge_row = new stdClass();
                $prev_rs_datetime = $row->rs_datetime;
                $prev_sid = $row->surcharge_id;
                $surcharge_row->datetime = $row->rs_datetime;
                $surcharge_row->roomtype_name = $row->roomtype_name;
                $surcharge_row->roomtype_id = $row->roomtype_id;
                $surcharge_row->surcharge_id = $row->surcharge_id;
                $surcharge_row->start_date = $row->rs_date;
                $surcharge_row->end_date = $row->rs_date;
                $surcharge_row->surcharge_desc = $row->surcharge_description;
                $surcharge_row->optional = $row->rs_optional == 1 ? 't' : 'f';
                $surcharge_row->pax = $row->rs_pax == 1 ? 't' : 'f';
                $surcharge_row->netprice = $row->rs_netprice;
                $surcharge_row->dow = $dow;
            }

            //dapetin day of week, 0 -> sunday
            $dw = date("w", strtotime($row->rs_date));
            $surcharge_row->dow[$dw] = 1;

            //disimpan per row, jadi row baru itu end date terakhir
            $surcharge_row->end_date = $row->rs_date;
        }
        if ($surcharge_row !== '') {
            array_push($surcharge_list, $surcharge_row);
        }
        /* foreach($surcharge_list as $list){
          print_r($list);echo "<BR>";
          } */
        //exit();
        return $surcharge_list;
    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        $surcharges = Surcharge::lists('surcharge_description', 'surcharge_id');
        $roomtypes = RoomType::lists('roomtype_name', 'roomtype_id');
        $this->layout = View::make('roomsurcharge.new-roomsurcharge', array('surcharge' => $surcharges, 'roomtypes' => $roomtypes));
        $this->layout->title = trans('syntara::roomsurcharge.new');
        $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.create_room_surcharge');
    }

    /**
     * 
     * @param type $startDate
     * @param type $endDatefromUser
     * @param type $daysChecked
     * @param type $surcharge_id
     * @param type $roomtype_id
     * @param type $rs_price
     * @param type $rs_optional
     * @param type $rs_pax
     * @param type $rs_netprice
     * @throws Exception
     */
    public function insertNewRoomSurcharge($startDate, $endDatefromUser, $daysChecked, 
            $surcharge_id, $roomtype_id, $rs_price, $rs_optional, $rs_pax, $rs_netprice,$datetime) {        
        $endDate = $endDatefromUser->modify('+1 day');
        $period = new DatePeriod($startDate, new DateInterval('P1D'), $endDate);        
        try {
            foreach ($period as $date) {
                foreach ($daysChecked as $day) {
                    if ($date->format("D") == $day) {
                        $roomSurcharge = new RoomSurcharge();
                        $roomSurcharge->rs_date = $date->format("Y-m-d");
                        $roomSurcharge->rs_datetime = $datetime;
                        $roomSurcharge->surcharge_id = $surcharge_id;
                        $roomSurcharge->roomtype_id = $roomtype_id;
                        $roomSurcharge->rs_price = $rs_price;
                        $roomSurcharge->rs_deleted = 'f';
                        $roomSurcharge->rs_optional = $rs_optional === 'optional' ? 't' : 'f';
                        $roomSurcharge->rs_pax = $rs_pax === 'perpax' ? 't' : 'f';
                        $roomSurcharge->rs_netprice = $rs_netprice;
                        $roomSurcharge->rs_status = 't';                        
                        //print_r($roomSurcharge);
                        $roomSurcharge->save();
                    }
                }
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * 
     * @return hasil validasi
     */
    public function validatorCreateUpdate() {
        //validasi
        //akan mengembalikan message error jika validasi gagal,
        // dipanggil dari AJAX dan cukup mengembalikan Response::json                
        $rules = array(
            'start_date' => array('required', 'date_format:"d-m-Y"', 'before:end_date'),
            'end_date' => array('required', 'date_format:"d-m-Y"', 'after:start_date'),
            'days' => array('required'),
            'roomtype_name' => array('required'),
            'surcharge' => array('required'),
            'Price' => array('required')
        );
        $messages = array(
            'days.required' => 'Please select at least one day',
            'start_date.required' => 'Please select Start Date',
            'end_date.required' => 'Please select End Date',
            'roomtype_name.required' => 'The room type is required.',
            'surcarge.required' => 'The surcarge is required.',
            'Price.required' => 'The Price is required.',
        );
        $validator = Validator::make(Input::all(), $rules, $messages);
        return $validator;
    }
    
    /**
     * 
     * @param type $datetime
     * @param type $surcharge_id
     * @param type $roomtype_id
     * @param type $end_date
     */
    public function edit($datetime,$surcharge_id,$roomtype_id) {
        $rs = RoomSurcharge::where("surcharge_id", "=", $surcharge_id)
                        ->where("rs_datetime", "=", $datetime)
                        ->where("roomtype_id","=", $roomtype_id)->orderBy('rs_date', 'asc')
                        ->get();
        $roomsurcharges = $this->getRoomSurcharge($rs);
        //print_r($roomsurcharges[0]);exit();
        $surcharges = Surcharge::lists('surcharge_description', 'surcharge_id');
       // print_r($surcharges);exit();
        $roomtypes = RoomType::lists('roomtype_name', 'roomtype_id');
        $this->layout = View::make('roomsurcharge.edit-roomsurcharge', 
                array('surcharge' => $surcharges, 'roomtypes' => $roomtypes,
                    'roomsurcharges'=> $roomsurcharges[0],'old_sur_id'=>$surcharge_id,
                    'old_datetime'=>$datetime,'old_roomtype_id'=>$roomtype_id));
        $this->layout->title = trans('syntara::roomsurcharge.edit');
        $this->layout->breadcrumb = Config::get('syntara::breadcrumbs.room_surcharge_edit');
    }
    
    /**
     * 
     * @return type
     */
    public function update() {
        try {
            //validasi            
            $validator = $this->validatorCreateUpdate();
            if ($validator->fails()) {
                return Response::json(array('roomSurchargeCreated' => false, 'errorMessages' => $validator->messages()));
            }
            //validasi selesai                 
            $startDate = new DateTime(Input::get('start_date'));
            $endDate = new DateTime(Input::get('end_date'));
            $daysChecked = Input::get('days');
            $surcharge_id = Input::get('surcharge');
            $roomtype_id = Input::get('roomtype_name');
            $rs_price = Input::get('Price');
            $rs_optional = Input::get('optional_compulsary');
            $rs_pax = Input::get('perpax_perroom');
            $rs_netprice = Input::get('Price');
            $datetime = Input::get('old_datetime');
            $old_sur_id = Input::get('old_sur_id');
            $old_roomtype_id = Input::get('old_roomtype_id');            

            //delete dulu semua
            RoomSurcharge::where('rs_datetime', '=', $datetime)->where('surcharge_id', '=', $old_sur_id)->
                    where('roomtype_id', '=', $old_roomtype_id)->delete();
            
            //lalu insert
            $this->insertNewRoomSurcharge($startDate, $endDate, $daysChecked, $surcharge_id, $roomtype_id, $rs_price, $rs_optional, $rs_pax, $rs_netprice,$datetime);
        } catch (Exception $ex) {
            if ($exc->getCode() === '23505') {
                $msg = trans('syntara::roomsurcharge.messages.exists');
            } else {
                $msg = $exc->getMessage();
            }
            return json_encode(array('roomSurchargeCreated' => false, 'message' => $msg, 'messageType' => 'danger', 'redirectUrl' => URL::route('listRoomSurcharge')));
        }
        return json_encode(array('roomSurchargeCreated' => true, 'message' => trans('syntara::roomsurcharge.messages.update-success'), 'messageType' => 'success','redirectUrl' => URL::route('listRoomSurcharge')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        try {
            //validasi            
            $validator = $this->validatorCreateUpdate();
            if ($validator->fails()) {
                return Response::json(array('roomSurchargeCreated' => false, 'errorMessages' => $validator->messages()));
            }
            //validasi selesai            
            $startDate = new DateTime(Input::get('start_date'));
            $endDatefromUser = new DateTime(Input::get('end_date'));
            $daysChecked = Input::get('days');
            $surcharge_id = Input::get('surcharge');
            $roomtype_id = Input::get('roomtype_name');
            $rs_price = Input::get('Price');
            $rs_optional = Input::get('optional_compulsary');
            $rs_pax = Input::get('perpax_perroom');
            $rs_netprice = Input::get('Price');
            //room surcharge ketika create hanya pilih start dan end
            //tapi di insert menjadi perhari, makanya ambil range dari date tsbt
            //terus masukin satu-satu
            //jika menggunakan dateinterval, end date ga termasuk, makanya tambahin 1
            
            $now = new DateTime();
            $this->insertNewRoomSurcharge($startDate, $endDatefromUser, $daysChecked, $surcharge_id, $roomtype_id, $rs_price, $rs_optional, $rs_pax, $rs_netprice,$now);
        } catch (Exception $exc) {
            if ($exc->getCode() === '23505') {
                $msg = trans('syntara::roomsurcharge.messages.exists');
            } else {
                $msg = $exc->getMessage();
            }
            return json_encode(array('roomSurchargeCreated' => false, 'message' => $msg, 'messageType' => 'danger', 'redirectUrl' => URL::route('listRoomSurcharge')));
        }
        return json_encode(array('roomSurchargeCreated' => true, 'redirectUrl' => URL::route('listRoomSurcharge')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $date,$surcharge_id,$room_type_id seharusnya unik
     * @return Response
     */
    //public function deleteRoomSurcharge($date,$surcharge_id,$room_type_id){
    public function deleteRoomSurcharge($param) {
        try {
            $key = explode("|", $param);
            $date = $key[0];
            $surcharge_id = $key[1];
            $room_type_id = $key[2];
            RoomSurcharge::where('rs_datetime', '=', $date)->where('surcharge_id', '=', $surcharge_id)->
                    where('roomtype_id', '=', $room_type_id)->delete();
        } catch (Exception $e) {
            return Response::json(array('deleteRoomSurcharge' => false, 'message' => $e->getMessage(), 'messageType' => 'danger'));
        }
        return Response::json(array('deleteRoomSurcharge' => true, 'message' => trans('syntara::roomsurcharge.messages.remove-success'), 'messageType' => 'success'));
    }

}
