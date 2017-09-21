<?php
namespace App;
use Eloquent;

class CurrencyConversion extends Eloquent {

	protected $fillable = [
							'date',
							'rate',
							'currency_id'
						];
	protected $primaryKey = 'id';
	protected $table = 'currency_conversions';

	public function currency()
    {
        return $this->belongsTo('App\Currency');
    }
}
