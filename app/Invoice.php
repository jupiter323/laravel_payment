<?php
namespace App;
use Eloquent;

class Invoice extends Eloquent {

	protected $fillable = [
							'customer_id',
							'user_id',
							'currency_id',
							'date',
							'reference_number',
							'due_date',
							'due_date_detail',
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
                                                        'subtotal1',
                                                        'subtotal2',
                                                        'subtotal3',
							'customer_note',
							'tnc',
							'doc_type',
							'shipment_address',
							'payment_method',
                                                        'payment_split',
							'memo'
						];
	protected $primaryKey = 'id';
	protected $table = 'invoices';

	public function recurringInvoice(){
		return $this->hasMany('App\Invoice','recurring_invoice_id','id');
	}

	public function currency(){
		return $this->belongsTo('App\Currency');
	}

	public function InvoiceItem(){
		return $this->hasMany('App\InvoiceItem');
	}

	public function customer(){
		return $this->belongsTo('App\User','customer_id');
	}

	public function user(){
		return $this->belongsTo('App\User','user_id');
	}

	public function transaction(){
		return $this->hasMany('App\Transaction');
	}
}
