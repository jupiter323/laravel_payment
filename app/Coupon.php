<?php
namespace App;
use Eloquent;

class Coupon extends Eloquent {

	protected $fillable = [
							'code',
							'name',
							'discount',
							'valid_from',
							'valid_to',
							'valid_day',
							'new_user',
							'maximum_use_count',
							'description',
							'user_id'
						];
	protected $primaryKey = 'id';
	protected $table = 'coupons';
}
