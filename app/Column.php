<?php
namespace App;
use Eloquent;

class Column extends Eloquent {

	protected $fillable = [
							'form',
							'name',
							'position',
							'after_field',
							'minlength',
							'maxlength',
                                                        'default_value',
							'title',
							'type',
							'options',
							'is_required',
                                                        'active',
						];
	protected $primaryKey = 'id';
	protected $table = 'column';

	
}
