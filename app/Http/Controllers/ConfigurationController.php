<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use File;
use Image;
use Swift_SmtpTransport;
use Swift_TransportException;

class ConfigurationController extends Controller
{
    use BasicController;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $localizations = array();
        foreach(config('localization') as $key => $value)
            $localizations[$key] = $value['localization'];
        $assets = ['tags'];
        return view('configuration.index',compact('localizations','assets'));
    }
   public function payment_gateway()
    {        
        $menu = 'paymentgetway';
        return view('configuration.paymentgetway',compact('menu'));
    }
   public function theme()
    {        
        $menu = 'theme';
        return view('configuration.theme',compact('menu'));
    }
   public function system_form()
    {        

        $localizations = array();
        foreach(config('localization') as $key => $value)
            $localizations[$key] = $value['localization'];
        $assets = ['tags'];
        $menu = 'system_form';
        return view('configuration.systemform',compact('localizations','assets','menu'));
       
    }

public function mail_form()
    {        

        $localizations = array();
        foreach(config('localization') as $key => $value)
            $localizations[$key] = $value['localization'];
        $assets = ['tags'];
        $menu = 'mail_form';
        return view('configuration.mail',compact('localizations','assets','menu'));
       
    }

public function sms_form()
    {        

        $localizations = array();
        foreach(config('localization') as $key => $value)
            $localizations[$key] = $value['localization'];
        $assets = ['tags'];
        $menu = 'sms_form';
        return view('configuration.sms',compact('localizations','assets','menu'));
       
    }

public function auth_form()
    {        

        $localizations = array();
        foreach(config('localization') as $key => $value)
            $localizations[$key] = $value['localization'];
        $assets = ['tags'];
        $menu = 'auth_form';
        return view('configuration.auth',compact('localizations','assets','menu'));
       
    }

public function social_login_form()
    {        

        $localizations = array();
        foreach(config('localization') as $key => $value)
            $localizations[$key] = $value['localization'];
        $assets = ['tags'];
        $menu = 'social_login_form';
        return view('configuration.social_login',compact('localizations','assets','menu'));
       
    }
public function menu_form()
    {        

        $localizations = array();
        foreach(config('localization') as $key => $value)
            $localizations[$key] = $value['localization'];
        $assets = ['tags'];
$menu = 'menu_form';
        return view('configuration.menu',compact('localizations','assets','menu'));
       
    }

public function currency_form()
    {        

        $localizations = array();
        foreach(config('localization') as $key => $value)
            $localizations[$key] = $value['localization'];
        $assets = ['tags'];
$menu = 'currency_form';
        return view('configuration.currency',compact('localizations','assets','menu'));
       
    }
public function taxation_form()
    {        

        $localizations = array();
        foreach(config('localization') as $key => $value)
            $localizations[$key] = $value['localization'];
        $assets = ['tags'];
$menu = 'taxation_form';
        return view('configuration.taxation',compact('localizations','assets','menu'));
       
    }

public function customers_form()
    {        

        $localizations = array();
        foreach(config('localization') as $key => $value)
            $localizations[$key] = $value['localization'];
        $assets = ['tags'];
$menu = 'customers_form';
        return view('configuration.customers',compact('localizations','assets','menu'));
       
    }

public function expense_form()
    {        

        $localizations = array();
        foreach(config('localization') as $key => $value)
            $localizations[$key] = $value['localization'];
        $assets = ['tags'];
$menu = 'expense_form';
        return view('configuration.expense',compact('localizations','assets','menu'));
       
    }

public function income_form()
    {        

        $localizations = array();
        foreach(config('localization') as $key => $value)
            $localizations[$key] = $value['localization'];
        $assets = ['tags'];
$menu = 'income_form';
        return view('configuration.income',compact('localizations','assets','menu'));
       
    }

public function items_form()
    {        

        $localizations = array();
        foreach(config('localization') as $key => $value)
            $localizations[$key] = $value['localization'];
        $assets = ['tags'];
$menu = 'items_form';
        return view('configuration.items',compact('localizations','assets','menu'));
       
    }
public function invoice_form()
    {        

        $localizations = array();
        foreach(config('localization') as $key => $value)
            $localizations[$key] = $value['localization'];
        $assets = ['tags'];
$menu = 'invoice_form';
        return view('configuration.invoice',compact('localizations','assets','menu'));
       
    }
