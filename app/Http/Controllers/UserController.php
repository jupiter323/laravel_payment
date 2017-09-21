<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use Validator;
use File;
use Image;
use Auth;
use Entrust;
use App\Taxregimen;
use App\CustomerCompany;
use App\Zipcode;
use App\State;
use App\City;
use App\Location;

use App\Notifications\UserStatusChange;
use App\Jobs\UploadCustomer;

class UserController extends Controller
{
    use BasicController;

    protected $form = 'user-form';
    protected $user_type = ['staff','customer'];

    public function index($type = 'staff'){

        if(!in_array($type,$this->user_type))
            $type = 'staff';

        if(!Entrust::can('list-'.$type))
            return redirect('/home')->withErrors(trans('messages.permission_denied'));

        $data = array(
                    trans('messages.option'),
                    trans('messages.first').' '.trans('messages.name'),
                    trans('messages.last').' '.trans('messages.name'),
                    trans('messages.username'),
                    trans('messages.email'),
                    trans('messages.role'),
                    trans('messages.address'),
                    trans('messages.date_registered'),
                    trans('messages.status')
                );

        $data = putCustomHeads($this->form, $data);

        $table_data[$type.'-table'] = array(
                'source' => 'user/'.$type,
                'title' => $type.' List',
                'id' => $type.'-table',
                'form' => $type.'-filter-form',
                'data' => $data
            );

        if($type == 'staff')
            $roles = \App\Role::whereIsHidden(0)->where('name','!=',config('constant.default_customer_role'))->get()->pluck('name','id')->all();
        else
            $roles = \App\Role::where('name','=',config('constant.default_customer_role'))->get()->pluck('name','id')->all();

        $companies = \App\Company::all()->pluck('name','id')->all();
        $designations = \App\Designation::whereIsHidden(0)->whereIn('id',getDesignation(\Auth::user()))->get()->pluck('designation_with_department','id')->all();
        $customer_groups = \App\CustomerGroup::all()->pluck('name','id')->all();
        $assets = ['datatable'];
        $menu = $type;
        $zipcode= Zipcode::pluck('zipcode', 'id');
        $state= State::pluck('state', 'code');
        $city= City::pluck('city', 'code');
        $location= Location::pluck('location', 'code');

        $neighbourhood=\App\Neighbourhood::all()->pluck('name','id')->all();

        $taxregimen= Taxregimen::pluck('tax_regimen_name', 'tr_id');
	$business_type=array('1'=>'Individual','2'=>'Company');

        return view('user.index',compact('table_data','assets','menu','roles','type','designations','customer_groups','companies','business_type','taxregimen','neighbourhood','zipcode','state','city','location'));
    }

