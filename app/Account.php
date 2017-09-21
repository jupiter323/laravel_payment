<?php
namespace App;
use Eloquent;

class Account extends Eloquent {

	protected $fillable = [
							'type',
							'name',
							'opening_balance',
							'number',
							'bank_name',
							'branch_name',
							'branch_code',
							'description'
						];
	protected $primaryKey = 'id';
	protected $table = 'accounts';

    public function transaction()
    {
        return $this->hasMany('App\Transaction','account_id');
    }

    public function transfer()
    {
        return $this->hasMany('App\Transaction','from_account_id');
    }
}
