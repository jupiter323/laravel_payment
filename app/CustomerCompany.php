<?php
namespace App;
use Eloquent;

class CustomerCompany extends Eloquent {

	protected $fillable = [
							'cust_id',
							'company_id',
							
						];
	protected $primaryKey = 'id';
	protected $table = 'customer_company';

	
}