 public function create($type = 'staff'){
 if(!in_array($type,$this->user_type))
            $type = 'staff';

        if(!Entrust::can('list-'.$type))
            return redirect('/home')->withErrors(trans('messages.permission_denied'));

        $data = array(
                    trans('messages.option'),
                    trans('messages.first').' '.trans('messages.name'),
                    trans('messages.last').' '.trans('messages.name'),
                    trans('messages.username'),
                    trans('messages.email'),
                    trans('messages.role'),
                    trans('messages.address'),
                    trans('messages.date_registered'),
                    trans('messages.status')
                );

        $data = putCustomHeads($this->form, $data);

        $table_data[$type.'-table'] = array(
                'source' => 'user/'.$type,
                'title' => $type.' List',
                'id' => $type.'-table',
                'form' => $type.'-filter-form',
                'data' => $data
            );

 if($type == 'staff')
            $roles = \App\Role::whereIsHidden(0)->where('name','!=',config('constant.default_customer_role'))->get()->pluck('name','id')->all();
        else
            $roles = \App\Role::where('name','=',config('constant.default_customer_role'))->get()->pluck('name','id')->all();

        $companies = \App\Company::all()->pluck('name','id')->all();
        $designations = \App\Designation::whereIsHidden(0)->whereIn('id',getDesignation(\Auth::user()))->get()->pluck('designation_with_department','id')->all();
        $customer_groups = \App\CustomerGroup::all()->pluck('name','id')->all();
        $assets = ['datatable'];
        $menu = $type;    
        $taxregimen= Taxregimen::pluck('tax_regimen_name', 'tr_id');
	$business_type=array('1'=>'Individual','2'=>'Company');
        $neighbourhood=\App\Neighbourhood::all()->pluck('name','id')->all();
        $zipcode= Zipcode::pluck('zipcode', 'id');
        $state= State::pluck('state', 'code');
        $city= City::pluck('city', 'code');
        $location= Location::pluck('location', 'code');

        return view('user.create',compact('table_data','assets','menu','roles','type','designations','customer_groups','companies','business_type','taxregimen','neighbourhood','zipcode','state','city','location'));



		
       }

public function store_view($type = 'staff'){
 if(!in_array($type,$this->user_type))
            $type = 'staff';

        if(!Entrust::can('list-'.$type))
            return redirect('/home')->withErrors(trans('messages.permission_denied'));

        $data = array(
                    trans('messages.option'),
                    trans('messages.first').' '.trans('messages.name'),
                    trans('messages.last').' '.trans('messages.name'),
                    trans('messages.username'),
                    trans('messages.email'),
                    trans('messages.role'),
                    trans('messages.address'),
                    trans('messages.date_registered'),
                    trans('messages.status')
                );

        $data = putCustomHeads($this->form, $data);

        $table_data[$type.'-table'] = array(
                'source' => 'user/'.$type,
                'title' => $type.' List',
                'id' => $type.'-table',
                'form' => $type.'-filter-form',
                'data' => $data
            );

 if($type == 'staff')
            $roles = \App\Role::whereIsHidden(0)->where('name','!=',config('constant.default_customer_role'))->get()->pluck('name','id')->all();
        else
            $roles = \App\Role::where('name','=',config('constant.default_customer_role'))->get()->pluck('name','id')->all();

        $companies = \App\Company::all()->pluck('name','id')->all();
        $designations = \App\Designation::whereIsHidden(0)->whereIn('id',getDesignation(\Auth::user()))->get()->pluck('designation_with_department','id')->all();
        $customer_groups = \App\CustomerGroup::all()->pluck('name','id')->all();
        $assets = ['datatable'];
        $menu = 'customer_add';
        $zipcode= Zipcode::pluck('zipcode', 'id');
        $neighbourhood=\App\Neighbourhood::all()->pluck('name','id')->all();
        $taxregimen= Taxregimen::pluck('tax_regimen_name', 'tr_id');
	$business_type=array('1'=>'Individual','2'=>'Company');
        $state= State::pluck('state', 'code');
        $city= City::pluck('city', 'code');
        $location= Location::pluck('location', 'code');

        return view('user.store',compact('table_data','assets','menu','roles','type','designations','customer_groups','companies','business_type','taxregimen','neighbourhood','zipcode','state','city','location'));



		
       }



