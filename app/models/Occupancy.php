<?php

class Occupancy extends Eloquent
{
	/**
     * Model 'Occupancy' table
     * @var string
     */
	protected $table = 'occupancies';
	protected $primaryKey = 'occupancy_id';
        
        public $timestamps = false;
}