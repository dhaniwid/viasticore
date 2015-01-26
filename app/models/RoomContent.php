<?php

class RoomContent extends Eloquent
{
	/**
     * Model 'RoomContent' table
     * @var string
     */
	protected $table = 'room_contents';
	protected $primaryKey = 'roomtype_id';
        
        public $timestamps = false;
}