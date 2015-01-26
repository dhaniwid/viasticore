<?php

class Reservation extends Illuminate\Database\Eloquent\Model
{
	/**
     * Model 'RateAvailability' table
     * @var string
     */
	protected $table = 'roomavailability';
	protected $primaryKey = 'roomavailability_id';
        
        public $timestamps = false;
        
        public static function getQueryReservation($checkInDate, $checkOutDate, $totalQty, $roomQty)
        {
            return 
            DB::select('
                SELECT 
                        A.roomtype_id,
                        T.roomtype_name,
                        t.roomtype_description,
                        p.occupancy_id,
                        O.occupancy_description,
                        P.roomprice_rate,
                        t.roomimage_description,
                        a.roomavailability_number
                FROM roomavailability A
                LEFT JOIN (
                        select t.*, i.roomimage_description from roomtypes t
                        left join roomimages i
                        on t.roomtype_id = i.roomtype_id
                        and i.roomimage_primary = true
                ) T
                        ON A.roomtype_id = T.roomtype_id
                LEFT JOIN roomprices P
                        ON A.roomavailability_id = P.roomprice_datetime
                        AND A.roomavailability_date = P.ROOMPRICE_DATE
                        AND A.roomtype_id = P.roomtype_id
                LEFT JOIN occupancies O
                        ON P.occupancy_id = O.occupancy_id
                WHERE 1=1
                        AND A.roomavailability_date BETWEEN ? AND ?
                        AND A.roomavailability_number >= ?
                        AND T.roomtype_maxoccupancy >= ?
                GROUP BY
                        A.roomtype_id,
                        T.roomtype_name,
                        t.roomtype_description,
                        p.occupancy_id,
                        O.occupancy_description,
                        P.roomprice_rate,
                        t.roomimage_description,
                        a.roomavailability_number
                ORDER BY a.roomtype_id, p.occupancy_id', array($checkInDate, $checkOutDate, $totalQty, $roomQty));
        }        
}