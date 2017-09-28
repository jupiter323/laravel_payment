<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 22/09/17
 * Time: 19:08
 */

namespace App;
use Eloquent;

class Cfdi extends Eloquent {

    protected $fillable = [
        'version',
        'txt',
        'xml',
        'pdf'
    ];
    protected $primaryKey = 'id';
    protected $table = 'accounts';

    public function transaction()
    {
        return $this->hasMany('App\Transaction','account_id');
    }

    public function transfer()
    {
        return $this->hasMany('App\Transaction','from_account_id');
    }
}
