<?php
namespace App;
use Eloquent;

class ItemCategory extends Eloquent {

	protected $fillable = [
							'name',
							'type',
							'description'
						];
	protected $primaryKey = 'id';
	protected $table = 'item_categories';
}