    public function lists(Request $request, $type = 'staff'){

        if(!in_array($type,$this->user_type))
            $type = 'staff';

        if(!Entrust::can('list-'.$type))
            return;

        if($type == 'staff'){
            $query = getAccessibleUser();

            $query->whereHas('roles',function($qry){
                $qry->where('name','!=',config('constant.default_customer_role'));
            });

            if($request->has('designation_id'))
                $query->whereHas('profile',function($q) use ($request){
                    $q->whereIn('designation_id',$request->input('designation_id'));
                });
              

            if($request->has('role_id'))
                $query->whereHas('roles',function($q) use ($request){
                    $q->whereIn('role_id',$request->input('role_id'));
                });
        } else {
            $query = User::whereHas('roles',function($qry){
                $qry->where('name','=',config('constant.default_customer_role'));
            });

            if($request->has('customer_group_id'))
                $query->whereHas('customerGroup',function($qry) use($request){
                    $qry->whereIn('id',$request->input('customer_group_id'));
                });

            if($request->has('company_id'))
                $query->whereHas('profile',function($qry) use($request){
                    $qry->whereIn('company_id',$request->input('company_id'));
                });
        }

        if($request->has('status'))
            $query->whereIn('status',$request->input('status'));

        if($request->has('start_date') && $request->has('end_date'))
            $query->whereBetween('created_at',[$request->input('start_date').' 00:00:00',$request->input('end_date').' 23:59:59']);

        $users = $query->get();

        $col_ids = getCustomColId($this->form);
        $values = fetchCustomValues($this->form);
        $rows = array();

        foreach($users as $user){
            $row = array();

            $profile = $user->Profile;
            if(!isset($profile) && $profile == '' && $profile == null){
                $profile = new \App\Profile;
                $profile->user()->associate($user);
                $profile->save();
            }

            $user_role = '<ol>';
            foreach($user->roles as $role)
                $user_role .= '<li>'.toWord($role->name).'</li>';
            $user_role .= '</ol>';

            $user_status = '';
            if($user->status == 'active')
                $user_status = '<span class="label label-success">'.trans('messages.active').'</span>';
            elseif($user->status == 'pending_activation')
                $user_status = '<span class="label label-warning">'.trans('messages.pending_activation').'</span>';
            elseif($user->status == 'pending_approval')
                $user_status = '<span class="label label-info">'.trans('messages.pending_approval').'</span>';
            elseif($user->status == 'banned')
                $user_status = '<span class="label label-danger">'.trans('messages.banned').'</span>';

            $row = array(
                '<div class="btn-group btn-group-xs">'.
                '<a href="/user/'.$type.'/'.$user->id.'" class="btn btn-xs btn-default"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="'.trans('messages.view').'"></i></a> '.
                (($user->status == 'active' && Entrust::can('change-'.$type.'-status')) ? '<a href="#" class="btn btn-xs btn-default" data-ajax="1" data-extra="&user_id='.$user->id.'&status=ban" data-source="/change-user-status"> <i class="fa fa-ban" data-toggle="tooltip" title="'.trans('messages.ban').' '.trans('messages.user').'"></i></a>' : '').
                (($user->status == 'banned' && Entrust::can('change-'.$type.'-status')) ? '<a href="#" class="btn btn-xs btn-default" data-ajax="1" data-extra="&user_id='.$user->id.'&status=active" data-source="/change-user-status"> <i class="fa fa-check" data-toggle="tooltip" title="'.trans('messages.activate').' '.trans('messages.'.$type).'"></i></a>' : '').
                (($user->status == 'pending_approval' && Entrust::can('change-'.$type.'-status')) ? '<a href="#" class="btn btn-xs btn-default" data-ajax="1" data-extra="&user_id='.$user->id.'&status=approve" data-source="/change-user-status"> <i class="fa fa-check" data-toggle="tooltip" title="'.trans('messages.approve').' '.trans('messages.'.$type).'"></i></a>' : '').
                ((Entrust::can('login-as-user') && config('config.enable_login_as_user') && !session()->has('parent_login') && $user->id != \Auth::user()->id) ? '<a href="#" class="btn btn-xs btn-default" data-ajax="1" data-extra="&user_id='.$user->id.'" data-source="/login-as-user"> <i class="fa fa-sign-in" data-toggle="tooltip" title="'.trans('messages.login').' '.trans('messages.as').' '.$user->full_name.'"></i></a>' : '').
                (Entrust::can('delete-'.$type) ? delete_form(['user.destroy',$user->id]) : '').
                '</div>',
                $user->Profile->first_name,
                $user->Profile->last_name,
                $user->username.' '.(($user->is_hidden) ? '<span class="label label-danger">'.trans('messages.default').'</span>' : ''),
                $user->email,
                $user_role,
                $user->address,
                showDate($user->created_at),
                $user_status
                );
            $id = $user->id;

            foreach($col_ids as $col_id)
                array_push($row,isset($values[$id][$col_id]) ? $values[$id][$col_id] : '');
            $rows[] = $row;
        }
        $list['aaData'] = $rows;
        return json_encode($list);
    }

    public function getUserType($user){
        $user_role = array();
        foreach($user->roles as $role)
            $user_role[] = strtolower($role->name);

        if(in_array(config('constant.default_customer_role'),$user_role))
            return 'customer';
        else
            return 'staff';
    }

    public function loginAsUser(Request $request){
        $user_id = $request->input('user_id');
        if(!Entrust::can('login-as-user') || !config('config.enable_login_as_user') || $user_id == \Auth::user()->id)
            return response()->json(['message' => trans('messages.invalid_link'),'status' => 'error']);

        $user = User::find($user_id);

        $user_type = $this->getUserType($user);

        if(!$user || ($user_type == 'staff' && !$this->userAccessible($user_id)))
            return response()->json(['message' => trans('messages.permission_denied'),'status' => 'error']);

        if($user_type == 'customer' && !\Entrust::can('list-customer'))
            return response()->json(['message' => trans('messages.permission_denied'),'status' => 'error']);

        $parent_user_id = \Auth::user()->id;
        \Auth::logout();
        session(['parent_login' => $parent_user_id]);
        \Auth::login($user);
        $this->logActivity(['module' => 'login','activity' => 'logged_in']);

        return response()->json(['message' => trans('messages.login_redirect_message'),'status' => 'success','redirect' => '/home']);
    }

    public function loginReturn(Request $request){
        if(!session('parent_login'))
            return response()->json(['message' => trans('messages.invalid_link'),'status' => 'error']);

        $return_user = User::find(session('parent_login'));

        if(!$return_user)
            return response()->json(['message' => trans('messages.invalid_link'),'status' => 'error']);

        \Auth::logout();
        session(['parent_login' => $return_user->id]);
        \Auth::login($return_user);
        session()->forget('parent_login');
        $this->logActivity(['module' => 'login','activity' => 'logged_in']);
        
        return response()->json(['message' => trans('messages.login_redirect_message'),'status' => 'success','redirect' => '/home']);
    }

