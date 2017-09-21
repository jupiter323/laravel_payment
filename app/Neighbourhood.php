<?php
namespace App;
use Eloquent;

class Neighbourhood extends Eloquent {

	protected $fillable = [
				'name',		
                                'code',	
                                'zipcode',	
			     ];
	protected $primaryKey = 'id';
	protected $table = 'neighbourhood';
}
