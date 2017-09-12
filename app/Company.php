<?php
namespace App;
use Eloquent;

class Company extends Eloquent {

	protected $fillable = [
							'name',
							'email',
							'website',
							'logo',
                                                        'email_logo',
							'phone',
							'address_line_1',
							'address_line_2',
							'city',
							'state',
							'zipcode',
							'country_id',
                                                        'internal_alias',
                                                        'tax_reg_name','tax_id','national_id','business_type','tax_regimen','private','public'
,'pass','ext_num','int_num','neighboorhood'
                                                       
						];
	protected $primaryKey = 'id';
	protected $table = 'companies';


public function company()
{
    return $this->hasMany('App\Company');
}

}
