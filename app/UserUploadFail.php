<?php
namespace App;
use Eloquent;

class UserUploadFail extends Eloquent {

	protected $fillable = [
							'user_upload_id'
						];
	protected $primaryKey = 'id';
	protected $table = 'user_upload_fails';
	public $timestamps = false;

	public function userUpload()
    {
        return $this->belongsTo('App\UserUpload');
    }
}
