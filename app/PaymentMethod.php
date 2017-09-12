<?php
namespace App;
use Eloquent;

class PaymentMethod extends Eloquent {

	protected $fillable = [
							'type',
							'name',
							'description',
							
						];
	protected $primaryKey = 'id';
	protected $table = 'payment_methods';   
}
