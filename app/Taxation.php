<?php
namespace App;
use Eloquent;

class Taxation extends Eloquent {

	protected $fillable = [
							'name',
							'description',
							'value'
						];
	protected $primaryKey = 'id';
	protected $table = 'taxations';

    public function getDetailAttribute(){
        return $this->name.' ('.round($this->value,5).')';
    }
}
