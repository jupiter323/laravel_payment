<?php
namespace App;
use Eloquent;

class IncomeCategory extends Eloquent {

	protected $fillable = [
							'name',
							'description'
						];
	protected $primaryKey = 'id';
	protected $table = 'income_categories';
}
