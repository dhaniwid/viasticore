<?php

class RoomImage extends Eloquent
{
	/**
     * Model 'RoomContent' table
     * @var string
     */
	protected $table = 'roomimages';
        protected $primaryKey= 'roomtype_id';
        
        public $timestamps = false;
}