<?php
namespace App;
use Eloquent;

class TaxationGroup extends Eloquent {

	protected $fillable = [
							
							'taxation_group_name',
							
						];
	protected $primaryKey = 'id';
	protected $table = 'taxation_group';

   
}
