<?php

class RoomPrice extends Illuminate\Database\Eloquent\Model
{
	/**
     * Model 'RoomPrices' table
     * @var string
     */
	protected $table = 'roomprices';
	protected $primaryKey = 'roomprice_datetime';
        
        public $timestamps = false;
        
        protected $fillable = array('roomprice_datetime', 'roomprice_date', 'occupancy_id', 'roomtype_id',
            'roomprice_rate', 'roomprice_breakfast', 'roomprice_extrabed', 'roomprice_status', 'roomprice_day');
        
        public static function getQueryRoomPrice()
        {
            return 'SELECT
				r.roomprice_datetime,
				\'\' as roomprice_date,
				r.roomtype_id,
				T .roomtype_name,
				r.occupancy_id,
				o.occupancy_description,
				r.roomprice_rate,
				r.roomprice_breakfast,
				r.roomprice_extrabed,
				r.roomprice_status,
				x.max_occupancy,
				x.start_date,
				x.end_date
FROM
				roomprices r
LEFT JOIN roomtypes T ON r.roomtype_id = T .roomtype_id
LEFT JOIN occupancies o ON r.occupancy_id = o.occupancy_id
LEFT JOIN (
				SELECT 
					p.roomprice_datetime,
					MAX (P .occupancy_id) AS max_occupancy,
					MIN (P .roomprice_date)
					 AS start_date,
					MAX (P .roomprice_date)  AS end_date
				FROM
					roomprices P
				WHERE
					1 = 1
				group by p.roomprice_datetime
				order by p.roomprice_datetime
				
) x ON 1 = 1 AND R.roomprice_datetime = x.roomprice_datetime
GROUP BY
				r.roomprice_datetime,
				r.roomtype_id,
				T .roomtype_name,
				r.occupancy_id,
				o.occupancy_description,
				r.roomprice_rate,
				r.roomprice_breakfast,
				r.roomprice_extrabed,
				r.roomprice_status,
				x.max_occupancy,
				x.start_date,
				x.end_date
ORDER BY
				r.roomprice_datetime, x.start_date, x.end_date, r.occupancy_id';
        }
        
        public static function getQueryRoomPriceDate()
        {
            return 'SELECT
                        r.roomprice_datetime,
                        r.roomprice_day,
                        r.roomtype_id,
                        r.occupancy_id
                    FROM
                        roomprices r
                    group by 
                        r.roomprice_datetime,
                        r.roomprice_day,
                        r.roomtype_id,
                        r.occupancy_id
                    ORDER BY
                        r.roomprice_day,
                        r.roomprice_datetime,		
                        r.occupancy_id,
                        r.roomtype_id';
        }
}