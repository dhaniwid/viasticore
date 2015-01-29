<?php

class Surcharge extends Eloquent
{
	/**
     * Model 'Surcharge' table
     * @var string
     */
	protected $table = 'surcharge';
	protected $primaryKey = 'surcharge_id';
        protected $fillable = array('surcharge_id','surcharge_description');
        public $timestamps = false;      
}