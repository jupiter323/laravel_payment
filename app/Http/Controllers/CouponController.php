<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\CouponRequest;
use Entrust;
use App\Coupon;

Class CouponController extends Controller{
    use BasicController;

	protected $form = 'coupon-form';

    public function __construct()
    {
        $this->middleware(['staff_accessible']);
    }

	public function index(Coupon $coupon){

		if(!Entrust::can('list-coupon'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

		$data = array(
	        		trans('messages.option'),
	        		trans('messages.code'),
	        		trans('messages.discount'),
	        		trans('messages.valid').' '.trans('messages.from'),
	        		trans('messages.valid').' '.trans('messages.to'),
	        		trans('messages.day'),
	        		trans('messages.new').' '.trans('messages.user'),
	        		trans('messages.maximum').' '.trans('messages.use')
        		);

		$data = putCustomHeads($this->form, $data);

		$table_data['coupon-table'] = array(
				'source' => 'coupon',
				'title' => 'Coupon List',
				'id' => 'coupon_table',
				'data' => $data
			);

		$selected_days = array();
		$week_days = translateList(config('lists.week_days'));
		$assets = ['datatable'];
		$menu = 'coupon';
		return view('coupon.index',compact('table_data','assets','menu','week_days','selected_days'));
	}

	public function lists(Request $request){
		
		if(!Entrust::can('list-coupon'))
			return;

		$coupons = Coupon::all();
        $col_ids = getCustomColId($this->form);
        $values = fetchCustomValues($this->form);
        $rows = array();

        foreach($coupons as $coupon){

        	$days = '<ol>';
        	$valid_days = explode(',',$coupon->valid_day);
        	foreach($valid_days as $valid_day)
        		$days .= '<li>'.trans('messages.'.$valid_day).'</li>';
        	$days .= '</ol>';

			$row = array(
				'<div class="btn-group btn-group-xs">'.
				(Entrust::can('edit-coupon') ? '<a href="#" data-href="/coupon/'.$coupon->id.'/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="'.trans('messages.edit').'"></i></a> ' : '').
				(Entrust::can('delete-coupon') ? delete_form(['coupon.destroy',$coupon->id]) : '').
				'</div>',
				$coupon->code,
				$coupon->discount,
				showDate($coupon->valid_from),
				showDate($coupon->valid_to),
				$days,
				($coupon->new_user) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>',
				$coupon->maximum_use_count
				);
			$id = $coupon->id;

			foreach($col_ids as $col_id)
				array_push($row,isset($values[$id][$col_id]) ? $values[$id][$col_id] : '');
			$rows[] = $row;
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function show(){
	}

	public function create(){
	}

	public function edit(Coupon $coupon){

		if(!Entrust::can('edit-coupon'))
            return view('global.error',['message' => trans('messages.permission_denied')]);

        $selected_days = ($coupon->valid_day) ? explode(',',$coupon->valid_day) : [];

        $week_days = translateList(config('lists.week_days'));
		$custom_field_values = getCustomFieldValues($this->form,$coupon->id);
		return view('coupon.edit',compact('coupon','custom_field_values','week_days','selected_days'));
	}

	public function store(CouponRequest $request, Coupon $coupon){	

		if(!Entrust::can('create-coupon'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        $validation = validateCustomField($this->form,$request);
        
        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

		$data = $request->all();
		$data['user_id'] = \Auth::user()->id;
		$data['valid_day'] = ($request->input('valid_day')) ? implode(',',$request->input('valid_day')) : null;
		$coupon->fill($data)->save();
		storeCustomField($this->form,$coupon->id, $data);

		$this->logActivity(['module' => 'coupon','module_id' => $coupon->id,'activity' => 'added']);

        return response()->json(['message' => trans('messages.coupon').' '.trans('messages.added'), 'status' => 'success']);	
	}

	public function update(CouponRequest $request, Coupon $coupon){

		if(!Entrust::can('edit-coupon'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        $validation = validateCustomField($this->form,$request);
        
        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

		$data = $request->all();
		$data['valid_day'] = ($request->input('valid_day')) ? implode(',',$request->input('valid_day')) : null;
		$coupon->fill($data)->save();

		$this->logActivity(['module' => 'coupon','module_id' => $coupon->id,'activity' => 'updated']);

		updateCustomField($this->form,$coupon->id, $data);
		
        return response()->json(['message' => trans('messages.coupon').' '.trans('messages.updated'), 'status' => 'success','data' => $data]);
	}

	public function destroy(Coupon $coupon,Request $request){
		if(!Entrust::can('delete-coupon') || $coupon->is_hidden == 1)
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

		$this->logActivity(['module' => 'coupon','module_id' => $coupon->id,'activity' => 'deleted']);

		deleteCustomField($this->form, $coupon->id);
        
        $coupon->delete();
        
        return response()->json(['message' => trans('messages.coupon').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}
?>