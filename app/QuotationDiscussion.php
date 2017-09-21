<?php
namespace App;
use Eloquent;

class QuotationDiscussion extends Eloquent {

	protected $fillable = [
							'user_id',
							'quotation_id',
							'message'
						];
	protected $primaryKey = 'id';
	protected $table = 'quotation_discussions';

	public function user()
    {
        return $this->belongsTo('App\User');
    }

	public function quotation()
    {
        return $this->belongsTo('App\Quotation');
    }

    protected function reply()
    {
        return $this->hasMany('App\QuotationDiscussion','reply_id','id');
    }
}
