
<?php
namespace App;
use Eloquent;

class Group extends Eloquent {

	protected $fillable = [
							'group_name'
							
							
						];
	protected $primaryKey = 'group_id';
	protected $table = 'companies_group';

}

