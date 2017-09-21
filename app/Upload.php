<?php
namespace App;
use Eloquent;

class Upload extends Eloquent {

	protected $fillable = [
							'user_id',
							'module',
							'upload_key'
						];
	protected $primaryKey = 'id';
	protected $table = 'uploads';

	public function user()
    {
        return $this->belongsTo('App\User');
    }
}
