<?php
namespace App;
use Eloquent;

class Currency extends Eloquent {

	protected $fillable = [
							'name',
							'symbol',
							'position',
							'decimal_place'
						];
	protected $primaryKey = 'id';
	protected $table = 'currencies';


    public function getDetailAttribute(){
        return $this->symbol.' ('.$this->name.')';
    }
}
