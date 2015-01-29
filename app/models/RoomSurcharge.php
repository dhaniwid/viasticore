<?php

class RoomSurcharge extends Illuminate\Database\Eloquent\Model {

    /**
     * Model 'RoomPrices' table
     * @var string
     */
    protected $table = 'roomsurcharge';
    protected $primaryKey = 'rs_datetime';
    public $timestamps = false;

    public static function getQueryRoomSurcharge() {
        return 'select rs_date,rs_datetime,surcharge_id,roomtype_id,rs_price,rs_deleted,rs_optional,rs_pax,rs_netprice,rs_status from roomsurcharge order by rs_datetime,rs_date';
    }

    public static function getQueryRoomSurchargeDate() {
        return 'select rs_date,rs_datetime,surcharge_id,roomtype_id,rs_price,rs_deleted,rs_optional,rs_pax,rs_netprice,rs_status from roomsurcharge';
    }

}
