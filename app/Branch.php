<?php
namespace App;
use Eloquent;

class Branch extends Eloquent {

	protected $fillable = [
						
'branch_code',
'branch_name',
'branch_main_officer_name',
'email',
'phone',
'street',
'location',
'country_id',
'state',
'city',
'location',
'zipcode',
'ext_num',
'int_num',
'neighboorhood','company_id'

                                                       
						];
	protected $primaryKey = 'id';
	protected $table = 'branch';

}

