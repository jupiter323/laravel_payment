<?php
namespace App;
use Eloquent;

class Item extends Eloquent {

	protected $fillable = [
							'item_category_id',
							'name',
							'unit',
                                                        'tax_required_name',
							'code',
                                                        'customer_code',
                                                        'tax_required_code',
							'description',
                                                        'tax_required_desc',
							'taxation_id',
							'discount'
						];
	protected $primaryKey = 'id';
	protected $table = 'items';

    public function taxation()
    {
        return $this->belongsTo('App\Taxation'); 
    }

    public function itemCategory()
    {
        return $this->belongsTo('App\ItemCategory'); 
    }
    public function unit()
    {
        return $this->belongsTo('App\Unit'); 
    }
    public function itemPrice()
    {
        return $this->hasMany('App\ItemPrice'); 
    }

    public function getFullItemNameAttribute(){
        return $this->name.' ('.$this->code.')';
    }
}
