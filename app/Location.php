<?php
namespace App;
use Eloquent;

class Location extends Eloquent {

	protected $fillable = [		
                         'city',	
                         'location',							 
						 'state',	
						 'code',	
						 'country',	
			     ];
	protected $primaryKey = 'id';
	protected $table = 'location';
}