    public function show($type,$id){

        if(!in_array($type,$this->user_type))
            $type = 'staff';

        if(!Entrust::can('list-'.$type))
            return redirect('/home')->withErrors(trans('messages.permission_denied'));

        if($type =='staff' && !$this->userAccessible($id))
            return redirect('/home')->withErrors(trans('messages.permission_denied'));

        $user = User::whereId($id)->whereHas('roles',function($query) use($type){
            if($type == 'staff')
                $query->where('name','!=',config('constant.default_customer_role'));
            else
                $query->where('name',config('constant.default_customer_role'));
        })->first();

        if(!$user)
            return redirect('/home')->withErrors(trans('messages.invalid_link'));

        $templates = \App\Template::whereCategory($type)->pluck('name','id')->all();

        if($type == 'staff')
            $roles = \App\Role::whereIsHidden(0)->where('name','!=',config('constant.default_customer_role'))->get()->pluck('name','id')->all();
        else 
            $roles = \App\Role::where('name','=',config('constant.default_customer_role'))->get()->pluck('name','id')->all();

        $designations = \App\Designation::whereIn('id',getDesignation(\Auth::user()))->get()->pluck('designation_with_department','id')->all();
        $companies = \App\Company::all()->pluck('name','id')->all();
        $customer_groups = \App\CustomerGroup::all()->pluck('name','id')->all();
        $custom_social_field_values = getCustomFieldValues('user-social-form',$user->id);
        $custom_register_field_values = getCustomFieldValues('user-registration-form',$user->id);
        $assets = ['summernote'];
        $menu = $type;

        return view('user.show',compact('user','templates','type','roles','assets','menu','custom_social_field_values','custom_register_field_values','designations','customer_groups','companies'));
    }

    public function profile(){

        $user = \Auth::user();
        $type = $this->getUserType($user);
        $custom_social_field_values = getCustomFieldValues('user-social-form',$user->id);
        $custom_register_field_values = getCustomFieldValues('user-registration-form',$user->id);

        $menu = 'user';
        return view('user.profile',compact('user','menu','type','custom_social_field_values','custom_register_field_values'));
    }

    public function changeStatus(Request $request){

        $user_id = $request->input('user_id');
        $status = $request->input('status');

        $user = \App\User::find($user_id);
        if(!$user)
            return redirect('/user')->withErrors(trans('messages.invalid_link'));

        $type = $this->getUserType($user);

        if(!Entrust::can('change-'.$type.'-status') || $user->hasRole(DEFAULT_ROLE))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        if($status == 'ban' && $user->status != 'active')
            return redirect('/user/'.$type)->withErrors(trans('messages.invalid_link'));
        elseif($status == 'approve' && $user->status != 'pending_approval')
            return redirect('/user/'.$type)->withErrors(trans('messages.invalid_link'));
        elseif($status == 'active' && $user->status != 'banned')
            return redirect('/user/'.$type)->withErrors(trans('messages.invalid_link'));

        if($status == 'ban')
            $user->status = 'banned';
        elseif($status == 'approve' || $status == 'active')
            $user->status  = 'active';

        $user->save();
        $user->notify(new UserStatusChange($user));

        $this->logActivity(['module' => $type,'module_id' => $user->id, 'sub_module' => 'profile', 'activity' => 'status_updated']);

        return response()->json(['message' => trans('messages.status').' '.trans('messages.updated'), 'status' => 'success']);
    }

    public function profileUpdateValidation($id){
        $user = \App\User::find($id);

        $invalid_user = 0;
        if(!$user)
            $invalid_user = 1;

        $type = $this->getUserType($user);

        if($type == 'customer' && $user->id != \Auth::user()->id && !Entrust::can('update-customer'))
            $invalid_user = 1;
        elseif($type == 'staff' && $user->id != \Auth::user()->id && !Entrust::can('update-user') && !$this->userAccessible($id))
            $invalid_user = 1;

        return $invalid_user;
    }

    public function avatar(Request $request, $id){

        $invalid_user = $this->profileUpdateValidation($id);

        $user = \App\User::find($id);

        if($invalid_user)
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);
        
        $type = $this->getUserType($user);

        $profile = $user->Profile;

