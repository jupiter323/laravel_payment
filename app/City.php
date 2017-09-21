<?php
namespace App;
use Eloquent;

class City extends Eloquent {

	protected $fillable = [		
                         'city',		
						 'state',	
						 'code',	
						 'country',	
			     ];
	protected $primaryKey = 'id';
	protected $table = 'city';
}
