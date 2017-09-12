<?php
namespace App;
use Eloquent;

class CustomerGroup extends Eloquent {

	protected $fillable = [
							'name',
							'description'
						];
	protected $primaryKey = 'id';
	protected $table = 'customer_groups';

	public function user()
    {
        return $this->belongsToMany('App\User','customer_group_user','customer_group_id','user_id');
    }
}
