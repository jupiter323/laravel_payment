<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UploadCustomer implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        foreach($data as $value){
            $user = new \App\User;
            $user->username = $value['username'];
            $user->password = bcrypt($value['password']);
            $user->email = $value['email'];
            $user->status = 'active';
            $user->save();

            $role = \App\Role::whereName(config('constant.default_customer_role'))->first();
            $user->roles()->sync(isset($role) ? [$role->id] : []);

            $profile = new \App\Profile;
            $profile->first_name = $value['first_name'];
            $profile->last_name = $value['last_name'];
            $profile->date_of_birth = ($value['date_of_birth']) ? : null;
            $profile->date_of_anniversary = ($value['date_of_anniversary']) ? : null;
            $profile->phone = $value['phone'];

            $user->profile()->save($profile);
        }
    }
}