public function quotations_form()
    {        

        $localizations = array();
        foreach(config('localization') as $key => $value)
            $localizations[$key] = $value['localization'];
        $assets = ['tags'];
$menu = 'quotations_form';
        return view('configuration.quotations',compact('localizations','assets','menu'));
       
    }
public function payments_form()
    {        

        $localizations = array();
        foreach(config('localization') as $key => $value)
            $localizations[$key] = $value['localization'];
        $assets = ['tags'];
$menu = 'payments_form';
        return view('configuration.payments',compact('localizations','assets','menu'));
       
    }

public function schedule_form()
    {        

        $localizations = array();
        foreach(config('localization') as $key => $value)
            $localizations[$key] = $value['localization'];
        $assets = ['tags'];
$menu = 'schedule_form';
        return view('configuration.schedule',compact('localizations','assets','menu'));
       
    }
    public function store(Request $request){
        if(!getMode())
            return response()->json(['message' => trans('messages.disable_message'), 'status' => 'error']);

        $validation = Validator::make($request->all(),[
            'company_name' => 'sometimes|required',
            'contact_person' => 'sometimes|required',
            'email' => 'sometimes|email|required',
            'country_id' => 'sometimes|required',
            'timezone_id' => 'sometimes|required',
            'application_name' => 'sometimes|required',
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        if($request->has('max_file_size_upload') && $request->input('max_file_size_upload')*1024*1024 > getMaxFileUploadSize())
            return response()->json(['message' => trans('messages.system_max_file_size_upload',['attribute' => formatMemorySizeUnits(getMaxFileUploadSize())]), 'status' => 'error']);

        $input = $request->all();
        foreach($input as $key => $value){
            if(!in_array($key, config('constant.ignore_var'))){
                $config = \App\Config::firstOrNew(['name' => $key]);
                if($value != config('config.hidden_value'))
                $config->value = isset($value) ? $value : null;
                $config->save();
            }
        }

        $sub_module = $request->input('config_type');
        $this->logActivity(['module' => 'configuration','sub_module' => $sub_module,'activity' => 'updated']);

        $response = ['message' => trans('messages.configuration').' '.trans('messages.updated'), 'status' => 'success']; 

        if($request->has('theme_color'))
            $response['redirect'] = '/configuration';
        
        $response = $this->getSetupGuide($response,'configuration');
        return response()->json($response);
    }

    public function mail(Request $request){
        if(!getMode())
            return response()->json(['message' => trans('messages.disable_message'), 'status' => 'error']);

        $validation = Validator::make($request->all(),[
                'from_address' => 'required|email',
                'from_name' => 'required',
                'host' => 'required_if:driver,smtp',
                'port' => 'required_if:driver,smtp|numeric',
                'username' => 'required_if:driver,smtp',
                'password' => 'required_if:driver,smtp',
                'encryption' => 'in:ssl,tls|required_if:driver,smtp',
                'mailgun_host' => 'required_if:driver,mailgun',
                'mailgun_port' => 'required_if:driver,mailgun|numeric',
                'mailgun_username' => 'required_if:driver,mailgun',
                'mailgun_password' => 'required_if:driver,mailgun',
                'mailgun_domain' => 'required_if:driver,mailgun',
                'mailgun_secret' => 'required_if:driver,mailgun',
                'mandrill_secret' => 'required_if:driver,mandrill',
                ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        if($request->input('driver') == 'smtp'){
            $stmp = 0;
            try{
                    $transport = Swift_SmtpTransport::newInstance($request->input('host'), $request->input('port'), $request->input('encryption'));
                    $transport->setUsername($request->input('username'));
                    $transport->setPassword($request->input('password'));
                    $mailer = \Swift_Mailer::newInstance($transport);
                    $mailer->getTransport()->start();
                    $stmp =  1;
                } catch (Swift_TransportException $e) {
                    $stmp =  $e->getMessage();
                } 

            if($stmp != 1)
                return response()->json(['message' => $stmp, 'status' => 'error']);
        }
        $input = $request->all();
        foreach($input as $key => $value){
            if(!in_array($key, config('constant.ignore_var'))){
                $config = \App\Config::firstOrNew(['name' => $key]);
                if($value != config('config.hidden_value'))
                $config->value = $value;
                $config->save();
            }
        }

        $this->logActivity(['module' => 'configuration','sub_module' => 'mail','activity' => 'updated']);

        $response = ['message' => trans('messages.mail').' '.trans('messages.configuration').' '.trans('messages.updated'), 'status' => 'success']; 
        $response = $this->getSetupGuide($response,'mail');
        return response()->json($response);
    }

    public function sms(Request $request){
        if(!getMode())
            return response()->json(['message' => trans('messages.disable_message'), 'status' => 'error']);

        $validation = Validator::make($request->all(),[
                'nexmo_api_key' => 'required',
                'nexmo_api_secret' => 'required',
                'nexmo_from_number' => 'required',
                ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        $input = $request->all();
        foreach($input as $key => $value){
            if(!in_array($key, config('constant.ignore_var'))){
                $config = \App\Config::firstOrNew(['name' => $key]);
                if($value != config('config.hidden_value'))
                $config->value = $value;
                $config->save();
            }
        }
        $this->logActivity(['module' => 'configuration','sub_module' => 'sms','activity' => 'updated']);

        return response()->json(['message' => trans('messages.sms').' '.trans('messages.configuration').' '.trans('messages.updated'), 'status' => 'success']);
    }

    public function logo(Request $request){
        if(!getMode())
            return response()->json(['message' => trans('messages.disable_message'), 'status' => 'error']);

        $validation = Validator::make($request->all(),[
            'company_logo' => 'image'
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        $filename = uniqid();
        $config = \App\Config::firstOrNew(['name' => 'company_logo']);

        if ($request->hasFile('company_logo') && $request->input('remove_logo') != 1){
            if(File::exists(config('constant.upload_path.company_logo').config('config.company_logo')))
                File::delete(config('constant.upload_path.company_logo').config('config.company_logo'));
            $extension = $request->file('company_logo')->getClientOriginalExtension();
            $file = $request->file('company_logo')->move(config('constant.upload_path.company_logo'), $filename.".".$extension);
            $img = Image::make(config('constant.upload_path.company_logo').$filename.".".$extension);
            $img->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save(config('constant.upload_path.company_logo').$filename.".".$extension);
            $config->value = $filename.".".$extension;
        } elseif($request->input('remove_logo') == 1){
            if(File::exists(config('constant.upload_path.company_logo').config('config.company_logo')))
                File::delete(config('constant.upload_path.company_logo').config('config.company_logo'));
            $config->value = null;
        }

        $config->save();

        $this->logActivity(['module' => 'configuration','sub_module' => 'logo','activity' => 'updated']);

        return response()->json(['message' => trans('messages.configuration').' '.trans('messages.updated'), 'status' => 'success','redirect' => '/configuration']);
    }
    
    public function menu(Request $request){

        $data = $request->all();
        foreach(\App\Menu::all() as $menu_item){
            $menu_item->order = $request->input($menu_item->name);
            $menu_item->visible = $request->has($menu_item->name.'-visible') ? 1 : 0;
            $menu_item->save();
        }

        $config_type = $request->input('config_type');
        
        $this->logActivity(['module' => 'configuration','sub_module' => 'menu','activity' => 'updated']);

        $response = ['status' => 'success','message' => trans('messages.menu').' '.trans('messages.configuration').' '.trans('messages.updated')];
        $response = $this->getSetupGuide($response,'menu');
        return response()->json($response);
    }

    public function setupGuide(Request $request){

        $setup = \App\Setup::orderBy('id','asc')->get();
        $setup_total = 0;
        $setup_completed = 0;
        foreach($setup as $value){
            $setup_total += config('setup.'.$value->module.'.weightage');
            if($value->completed)
                $setup_completed += config('setup.'.$value->module.'.weightage');
        }
        $setup_percentage = ($setup_total) ? round(($setup_completed/$setup_total) * 100) : 0;

        if($setup_percentage != 100 && !config('config.setup_guide'))
            return response()->json(['status' => 'success']);

        $config = \App\Config::firstOrNew(['name' => 'setup_guide']);
        $config->value = 0;
        $config->save();

        $this->logActivity(['module' => 'configuration','sub_module' => 'setup_guide','activity' => 'updated']);

        return response()->json(['message' => trans('messages.setup_guide_hide'), 'status' => 'success']);
    }
}
