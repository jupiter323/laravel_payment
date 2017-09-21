<?php
namespace App;
use Eloquent;

class State extends Eloquent {

	protected $fillable = [				         	
						 'state',	
						 'code',	
						 'country',	
			     ];
	protected $primaryKey = 'id';
	protected $table = 'state';
}
