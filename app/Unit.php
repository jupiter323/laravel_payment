<?php
namespace App;
use Eloquent;

class Unit extends Eloquent {

	protected $fillable = [
							'name',
							'active'
						];
	protected $primaryKey = 'id';
	protected $table = 'unit';
}
