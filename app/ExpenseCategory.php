<?php
namespace App;
use Eloquent;

class ExpenseCategory extends Eloquent {

	protected $fillable = [
							'name',
							'description'
						];
	protected $primaryKey = 'id';
	protected $table = 'expense_categories';
}
