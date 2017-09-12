<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable,EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profile()
    {
        return $this->hasOne('App\Profile');
    }

    public function routeNotificationForNexmo()
    {
        return $this->Profile->phone;
    }

    public function getFullNameAttribute(){
        return $this->Profile->first_name.' '.$this->Profile->last_name;
    }

    public function getDesignationNameAttribute(){
        return ($this->Profile->designation_id) ? ($this->Profile->Designation->name) : '';
    }

    public function getDepartmentNameAttribute(){
        return ($this->Profile->designation_id) ? ($this->Profile->Designation->Department->name) : '';
    }

    public function getDesignationWithDepartmentAttribute(){
        return ($this->Profile->designation_id) ? ($this->Profile->Designation->name.' '.trans('messages.in').' '.$this->Profile->Designation->Department->name) : '';
    }

    public function getNameWithDesignationAndDepartmentAttribute(){
        return $this->Profile->first_name.' '.$this->Profile->last_name.(
            ($this->Profile->designation_id) ? (' ('.$this->Profile->Designation->name.' '.trans('messages.in').' '.$this->Profile->Designation->Department->name.')') : ''
            );
    }

    public function getAddressAttribute(){
        return $this->Profile->address_line_1.' '.$this->Profile->address_line_2.' <br />'.
                        $this->Profile->city.' '.$this->Profile->state.' '.$this->Profile->zipcode.' '.((isset($this->Profile->country_id) ? config('country.'.$this->Profile->country_id) : ''));
    }

    public function customerGroup()
    {
        return $this->belongsToMany('App\CustomerGroup','customer_group_user','user_id','customer_group_id');
    }

  

}
