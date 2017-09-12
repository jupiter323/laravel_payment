<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Entrust::hasRole(config('constant.default_customer_role')))
        $announcements = \App\Announcement::whereAudience(0)
                ->where('from_date','<=',date('Y-m-d'))
                ->where('to_date','>=',date('Y-m-d'))->get();
        else
        $announcements = \App\Announcement::whereAudience(1)->with('designation')
                ->where('from_date','<=',date('Y-m-d'))
                ->where('to_date','>=',date('Y-m-d'))
                ->where(function($q){
                    $q->whereHas('designation',function($query) {
                        $query->where('designation_id','=',\Auth::user()->Profile->designation_id);
                    })->orWhere(function ($query) { 
                        $query->doesntHave('designation'); 
                    })->orWhere('user_id','=',\Auth::user()->id);
                })->get();

        $all_birthdays = \App\Profile::whereBetween( DB::raw('dayofyear(date_of_birth) - dayofyear(curdate())'), [0,config('config.celebration_days')])
            ->orWhereBetween( DB::raw('dayofyear(curdate()) - dayofyear(date_of_birth)'), [0,config('config.celebration_days')])
            ->orderBy('date_of_birth','asc')
            ->get();

        $all_anniversaries = \App\Profile::whereBetween( \DB::raw('dayofyear(date_of_anniversary) - dayofyear(curdate())'), [0,config('config.celebration_days')])
            ->orWhereBetween( \DB::raw('dayofyear(curdate()) - dayofyear(date_of_anniversary)'), [0,config('config.celebration_days')])
            ->orderBy('date_of_anniversary','asc')
            ->get();

        $celebrations = array();
        foreach($all_birthdays as $all_birthday){
            $number = date('Y') - date('Y',strtotime($all_birthday->date_of_birth));
            $celebrations[strtotime(date('d M',strtotime($all_birthday->date_of_birth)))] = array(
                'icon' => 'birthday-cake',
                'title' => getDateDiff($all_birthday->date_of_birth) ? : date('d M',strtotime($all_birthday->date_of_birth)),
                'date' => $all_birthday->date_of_birth,
                'number' => $number.'<sup>'.daySuffix($number).'</sup>'.' '.trans('messages.birthday'),
                'id' => $all_birthday->User->id,
                'name' => $all_birthday->User->full_name
            );
        }
        foreach($all_anniversaries as $all_anniversary){
            $number = date('Y') - date('Y',strtotime($all_anniversary->date_of_anniversary));
            $celebrations[strtotime(date('d M',strtotime($all_anniversary->date_of_anniversary)))] = array(
                'icon' => 'gift',
                'title' => getDateDiff($all_anniversary->date_of_anniversary) ? : date('d M',strtotime($all_anniversary->date_of_anniversary)),
                'date' => $all_anniversary->date_of_anniversary,
                'number' => $number.'<sup>'.daySuffix($number).'</sup>'.' '.trans('messages.anniversary'),
                'id' => $all_anniversary->User->id,
                'name' => $all_anniversary->User->full_name
            );
        }

        ksort($celebrations);

        $child_designation = childDesignation(\Auth::user()->Profile->designation_id,1);
        $child_staff_count = \App\User::with('profile')->whereHas('profile',function($query) use($child_designation){
            $query->whereIn('designation_id',$child_designation);
        })->count();

        $tree = array();
        $designations = \App\Designation::all();
        foreach ($designations as $designation){
            $tree[$designation->id] = array(
                'parent_id' => $designation->top_designation_id,
                'name' => $designation->designation_with_department
            );
        }

        $assets = ['calendar'];
        if(!\Entrust::hasRole(config('constant.default_customer_role')))
            array_push($assets,'graph');
        $menu = 'home';
        return view('home',compact('assets','celebrations','announcements','child_staff_count','tree','menu'));
    }

    public function calendarEvents(Request $request){
        $first_day = $request->has('start') ? $request->input('start') : date('Y-m-01');
        $last_day  = $request->has('end') ? $request->input('end') : date('Y-m-t');

        $birthdays = \App\Profile::whereNotNull('date_of_birth')->orderBy('date_of_birth','asc')->get();

        $anniversaries = \App\Profile::whereNotNull('date_of_anniversary')->orderBy('date_of_anniversary','asc')->get();

        $todos = \App\Todo::where('user_id','=',\Auth::user()->id)
            ->where('date','>=',$first_day)
            ->where('date','<=',$last_day)
            ->orWhere(function ($query)  {
                $query->where('user_id','!=',\Auth::user()->id)
                    ->where('visibility','=','public');
            })->get();

        $quotations = \App\Quotation::where('expiry_date','>=',$first_day)->where('expiry_date','<=',$last_day)->whereStatus('sent')->get();

        $invoices = \App\Invoice::whereNotNull('due_date_detail')->where('due_date_detail','>=',$first_day)->where('due_date_detail','<=',$last_day)->whereStatus('sent')->whereIn('payment_status',['unpaid','partially_paid'])->get();

        $events = array();
        foreach($birthdays as $birthday){
            $start = date('Y').'-'.date('m-d',strtotime($birthday->date_of_birth));
            $title = trans('messages.birthday').' : '.$birthday->User->full_name;
            $color = '#133edb';
            $events[] = array('title' => $title, 'start' => $start, 'color' => $color);
        }
        foreach($anniversaries as $anniversary){
            $start = date('Y').'-'.date('m-d',strtotime($anniversary->date_of_anniversary));
            $title = trans('messages.anniversary').' : '.$anniversary->User->full_name;
            $color = '#133edb';
            $events[] = array('title' => $title, 'start' => $start, 'color' => $color);
        }
        foreach($todos as $todo){
            $start = $todo->date;
            $title = trans('messages.to_do').' : '.$todo->title.' '.$todo->description;
            $color = '#ff0000';
            $url = '/todo/'.$todo->id.'/edit';
            $events[] = array('title' => $title, 'start' => $start, 'color' => $color, 'url' => $url);
        }
        foreach($quotations as $quotation){
            $start = $quotation->expiry_date;
            $title = trans('messages.quotation').' '.trans('messages.expiry').' '.trans('messages.date').' : '.$quotation->quotation_prefix.' '.getQuotationNumber($quotation);
            $color = '#ff0000';
            $url = '/quotation/'.$quotation->uuid;
            $events[] = array('title' => $title, 'start' => $start, 'color' => $color, 'url' => $url);
        }
        foreach($invoices as $invoice){
            $start = $invoice->due_date_detail;
            $title = trans('messages.invoice').' '.trans('messages.due').' : '.$invoice->invoice_prefix.' '.getInvoiceNumber($invoice);
            $color = '#ff0000';
            $url = '/invoice/'.$invoice->uuid;
            $events[] = array('title' => $title, 'start' => $start, 'color' => $color, 'url' => $url);
        }

        return $events;
    }

    public function sidebar(Request $request){
        $menu = explode(',',$request->input('menu'));
        $inbox_count = \App\Message::whereToUserId(\Auth::user()->id)->whereDeleteReceiver('0')->whereIsRead(0)->count();
        $company =array();
        return view('layouts.menu',compact('menu','inbox_count','company'));
    }

   public function app(Request $request){        
        $company =\App\Company::pluck('name','id')->all();
        return view('layouts.app',compact('company'));
    }




    public function activityLog(){
        $table_data['activity-log-table'] = array(
            'source' => 'activity-log',
            'title' => 'Activity Log List',
            'id' => 'activity_log_table',
            'disable-sorting' => 1,
            'form' => 'activity-log-filter-form',
            'data' => array(
                'S No',
                trans('messages.user'),
                trans('messages.activity'),
                'IP',
                trans('messages.date'),
                'User Agent',
                )
            );

        $query = getAccessibleUser();
        $users = $query->get()->pluck('name_with_designation_and_department','id')->all();

        if(\Entrust::can('list-customer')){
            $customers = \App\User::whereHas('roles',function($qry){
                $qry->where('name','=',config('constant.default_customer_role'));
            })->get();

            foreach($customers as $customer)
                $users[$customer->id] = $customer->full_name.' ('.trans('messages.customer').')';
        }

        $assets = ['datatable'];
        return view('activity_log.index',compact('table_data','assets','users'));
    }

    public function activityLogList(Request $request){

        $query = \App\Activity::whereNotNull('id');
        if($request->has('user_id'))
            $query->whereUserId($request->input('user_id'));

        if($request->has('start_date') && $request->has('end_date'))
            $query->whereBetween('created_at',[$request->input('start_date').' 00:00:00',$request->input('end_date').' 23:59:59']);

        $activities = $query->orderBy('created_at','desc')->get();

        $rows = array();
        $i = 0;
        foreach($activities as $activity){
            $i++;

            $sub_module = ($activity->sub_module) ? '('.toWord($activity->sub_module).')' : '';

            if($activity->module == 'login' || $activity->module == 'logout')
                $activity_detail = trans('messages.'.$activity->activity);
            else
            $activity_detail = ($activity->activity == 'added') ? trans('messages.new').' '.toWord($activity->module).' '.$sub_module.' '.trans('messages.'.$activity->activity) : toWord($activity->module).' '.$sub_module.' '.trans('messages.'.$activity->activity);

            if($activity->login_as_user_id)
                $login_as_user_id = '('.trans('messages.login').' '.trans('messages.as').' '.$activity->LoginAsUser->full_name.')';
            else
                $login_as_user_id = '';

            $row = array(
                $i,
                $activity->User->full_name.' '.$login_as_user_id,
                $activity_detail,
                $activity->ip,
                showDateTime($activity->created_at),
                $activity->user_agent
                );

            $rows[] = $row;
        }

        $list['aaData'] = $rows;
        return json_encode($list);
    }

    public function lock(){
        if(session('locked'))
            return view('auth.lock');
        else
            return redirect('/home');
    }

    public function unlock(Request $request){
        if(!\Auth::check())
            return response()->json(['message' => trans('messages.session_expire'), 'status' => 'success','redirect' => '/login']);

        $validation = Validator::make($request->all(),[
            'password' => 'required'
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        $password = $request->input('password');

        if(\Hash::check($password,\Auth::user()->password)){
            session()->forget('locked');
            session()->put('last_activity',time());
            return response()->json(['status' => 'success','redirect' => '/home']);
        }

        return response()->json(['message' => trans('messages.unlock_failed'), 'status' => 'error']);
    }

    public function filter(Request $request){
        return response()->json(['message' => trans('messages.request').' '.trans('messages.submitted'), 'status' => 'success']);
    }
}