        $validation = Validator::make($request->all(),[
            'avatar' => 'image'
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        $filename = uniqid();

        if(getMode()){
            if ($request->hasFile('avatar') && $request->input('remove_avatar') != 1){
                if(File::exists(config('constant.upload_path.avatar').config('config.avatar')))
                    File::delete(config('constant.upload_path.avatar').config('config.avatar'));
                $extension = $request->file('avatar')->getClientOriginalExtension();
                $file = $request->file('avatar')->move(config('constant.upload_path.avatar'), $filename.".".$extension);
                $img = Image::make(config('constant.upload_path.avatar').$filename.".".$extension);
                $img->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save(config('constant.upload_path.avatar').$filename.".".$extension);
                $profile->avatar = $filename.".".$extension;
            } elseif($request->input('remove_avatar') == 1){
                if(File::exists(config('constant.upload_path.avatar').config('config.avatar')))
                    File::delete(config('constant.upload_path.avatar').config('config.avatar'));
                $profile->avatar = null;
            }
        }

        $profile->save();

        $this->logActivity(['module' => $type,'module_id' => $user->id, 'sub_module' => 'avatar' ,'activity' => 'updated']);

        $response = ['message' => trans('messages.profile').' '.trans('messages.updated'), 'status' => 'success'];
        if($request->input('redirect_url') == 'profile')
            $response['redirect'] = '/profile';
        else
            $response['redirect'] = '/user/'.$type.'/'.$user->id;
        return response()->json($response);
    }

    public function profileUpdate(Request $request, $id){
        
        $invalid_user = $this->profileUpdateValidation($id);

        $user = \App\User::find($id);
        $type = $this->getUserType($user);

        if($invalid_user)
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        $validation = validateCustomField('user-registration-form',$request);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        $profile = $user->Profile;

        $profile->fill($request->all());
        $profile->date_of_birth = ($request->input('date_of_birth')) ? : null;
        $profile->date_of_anniversary = ($request->input('date_of_anniversary')) ? : null;
        $profile->company_id = ($request->has('company_id')) ? $request->input('company_id') : null;

        if($request->has('designation_id'))
            $profile->designation_id = $request->input('designation_id');

        $profile->save();

        if(!Entrust::hasRole(config('constant.default_customer_role')))
        $user->customerGroup()->sync(($request->input('customer_group_id')) ? $request->input('customer_group_id') : []);

        $data = $request->all();
        storeCustomField('user-registration-form',$user->id, $data);

        if($request->has('role_id') && !$user->hasRole(DEFAULT_ROLE)){
            $user->roles()->sync(($request->input('role_id')) ? $request->input('role_id') : []);
        }
        $this->logActivity(['module' => $type,'module_id' => $user->id, 'sub_module' => 'profile', 'activity' => 'updated']);

        return response()->json(['message' => trans('messages.profile').' '.trans('messages.updated'), 'status' => 'success']);
    }

    public function socialUpdate(Request $request, $id){
        
        $invalid_user = $this->profileUpdateValidation($id);

        $user = \App\User::find($id);

        if($invalid_user)
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        $type = $this->getUserType($user);

        $validation = validateCustomField('user-social-form',$request);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        $profile = $user->Profile;

        $data = $request->all();
        $profile->fill($data);
        $profile->save();
        storeCustomField('user-social-form',$user->id, $data);

        $this->logActivity(['module' => $type,'module_id' => $user->id, 'sub_module' => 'social_field', 'activity' => 'updated']);

        return response()->json(['message' => trans('messages.profile').' '.trans('messages.updated'), 'status' => 'success']);
    }

    public function detail(Request $request){
        $user = User::find($request->input('user_id'));

        $type = $this->getUserType($user);
        return view('user.detail',compact('user','type'))->render();
    }

    public function email(Request $request, $id){

        $user = \App\User::find($id);

        if(!$user)
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        $type = $this->getUserType($user);

        if(!Entrust::can('email-'.$type) || (!Entrust::hasRole(DEFAULT_ROLE) && $user->hasRole(DEFAULT_ROLE)) )
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        if($type == 'staff' && !$this->userAccessible($id))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        $validation = Validator::make($request->all(),[
            'subject' => 'required',
            'body' => 'required'
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        $mail['email'] = $user->email;
        $mail['subject'] = $request->input('subject');
        $body = clean($request->input('body'),'custom');

        \Mail::send('emails.email', compact('body'), function($message) use ($mail){
            $message->to($mail['email'])->subject($mail['subject']);
        });
        $this->logEmail(array('to' => $mail['email'],'subject' => $mail['subject'],'body' => $body,'module' => 'user','module_id' =>$user->id));

        $this->logActivity(['module' => $type,'module_id' => $user->id,'activity' => 'mail_sent']);
        return response()->json(['message' => trans('messages.mail').' '.trans('messages.sent'), 'status' => 'success']);
    }

    public function changePassword(){
        return view('auth.change_password');
    }

    public function doChangePassword(Request $request){
        if(!getMode())
            return response()->json(['message' => trans('messages.disable_message'), 'status' => 'error']);

        $credentials = $request->only(
                'new_password', 'new_password_confirmation'
        );
        $validation_messages = [
            'password.regex' => trans('messages.password_alphanumeric'),
        ];

        $validation = Validator::make($request->all(),[
            'old_password' => 'required|valid_password',
            'new_password' => 'required|confirmed|different:old_password|min:6|'.passwordRule(),
            'new_password_confirmation' => 'required|different:old_password|same:new_password'
        ],$validation_messages);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        $user = \Auth::user();
        $type = $this->getUserType($user);
        
        $user->password = bcrypt($credentials['new_password']);
        $user->save();

        $this->logActivity(['module' => $type,'module_id' => $user->id,'activity' => 'password_changed']);

        return response()->json(['message' => trans('messages.password').' '.trans('messages.changed'), 'status' => 'success']);
    }

    public function forceChangePassword($user_id,Request $request){

        $user = \App\User::find($user_id);

        if(!$user)
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        $type = $this->getUserType($user);

        if(!Entrust::can('reset-'.$type.'-password'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        if($type == 'staff' && !$this->userAccessible($user_id))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        if($user_id == \Auth::user()->id)
            return response()->json(['message' => trans('messages.invalid_link'), 'status' => 'error']);

        if(!getMode())
            return response()->json(['message' => trans('messages.disable_message'), 'status' => 'error']);

        $credentials = $request->only(
                'new_password', 'new_password_confirmation'
        );

        $validation = Validator::make($request->all(),[
            'new_password' => 'required|confirmed|min:6',
            'new_password_confirmation' => 'required|same:new_password'
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);
        
        $this->logActivity(['module' => $type,'module_id' => $user->id,'activity' => 'force_password_changed']);
        $user->password = bcrypt($credentials['new_password']);
        $user->save();

        return response()->json(['message' => trans('messages.password').' '.trans('messages.changed'), 'status' => 'success']);
    }

    public function uploadColumn(Request $request){
        if(!Entrust::can('upload-customer'))
            return redirect('/user/customer')->withErrors(trans('messages.permission_denied'));

        $filename = uniqid();
        $extension = $request->file('file')->getClientOriginalExtension();

        $allowed_file_types = ['csv'];
        if(!in_array($extension, $allowed_file_types))
            return redirect('/user/customer')->withErrors('Only '.implode(',',$allowed_file_types).' file types are allowed.');

        \File::cleanDirectory(config('constant.upload_path.temp_user'));
        $file = $request->file('file')->move(config('constant.upload_path.temp_user'),$filename.".".$extension);
        $filename_extension = config('constant.upload_path.temp_user').$filename.'.'.$extension;
        session(['user_upload_file' => $filename.'.'.$extension]);

        include('../app/Helper/ExcelReader/SpreadsheetReader.php');
        include('../app/Helper/ExcelReader/php-excel-reader/excel_reader2.php');

        $xls_datas = array();
        $Reader = new \SpreadsheetReader($filename_extension);
        $i = 0;
        foreach ($Reader as $key => $row){
            $i++;
            if($i<=5)
            $xls_datas[] = array(
                'a' => array_key_exists(0, $row) ? $row[0] : null,
                'b' => array_key_exists(1, $row) ? $row[1] : null,
                'c' => array_key_exists(2, $row) ? $row[2] : null,
                'd' => array_key_exists(3, $row) ? $row[3] : null,
                'e' => array_key_exists(4, $row) ? $row[4] : null,
                'f' => array_key_exists(5, $row) ? $row[5] : null,
                'g' => array_key_exists(6, $row) ? $row[6] : null,
                'h' => array_key_exists(7, $row) ? $row[7] : null,
                );
        }

        if(!count($xls_datas))
            return redirect('/user/customer')->withErrors(trans('messages.no_data_found'));

        $columns = ['first_name' => trans('messages.first').' '.trans('messages.name'),
                'last_name' => trans('messages.last').' '.trans('messages.name'),
                'username' => trans('messages.username'),
                'email' => trans('messages.email'),
                'password' => trans('messages.password'),
                'date_of_birth' => trans('messages.date_of_birth'),
                'date_of_anniversary' => trans('messages.date_of_anniversary'),
                'phone' => trans('messages.phone')
        ];

        return view('user.upload',compact('xls_datas','columns'));
    }

    public function upload(Request $request){

        if(!getMode())
            return response()->json(['message' => trans('messages.disable_message'), 'status' => 'error']);

        $input[] = $request->input('0');
        $input[] = $request->input('1');
        $input[] = $request->input('2');
        $input[] = $request->input('3');
        $input[] = $request->input('4');
        $input[] = $request->input('5');
        $input[] = $request->input('6');
        $input[] = $request->input('7');

        $unique_input = array_unique($input);

        if(count($unique_input) < 8)
            return response()->json(['message' => trans('messages.duplicate_column_found'), 'status' => 'error']);

        $file = session('user_upload_file');

        $filename_extension = config('constant.upload_path.temp_user').$file;

        if(!session()->has('user_upload_file') || !File::exists($filename_extension))
            return response()->json(['message' => trans('messages.something_wrong'), 'status' => 'error','force_redirect' => '/user/customer']);

        include('../app/Helper/ExcelReader/SpreadsheetReader.php');
        include('../app/Helper/ExcelReader/php-excel-reader/excel_reader2.php');

        $xls_datas = array();
        $usernames = array();
        $emails = array();
        $Reader = new \SpreadsheetReader($filename_extension);
        foreach ($Reader as $key => $row){
            $usernames[] = array_key_exists(2, $row) ? $row[2] : null;
            $emails[] = array_key_exists(3, $row) ? $row[3] : null;
            $xls_datas[] = array(
                $request->input('0') => array_key_exists(0, $row) ? $row[0] : null,
                $request->input('1') => array_key_exists(1, $row) ? $row[1] : null,
                $request->input('2') => array_key_exists(2, $row) ? $row[2] : null,
                $request->input('3') => array_key_exists(3, $row) ? $row[3] : null,
                $request->input('4') => array_key_exists(4, $row) ? $row[4] : null,
                $request->input('5') => array_key_exists(5, $row) ? $row[5] : null,
                $request->input('6') => array_key_exists(6, $row) ? $row[6] : null,
                $request->input('7') => array_key_exists(7, $row) ? $row[7] : null,
            );
        }

        $unique_username = array_unique($usernames);
        $unique_email = array_unique($emails);

        if(count($usernames) > count($unique_username))
            return response()->json(['message' => trans('messages.duplicate_username'), 'status' => 'error']);

        if(count($emails) > count($unique_email))
            return response()->json(['message' => trans('messages.duplicate_email'), 'status' => 'error']);

        $user_upload = new \App\UserUpload;
        $user_upload->user_id = \Auth::user()->id;
        $user_upload->filename = $file;
        $user_upload->total = count($xls_datas);
        $user_upload->save();

        $user_usernames = User::all()->pluck('username')->all();
        $user_emails = User::all()->pluck('email')->all();

        $all_users = array();
        foreach($user_usernames as $user_username)
            $all_users[] = $user_username;
        $all_emails = array();
        foreach($user_emails as $user_email)
            $all_emails[] = $user_email;

        if(count($xls_datas) > 0)
        {
            $data = array();
            $data_fails = array();
            foreach($xls_datas as $xls_data)
            {
                $error = '';
                if(in_array($xls_data['username'], $all_users))
                    $error = 'duplicate_username';
                elseif(in_array($xls_data['email'], $all_emails))
                    $error = 'duplicate_email';
                elseif($xls_data['date_of_birth'] != '' && !validateDate($xls_data['date_of_birth']))
                    $error = 'invalid_date_of_birth';
                elseif($xls_data['date_of_anniversary'] != '' && !validateDate($xls_data['date_of_anniversary']))
                    $error = 'invalid_date_of_anniversary';
                elseif(trim($xls_data['username'] == '') || strlen($xls_data['username']) < 4)
                    $error = 'invalid_username';
                elseif(trim($xls_data['email'] == '') || !filter_var($xls_data['email'], FILTER_VALIDATE_EMAIL))
                    $error = 'invalid_email';
                elseif(trim($xls_data['first_name'] == ''))
                    $error = 'invalid_first_name';
                elseif(trim($xls_data['last_name'] == ''))
                    $error = 'invalid_last_name';
                elseif(trim($xls_data['password']) == '' || strlen($xls_data['password']) < 6 || !preg_match('/^.*(?=.{2,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/', $xls_data['password']))
                    $error = 'invalid_password';

                if($error == ''){
                    $data[] = array(
                        'first_name' => $xls_data['first_name'],
                        'last_name' => $xls_data['last_name'],
                        'username' => $xls_data['username'],
                        'email' => $xls_data['email'],
                        'password' => $xls_data['password'],
                        'date_of_birth' => $xls_data['date_of_birth'],
                        'date_of_anniversary' => $xls_data['date_of_anniversary'],
                        'phone' => $xls_data['phone'],
                    );
                }
                else
                    $data_fails[] = array(
                        'user_upload_id' => $user_upload->id,
                        'first_name' => $xls_data['first_name'],
                        'last_name' => $xls_data['last_name'],
                        'username' => $xls_data['username'],
                        'email' => $xls_data['email'],
                        'password' => $xls_data['password'],
                        'date_of_birth' => $xls_data['date_of_birth'],
                        'date_of_anniversary' => $xls_data['date_of_anniversary'],
                        'phone' => $xls_data['phone'],
                        'error' => $error
                    );

            }

            if(count($data))
                dispatch(new UploadCustomer($data));
            if(count($data_fails))
                \App\UserUploadFail::insert($data_fails);

            $user_upload->uploaded = count($data);
            $user_upload->rejected = count($data_fails);
            $user_upload->save();
        }

        session()->forget('user_upload_file');
        \File::copy(config('constant.upload_path.temp_user').$file, config('constant.upload_path.user').$file);

        if(count($data))
            $this->logActivity(['module' => 'user_upload','module_id' => $user_upload->id,'activity' => 'uploaded']);
        if(count($data))
            return response()->json(['message' => trans('messages.customer').' '.trans('messages.uploaded'), 'status' => 'success','redirect' => '/user/customer']);
        else
            return response()->json(['message' => trans('messages.customer').' '.trans('messages.upload').' '.trans('messages.rejected').'.', 'status' => 'error','force_redirect' => '/user/customer']);
    }

    public function destroy(User $user,Request $request){

        $type = $this->getUserType($user);

        if(!Entrust::can('delete-'.$type) || $user->is_hidden)
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        if($type == 'staff' && !$this->userAccessible($id))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        if($user->id == \Auth::user()->id)
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        deleteCustomField($this->form, $user->id);
        $this->logActivity(['module' => 'user','module_id' => $user->id,'activity' => 'deleted']);

        $user->delete();
        return response()->json(['message' => trans('messages.user').' '.trans('messages.deleted'), 'status' => 'success']);
    }
     
 public function customer_data($id=0, $type = 'staff')
{

           $id=$_GET['id'];
           $users= \App\Profile::where('user_id',$id)->get();  
           $row=array();    
           foreach($users as $user)
            {
              $row['customername']=$user['first_name'].' '.$user['last_name'];
              $row['address']=$user['address_line_1'];
              if($user['business_type']=='1')
              {
              $row['business_type']="Individual";
              }
              else if($user['business_type']=='2')
              {
              $row['business_type']="Company";
              }
              $row['country']=((isset($user['country_id']) ? config('country.'.$user['country_id']) : ''));
              $row['ext']=$user['ext_num']; 
              $row['int']=$user['int_num']; 
              $row['zip']=$user['zipcode'];
              $row['state']=$user['state'];
              $row['city']=$user['city'];
              $row['neighboorhood']=$user['neighboorhood'];
              $row['street']=$user['street'];
              $row['tax_id']=$user['tax_id'];
             


            }
            $customers=json_encode($row);
           // return response()->json(['customername' => 'Customer Name ', 'address' => 'Address','business_type' => 'Business']);
            return $customers;
}



 public function shipment_data($id=0)
{

           $id=$_GET['id'];
           $shipments= \App\ShipmentAddress::where('id',$id)->get();  
           $row=array();    
           foreach($shipments as $ship)
            {
              $row['ship_id']=$ship['id'];
              $row['address']=$ship['shipment_address'];
              $row['country']=((isset($ship['country_id']) ? config('country.'.$ship['country_id']) : ''));
              $row['ext']=$ship['ext_num']; 
              $row['int']=$ship['int_num']; 
              $row['zip']=$ship['zipcode'];
              $row['state']=$ship['state'];
              $row['city']=$ship['city'];
              $row['neighboorhood']=$ship['neighboorhood'];
              $row['street']=$ship['street'];

            }
            $customers=json_encode($row);
           // return response()->json(['customername' => 'Customer Name ', 'address' => 'Address','business_type' => 'Business']);
            return $customers;
}


public function customer_company($id=0)
{
$company_customer=array();
     $company_id=$_GET['id'];    
     if (Auth::check())
     {
     $cust_id=Auth::user()->id;
     }        
     $query=\App\Profile::where('user_id','=',$cust_id)->get();  
    if(count($query)<1)
     {   
       //   $qury=\App\Profile::where('user_id',$cust_id)->update(['company_id'=>$company_id]);
     }
     else
     {
     $qury=\App\Profile::where('user_id',$cust_id)->update(['company_id'=>$company_id]);
     }
    return response()->json(['message' => trans('messages.company').' '.trans('messages.updated'), 'status' => 'success','force_redirect' => '/home']);



}
}