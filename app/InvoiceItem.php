<?php
namespace App;
use Eloquent;

class InvoiceItem extends Eloquent {

	protected $fillable = [
							'invoice_id',
							'item_id',
							'item_name',
							'item_quantity',
							'item_discount',
							'item_discount_type',							
							'item_tax',
							'item_description',
                                                        'subtotal1',
                                                        'subtotal2',
                                                        'subtotal3',     
                                                        'unit',

						];
	protected $primaryKey = 'id';
	protected $table = 'invoice_items';
}
