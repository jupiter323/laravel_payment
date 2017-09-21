<?php
namespace App;
use Eloquent;

class ItemPrice extends Eloquent {

	protected $fillable = [
							'item_id',
							'currency_id',
							'unit_price'
						];
	protected $primaryKey = 'id';
	protected $table = 'item_prices';

    public function item()
    {
        return $this->belongsTo('App\Item'); 
    }

    public function currency()
    {
        return $this->belongsTo('App\Currency'); 
    }
}
