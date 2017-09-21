<?php
namespace App;
use Eloquent;

class Taxregimen extends Eloquent {

	protected $fillable = [
							'tax_regimen_name',
							                                                       
						];
	protected $primaryKey = 'tr_id';
	protected $table = 'tax_regimen';

}
