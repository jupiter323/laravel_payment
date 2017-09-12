<?php
namespace App;
use Eloquent;

class UserUpload extends Eloquent {

	protected $fillable = [
							'user_id',
							'date',
							'filename'
						];
	protected $primaryKey = 'id';
	protected $table = 'user_uploads';

	public function user()
    {
        return $this->belongsTo('App\User');
    }
}
