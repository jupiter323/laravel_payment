<?php
namespace App;
use Eloquent;

class Quotation extends Eloquent {

	protected $fillable = [
							'subject',
							'description',
							'customer_id',
							'user_id',
							'currency_id',
							'date',
							'reference_number',
							'expiry_date',
							'line_item_tax',
							'line_item_discount',
							'line_item_description',
							'subtotal_tax',
							'subtotal_discount',
							'subtotal_shipping_and_handling',
							'item_type',
							'subtotal_tax_amount',
							'subtotal_discount_amount',
							'subtotal_discount_type',
							'subtotal_shipping_and_handling_amount',
							'customer_note',
							'tnc',
							'memo'
						];
	protected $primaryKey = 'id';
	protected $table = 'quotations';

	public function currency(){
		return $this->belongsTo('App\Currency');
	}

	public function QuotationItem(){
		return $this->hasMany('App\QuotationItem');
	}

	public function customer(){
		return $this->belongsTo('App\User','customer_id');
	}

	public function user(){
		return $this->belongsTo('App\User','user_id');
	}

    public function quotationDiscussion(){
        return $this->hasMany('\App\QuotationDiscussion','quotation_id');
    }
}
