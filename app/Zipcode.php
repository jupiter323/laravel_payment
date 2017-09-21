<?php
namespace App;
use Eloquent;

class Zipcode extends Eloquent {

	protected $fillable = [
				         'zipcode',		
                         'city',	
						 'location',	
						 'state',	
						 'country',	
			     ];
	protected $primaryKey = 'id';
	protected $table = 'zipcode';
}
