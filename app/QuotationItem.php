<?php
namespace App;
use Eloquent;

class QuotationItem extends Eloquent {

	protected $fillable = [
							'quotation_id',
							'item_id',
							'item_name',
							'item_quantity',
							'item_discount',
							'item_discount_type',
							'item_tax',
							'item_description'
						];
	protected $primaryKey = 'id';
	protected $table = 'quotation_items';
}
