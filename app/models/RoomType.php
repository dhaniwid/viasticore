<?php

class RoomType extends Illuminate\Database\Eloquent\Model
{
	/**
     * Model 'RoomFacility' table
     * @var string
     */
	protected $table = 'roomtypes';
	protected $primaryKey = 'roomtype_id';
        protected $fillable = array('roomtype_name', 'roomtype_description', 'roomtype_size', 'roomtype_maxoccupancy',
            'roomtype_minimumavailability', 'roomtype_extrabed', 'roomtype_activestatus', 'roomtype_petallowed', 'roomtype_lowestprice',
            'roomtype_statusdeleted', 'roomtype_extrabedprice', 'roomtype_seq');
        public $timestamps = false;
}