<?php

class Booking extends Eloquent
{
	/**
     * Model 'Booking' table
     * @var string
     */
	protected $table = 'booking';
	protected $primaryKey = 'booking_id';
        
        public $timestamps = false;        
}