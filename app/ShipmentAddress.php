<?php
namespace App;
use Eloquent;

class ShipmentAddress extends Eloquent {

	protected $fillable = [
							'shipment_address',
							'country_id',
							'ext_num',
							'int_num',
							'zipcode',
							'state',
							'city',							
							'neighboorhood',
							'street',

						];
	protected $primaryKey = 'id';
	protected $table = 'shipment';
}
