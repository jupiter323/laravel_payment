<?php
namespace App;
use Eloquent;

class Zip extends Eloquent {

	protected $fillable = [
							'zipcode',
							'latitude',
							'longitude',							
							'city',
							'state',
							'address_line_2',
							'city',
							'state',
							'county'							                                                      
						];
	protected $primaryKey = 'id';
	protected $table = 'zip';

}
