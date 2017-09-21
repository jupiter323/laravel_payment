<?php
namespace App;
use Eloquent;

class Campaign extends Eloquent {

	protected $fillable = [
							'subject',
							'body',
							'recipients',
							'sender',
							'inclusion',
							'exclusion',
							'attachments',
							'staff'
						];
	protected $primaryKey = 'id';
	protected $table = 'campaigns';
	
	public function user()
    {
        return $this->belongsTo('App\User');
    }
}
