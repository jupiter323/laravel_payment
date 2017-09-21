<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use App\Notifications\ActivationToken;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */
    use \App\Http\Controllers\BasicController;
    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest','feature_available:enable_user_registration'])->only('showRegistrationForm');
    }

    public function showRegistrationForm()
    {
        $assets = ['recaptcha'];
        return view('auth.register',compact('assets'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $validation_messages = [
            'user.regex' => trans('messages.username_rules'),
            'password.regex' => trans('messages.password_rules'),
        ];

        $rules = [
            'email' => 'required|email|max:255|unique:users',
           'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'username' => 'required|min:4|max:255|unique:users|'.usernameRule(),
            'password' => 'required|min:6|confirmed|'.passwordRule(),
            'password_confirmation' => 'required',
            'designation_id' => 'sometimes|required',
            'role_id' => 'sometimes|required',
        ];

        $niceNames = array();

        if(config('config.enable_tnc') && !\Auth::check()){
            $rules['tnc'] = 'accepted';
            $niceNames = [
                'tnc' => 'terms and conditions'
            ];
        }

        $validator = Validator::make($data, $rules,$validation_messages);
        $validator->setAttributeNames($niceNames); 

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        if(config('config.enable_email_verification') && !\Auth::check()){
            $activation_token = randomString(30);
            $user->activation_token = $activation_token;
            $user->status = 'pending_activation';
            $user->save();
        } elseif(config('config.enable_account_approval') && !\Auth::check()) {
            $user->status = 'pending_approval';
            $user->save();
        } else {
            $user->status = 'active';
            $user->save();
        }

        return $user;
    }

    public function register(Request $request)
    {
        
        if(!\App\Role::whereIsDefault(1)->count() && !\Auth::check())
            return response()->json(['message' => trans('messages.no_default_role_for_user'), 'status' => 'error']);

        $this->validator($request->all())->validate();

        if(config('config.enable_recaptcha') && config('config.enable_recaptcha_registration') && !\Auth::check()){
            $gresponse = $this->recaptchaResponse($request);
            if(!$gresponse['success'])
                return response()->json(['message' => trans('messages.verify_recaptcha'), 'status' => 'error']);
        }

        $validation = validateCustomField('user-registration-form',$request);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        event(new Registered($user = $this->create($request->all())));

        $role = \App\Role::whereIsDefault(1)->first();
        $user->roles()->sync(($request->input('role_id')) ? explode(',',$request->input('role_id')) : (isset($role) ? [$role->id] : []));

        $user->customerGroup()->sync(($request->input('customer_group_id')) ? $request->input('customer_group_id') : []);

        $profile = new \App\Profile;
        $profile->designation_id = ($request->input('designation_id')) ? : null;
        $profile->first_name = $request->input('first_name');
        $profile->last_name = $request->input('last_name');
        $profile->address_line_1 = ($request->has('address_line_1')) ? $request->input('address_line_1') : null;
        $profile->address_line_2 = ($request->has('address_line_2')) ? $request->input('address_line_2') : null;
        $profile->city = ($request->has('city')) ? $request->input('city') : null;
        $profile->state = ($request->has('state')) ? $request->input('state') : null;
        $profile->zipcode = ($request->has('zipcode')) ? $request->input('zipcode') : null;
        $profile->country_id = ($request->has('country_id')) ? $request->input('country_id') : null;
        $profile->company_id = ($request->has('company_id')) ? $request->input('company_id') : null;
$profile->internal_alias= ($request->has('internal_alias')) ? $request->input('internal_alias') : null;
$profile->tax_reg_name= ($request->has('tax_reg_name')) ? $request->input('tax_reg_name') : null;
$profile->tax_id= ($request->has('tax_id')) ? $request->input('tax_id') : null;
$profile->national_id= ($request->has('national_id')) ? $request->input('national_id') : null;
$profile->business_type= ($request->has('business_type')) ? $request->input('business_type') : null;
$profile->neighboorhood= ($request->has('neighboorhood')) ? $request->input('neighboorhood') : null;
$profile->int_num= ($request->has('int_num')) ? $request->input('int_num') : null;
$profile->ext_num= ($request->has('ext_num')) ? $request->input('ext_num') : null;
$profile->position= ($request->has('position')) ? $request->input('position') : null;
$profile->contact_name= ($request->has('contact_name')) ? $request->input('contact_name') : null;



        $user->profile()->save($profile);
        
        if(config('config.enable_email_verification') && !\Auth::check())
            $user->notify(new ActivationToken($user));

        if($request->has('send_welcome_email')){
            $template_category = ($user->hasRole(config('constant.default_customer_role'))) ? 'welcome-email-customer' : 'welcome-email-staff';

            $mail_data = $this->templateContent(['slug' => $template_category,'user' => $user,'password' => $request->input('password')]);

            if(count($mail_data)){
                $mail['email'] = $user->email;
                $mail['subject'] = $mail_data['subject'];
                $body = $mail_data['body'];
                \Mail::send('emails.email', compact('body'), function($message) use ($mail){
                    $message->to($mail['email'])->subject($mail['subject']);
                });
                $this->logEmail(array('to' => $mail['email'],'subject' => $mail['subject'],'body' => $body,'module' => 'user','module_id' =>$user->id));
            }
        }

        $data = $request->all();
        storeCustomField('user-registration-form',$user->id, $data);

        $response = ['message' => trans('messages.user_registered'), 'status' => 'success'];

     if(!\Auth::check())
            $response['redirect'] = '/login';
   return response()->json($response);
    return back()->withInput();
    }
}
