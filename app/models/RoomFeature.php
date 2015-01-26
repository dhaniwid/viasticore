<?php

class RoomFeature extends Eloquent
{
	/**
     * Model 'RoomFacility' table
     * @var string
     */
	protected $table = 'roomfeatures';
	protected $primaryKey = 'roomfeature_id';
        
        public $timestamps = false;
}