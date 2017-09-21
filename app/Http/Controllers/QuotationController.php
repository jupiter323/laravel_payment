<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\QuotationRequest;
use Entrust;
use App\Quotation;
use Uuid;
use PDF;
use Validator;
ini_set('memory_limit', '-1'); 

Class QuotationController extends Controller{
    use BasicController;

	protected $form = 'quotation-form';

    public function __construct()
    {
        $this->middleware(['staff_accessible'])->except(['index','lists','show','previewQuotation','printQuotation','pdfQuotation','fetchStatus','fetchActionButton','CustomerAction','discussion','storeDiscussion','storeDiscussionReply','fetch','download']);
    }

	public function index(){

		if(!Entrust::can('list-quotation'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

        $data = array(
        		trans('messages.option'),
        		trans('messages.number'),
        		trans('messages.customer'),
        		trans('messages.amount'),
        		trans('messages.date'),
        		trans('messages.expiry').' '.trans('messages.date'),
        		trans('messages.status')
        		);

        $data = putCustomHeads($this->form, $data);
        $table_data['quotation-table'] = array(
			'source' => 'quotation',
			'title' => 'Quotation List',
			'id' => 'quotation_table',
			'data' => $data,
			'form' => 'quotation-filter-form',
		);

		$customers = \App\User::whereHas('roles',function($query){
			$query->where('name',config('constant.default_customer_role'));
		})->get()->pluck('full_name','id')->all();

		$query = getAccessibleUser(\Auth::user()->id,1);
		$users = $query->get()->pluck('name_with_designation_and_department','id')->all();
		$currencies = \App\Currency::all()->pluck('detail','id')->all();
		$quotation_status = [
			'draft' => trans('messages.invoice_draft'),
			'sent' => trans('messages.invoice_sent'),
			'invoice' => trans('messages.invoice'),
			'dead' => trans('messages.quotation_dead')
			];

		$menu = 'quotation';
		$assets = ['datatable'];

		return view('quotation.index',compact('menu','table_data','assets','customers','users','currencies','quotation_status'));
	}

	public function lists(Request $request){
		if(!Entrust::can('list-quotation'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

		$query = Quotation::whereNotNull('id');

		if(!Entrust::hasRole(config('constant.default_customer_role'))){
			if(Entrust::can('manage-all-designation')){}
			elseif(Entrust::can('manage-subordinate-designation'))
				$query->whereIn('user_id',getAccessibleUserList(\Auth::user()->id,1));
			else
				$query->where('user_id',\Auth::user()->id);
		} else
			$query->where('status','!=','draft')->where('customer_id',\Auth::user()->id);

		if($request->input('cancelled'))
			$query->whereIsCancelled(1);

        if($request->has('customer_id'))
            $query->whereIn('customer_id',$request->input('customer_id'));

        if($request->has('user_id'))
            $query->whereIn('user_id',$request->input('user_id'));

        if($request->has('status'))
            $query->whereIn('status',$request->input('status'));

        if($request->has('start_date') && $request->has('end_date'))
            $query->whereBetween('date',[$request->input('start_date'),$request->input('end_date')]);

        if($request->has('start_expiry_date') && $request->has('end_expiry_date'))
            $query->whereBetween('expiry_date',[$request->input('start_expiry_date'),$request->input('end_expiry_date')]);

		$quotations = $query->get();

        $col_ids = getCustomColId($this->form);
        $values = fetchCustomValues($this->form);
        $rows = array();

        foreach($quotations as $quotation){

        	if($quotation->is_cancelled)
        		$status = '<span class="label label-danger">'.trans('messages.cancelled').'</span>';
        	elseif($quotation->status == 'draft')
        		$status = '<span class="label label-info">'.trans('messages.invoice_draft').'</span>';
        	elseif($quotation->status == 'sent')
        		$status = '<span class="label label-success">'.trans('messages.invoice_sent').'</span>';
        	elseif($quotation->status == 'accepted')
        		$status = '<span class="label label-success">'.trans('messages.accepted').'</span>';
        	elseif($quotation->status == 'rejected')
        		$status = '<span class="label label-danger">'.trans('messages.quotation_rejected').'</span>';
        	elseif($quotation->status == 'invoice')
        		$status = '<span class="label label-info">'.trans('messages.quotation_converted').'</span>';
        	elseif($quotation->status == 'dead')
        		$status = '<span class="label label-danger">'.trans('messages.quotation_dead').'</span>';

			$row = array(
				'<div class="btn-group btn-group-xs">'.
				'<a href="/quotation/'.$quotation->uuid.'" class="btn btn-xs btn-default"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="'.trans('messages.edit').'"></i></a>'.
				(Entrust::can('edit-quotation') ? '<a href="/quotation/'.$quotation->uuid.'/edit" class="btn btn-xs btn-default" data-toggle="tooltip" title="'.trans('messages.edit').'"> <i class="fa fa-edit" ></i></a> ' : '').
				(Entrust::can('delete-quotation') ? delete_form(['quotation.destroy',$quotation->id]) : '').
				'</div>',
				$quotation->quotation_prefix.getQuotationNumber($quotation),
				$quotation->Customer->full_name,
				currency($quotation->total,1,$quotation->Currency->id),
				showDate($quotation->date),
				showDate($quotation->expiry_date),
				$status
				);
			$id = $quotation->id;

			foreach($col_ids as $col_id)
				array_push($row,isset($values[$id][$col_id]) ? $values[$id][$col_id] : '');
			$rows[] = $row;
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function fetch(Request $request){

		$query = Quotation::whereNotNull('id');

		if(!Entrust::hasRole(config('constant.default_customer_role'))){
			if(Entrust::can('manage-all-designation')){}
			elseif(Entrust::can('manage-subordinate-designation'))
				$query->whereIn('user_id',getAccessibleUserList(\Auth::user()->id,1));
			else
				$query->where('user_id',\Auth::user()->id);
		} else
			$query->where('status','!=','draft')->where('customer_id',\Auth::user()->id);

		if($request->input('type') == 'accepted')
			$query->whereStatus('invoice');

		if($request->input('type') == 'expired')
			$query->where('status','=','sent')->where('expiry_date','<',date('Y-m-d'));

		$quotations = $query->orderBy('date','desc')->get()->take(5);

		$type = $request->input('type');
		$size = 'xs';
		return view('quotation.fetch',compact('quotations','type','size'))->render();
	}

	public function create(){

		if(!Entrust::can('create-quotation'))
			return redirect('/quotation')->withErrors(trans('messages.permission_denied'));

		$item_type_lists = translateList(config('lists.item_type'));
		$customers = \App\User::whereHas('roles',function($query){
			$query->where('name',config('constant.default_customer_role'));
		})->get()->pluck('full_name','id')->all();
		$currencies = \App\Currency::all()->pluck('detail','id')->all();
		if(!count($currencies))
			return redirect('/invoice')->withErrors(trans('messages.no_currency_defined'));

		$default_currency = (\App\Currency::whereIsDefault(1)->count()) ? \App\Currency::whereIsDefault(1)->first() : \App\Currency::first();

		$taxations = \App\Taxation::all()->pluck('detail','value')->all();
		$assets = ['redactor'];
		return view('quotation.create',compact('customers','currencies','default_currency','taxations','item_type_lists','assets'));
	}

	public function edit($uuid){

		if(!Entrust::can('edit-quotation'))
			return redirect('/quotation')->withErrors(trans('messages.permission_denied'));

		$quotation = Quotation::whereUuid($uuid)->first();

		if(!$quotation || !$this->quotationAccessible($quotation))
			return redirect('/quotation')->withErrors(trans('messages.invalid_link'));

		$currency = $quotation->Currency;
		$item_type_lists = translateList(config('lists.item_type'));
		$customers = \App\User::whereHas('roles',function($query){
			$query->where('name',config('constant.default_customer_role'));
		})->get()->pluck('full_name','id')->all();
		$currencies = \App\Currency::all()->pluck('detail','id')->all();
		$items = \App\Item::all()->pluck('full_item_name','id')->all();
		$quotation_items = $quotation->QuotationItem;
		$assets = ['redactor'];
		$custom_field_values = getCustomFieldValues($this->form,$quotation->id);

        \App\Upload::whereModule('quotation')->whereModuleId($quotation->id)->whereStatus(1)->update(['is_temp_delete' => 0]);
        $uploads = \App\Upload::whereModule('quotation')->whereModuleId($quotation->id)->whereStatus(1)->get();

		return view('quotation.edit',compact('quotation','currency','customers','currencies','quotation_items','items','uuid','item_type_lists','custom_field_values','assets','uploads'));
	}

	public function isAccessible($quotation){

		$accessible = 1;
		if(!Entrust::hasRole(config('constant.default_customer_role')) && !$this->quotationAccessible($quotation))
			$accessible = 0;
		elseif(Entrust::hasRole(config('constant.default_customer_role')) && ($quotation->customer_id != \Auth::user()->id || $quotation->status == 'draft'))
			$accessible = 0;

		return $accessible;
	}

	public function show($uuid){

		$quotation = Quotation::whereUuid($uuid)->first();

		if(!$quotation || !$this->isAccessible($quotation))
			return redirect('/quotation')->withErrors(trans('messages.invalid_link'));

		if(Entrust::hasRole(config('constant.default_customer_role')) && $quotation->customer_id != \Auth::user()->id && $quotation->status != 'sent')
			return redirect('/quotation')->withErrors(trans('messages.invalid_link'));

        $uploads = \App\Upload::whereModule('quotation')->whereModuleId($quotation->id)->whereStatus(1)->get();

		$assets = ['summernote'];
		$menu = 'quotation';

		return view('quotation.show',compact('quotation','assets','uploads','menu'));
	}

	public function previewQuotation($uuid){

		$quotation = Quotation::whereUuid($uuid)->first();

		if(!$quotation || (!$this->isAccessible($quotation) && \Auth::check()))
			return redirect('/quotation')->withErrors(trans('messages.invalid_link'));

		return view('quotation.preview',compact('quotation'));
	}

	public function printQuotation($uuid){

		$quotation = Quotation::whereUuid($uuid)->first();

		if(!$quotation || !$this->isAccessible($quotation))
			return redirect('/quotation')->withErrors(trans('messages.invalid_link'));

		$action_type = 'print';

		return view('quotation.print',compact('quotation','action_type'));
	}

	public function pdfQuotation($uuid){

		$quotation = Quotation::whereUuid($uuid)->first();

		if(!$quotation || !$this->isAccessible($quotation))
			return redirect('/quotation')->withErrors(trans('messages.invalid_link'));

		$action_type = 'pdf';

		$pdf = PDF::loadView('quotation.print', compact('quotation','action_type'));
		return $pdf->download($uuid.'.pdf');
	}

	public function download($file){
        $upload = \App\Upload::whereAttachments($file)->whereModule('quotation')->whereStatus(1)->first();

        if(!$upload)
            return redirect('/quotation')->withErrors(trans('messages.invalid_link'));

        $quotation = Quotation::find($upload->module_id);

		if(!$quotation || !$this->isAccessible($quotation))
            return redirect('/quotation')->withErrors(trans('messages.invalid_link'));

        if(!\Storage::exists('attachments/'.$upload->attachments))
            return redirect('/quotation')->withErrors(trans('messages.file_not_found'));

        $download_path = storage_path().config('constant.storage_root').'attachments/'.$upload->attachments;

        return response()->download($download_path, $upload->user_filename);
	}

	public function fetchStatus(Request $request){
		$quotation = Quotation::find($request->input('quotation_id'));

		if(!$quotation || !$this->isAccessible($quotation))
			return;

		$size = 'md';
		return view('quotation.status',compact('quotation','size'))->render();
	}

	public function fetchActionButton(Request $request){
		$quotation = Quotation::find($request->input('quotation_id'));

		if(!$quotation || !$this->isAccessible($quotation))
			return;

		return view('quotation.action_button',compact('quotation'))->render();
	}

	public function customerAction(Request $request){
		$quotation = Quotation::find($request->input('quotation_id'));

		if(!$quotation || !$this->isAccessible($quotation))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		if($request->input('action') == 'accept' && !in_array($quotation->status, ['sent','rejected']))
	    	return response()->json(['status' => 'error','message' => trans('messages.permission_denied')]);

		if($request->input('action') == 'reject' && !in_array($quotation->status, ['sent','accepted']))
	    	return response()->json(['status' => 'error','message' => trans('messages.permission_denied')]);

		$quotation->status = ($request->input('action') == 'accept') ? 'accepted' : 'rejected';
		$quotation->save();
		$this->logActivity(['module' => 'quotation','module_id' => $quotation->id, 'activity' => $quotation->status]);

		$slug = ($request->input('action') == 'accept') ? 'quotation-accepted' : 'quotation-rejected';

		$pdf = PDF::loadView('quotation.print', compact('quotation','quotation_color','action_type'));
		$mail = array();
		$mail_data = $this->templateContent(['slug' => $slug,'quotation' => $quotation]);
		if(count($mail_data)){
	   	 	$mail['email'] = $quotation->Customer->email;
	   	 	$mail['filename'] = 'Quotation_'.$quotation->quotation_prefix.getQuotationNumber($quotation).'.pdf';
	   	 	$mail['subject'] = $mail_data['subject'];
	   	 	$body = $mail_data['body'];

	   	 	\Mail::send('emails.email', compact('body'), function ($message) use($pdf,$mail) {
	   	 		$message->attachData($pdf->output(), $mail['filename']);
	   	 		$message->to($mail['email'])->subject($mail['subject']);
	   	 	});
	   	 	$this->logEmail(array('to' => $mail['email'],'subject' => $mail['subject'],'body' => $body,'module' => 'quotation','module_id' =>$quotation->id));
		}

	    return response()->json(['status' => 'success','message' => trans('messages.quotation').' '.trans('messages.status').' '.trans('messages.updated')]);
	}

	public function store(QuotationRequest $request,$quotation_id = null){

		$quotation = ($quotation_id) ? Quotation::find($quotation_id) : new Quotation;
		$action = ($quotation_id) ? 'update' : 'store';

		if($action == 'store' && !Entrust::can('create-quotation'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error','force_redirect' => '/quotation']);

		if($action == 'update' && (!$quotation || !Entrust::can('edit-quotation') || !$this->quotationAccessible($quotation)))
            return response()->json(['message' => trans('messages.invalid_link'), 'status' => 'error','force_redirect' => '/quotation']);

		if($action == 'update' && $quotation->status == 'invoice' && $quotation->currency_id != $request->input('currency_id'))
            return response()->json(['message' => trans('messages.currency_cannot_be_changed_after_conversion'), 'status' => 'error']);

		if($request->has('send_quotation')){

	        $validation = Validator::make($request->all(),['customer_id' => 'required','date' => 'required']);
	        $friendly_names = ['customer_id' => 'customer'];
	        $validation->setAttributeNames($friendly_names);

	        if($validation->fails())
	            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

	        $validation = validateCustomField($this->form,$request);
	        
	        if($validation->fails())
                return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);
		}

		$previous_quotation_query = Quotation::whereNotNull('id');
		if($action == 'update')
			$previous_quotation_query->where('id','!',$quotation->id);

		$previous_quotation_number = $previous_quotation_query->where('quotation_number','>',$request->input('quotation_number'))->count();

		if($previous_quotation_number || !$request->input('quotation_number'))
            return response()->json(['message' => trans('messages.invalid_quotation_number'), 'status' => 'error']);

		if($request->input('date') > $request->input('expiry_date'))
            return response()->json(['message' => trans('messages.expiry_date_cannot_less_than_date'), 'status' => 'error']);

		$items = $request->input('item_name');
		$item_name_details = ($request->input('item_name_detail')) ? : [];
		$quantities = ($request->input('item_quantity')) ? : [];
		$prices = ($request->input('item_price')) ? : [];
		$discounts = ($request->input('item_discount')) ? : [];
		$discount_types = ($request->input('item_discount_type')) ? : [];
		$taxations = ($request->input('item_tax')) ? : [];
		$descriptions = ($request->input('item_description')) ? : [];

		$item_array = array();
		foreach($items as $item)
			$item_array[] = $item;

		if(!count($items))
            return response()->json(['message' => trans('messages.enter_item'), 'status' => 'error']);

		if(count($items) != count($item_array))
            return response()->json(['message' => trans('messages.duplicate_item'), 'status' => 'error']);

		if(($request->input('item_type') == 'quantity') && (count($quantities) != count($items) || count($prices) != count($items)))
            return response()->json(['message' => trans('messages.quantity_price_required'), 'status' => 'error']);

		if(($request->input('item_type') == 'hour') && (count($quantities) != count($items) || count($prices) != count($items)))
            return response()->json(['message' => trans('messages.hour_rate_required'), 'status' => 'error']);

		if($request->input('item_type') == 'amount_only' && count($items) != count($prices))
            return response()->json(['message' => trans('messages.price_required'), 'status' => 'error']);

		if($request->input('item_type') == 'quantity' || $request->input('item_type') == 'hour') {
			$quantity_error = 0;
			foreach($quantities as $quantity)
				if(!is_numeric($quantity))
					$quantity_error++;

			$price_error = 0;
			foreach($prices as $price)
				if(!is_numeric($price))
					$price_error++;

			if($request->input('item_type') == 'quantity' && ($quantity_error || $price_error))
	            return response()->json(['message' => trans('messages.quantity_price_format'), 'status' => 'error']);

			if($request->input('item_type') == 'hour' && ($quantity_error || $price_error))
	            return response()->json(['message' => trans('messages.hour_rate_format'), 'status' => 'error']);
		}

		if($request->has('line_item_tax')){
			$tax_error = 0;
			foreach($taxations as $taxation)
				if(!is_numeric($taxation))
					$tax_error++;

			if($tax_error)
	            return response()->json(['message' => trans('messages.tax_format'), 'status' => 'error']);
		}

		if($request->has('line_item_discount')){
			$discount_error = 0;
			foreach($discounts as $discount)
				if(!is_numeric($discount))
					$discount_error++;

			if($discount_error)
	            return response()->json(['message' => trans('messages.discount_format'), 'status' => 'error']);
		}

		if($request->has('subtotal_discount') && !is_numeric($request->input('subtotal_discount_amount')))
            return response()->json(['message' => trans('messages.subtotal_numeric_format'), 'status' => 'error']);
		
		if($request->has('subtotal_tax') && !is_numeric($request->input('subtotal_tax_amount')))
            return response()->json(['message' => trans('messages.subtotal_numeric_format'), 'status' => 'error']);
		
		if($request->has('subtotal_shipping_and_handling') && !is_numeric($request->input('subtotal_shipping_and_handling_amount')))
            return response()->json(['message' => trans('messages.subtotal_numeric_format'), 'status' => 'error']);

        if($action == 'store'){
	        $file_uploaded_count = \App\Upload::whereIn('upload_key',$request->input('upload_key'))->count();

	        if($file_uploaded_count > config('constant.max_file_allowed.quotation'))
	        	return response()->json(['message' => trans('messages.max_file_allowed',['attribute' => config('constant.max_file_allowed.quotation')]),'status' => 'error']);
        } elseif($action == 'update'){
	        $existing_upload = \App\Upload::whereModule('quotation')->whereModuleId($quotation->id)->whereIsTempDelete(0)->count();
	        $new_upload_count = 0;
	        foreach($request->input('upload_key') as $upload_key)
	            $new_upload_count += \App\Upload::whereModule('quotation')->whereUploadKey($upload_key)->count();
	        if($existing_upload + $new_upload_count > config('constant.max_file_allowed.quotation'))
	            return response()->json(['message' => trans('messages.max_file_allowed',['attribute' => config('constant.max_file_allowed.quotation')]),'status' => 'error']);
	        foreach($request->input('upload_key') as $upload_key){
	            $uploads = \App\Upload::whereModule('quotation')->whereUploadKey($upload_key)->get();
	            foreach($uploads as $upload){
	                $upload->module_id = $quotation->id;
	                $upload->status = 1;
	                $upload->save();
	                \Storage::move('temp_attachments/'.$upload->attachments, 'attachments/'.$upload->attachments);
	            }
	        }
	        $temp_delete_uploads = \App\Upload::whereModule('quotation')->whereModuleId($quotation->id)->whereIsTempDelete(1)->get();
	        foreach($temp_delete_uploads as $temp_delete_upload)
	            \Storage::delete('attachments/'.$temp_delete_upload->attachments);
	        \App\Upload::whereModule('quotation')->whereModuleId($quotation->id)->whereIsTempDelete(1)->delete();
        }

		$data = $request->all();
		$data['description'] = clean($request->input('description'),'custom');

		if($action == "update"){
			$previous_items = \App\QuotationItem::whereQuotationId($quotation->id)->pluck('item_key')->all();
			foreach($previous_items as $previous_item)
				if(!array_key_exists($previous_item, $items))
				\App\QuotationItem::whereItemKey($previous_item)->delete();
		}

		if($action == 'store'){
			$quotation->quotation_prefix = $request->input('quotation_prefix');
			$quotation->quotation_number = getQuotationNumber();
			$quotation->user_id = \Auth::user()->id;
		}

		$subtotal_discount_amount = ($request->has('subtotal_discount')) ? ($request->input('subtotal_discount_amount') ? : 0) : 0;
		$subtotal_discount_type = ($request->has('subtotal_discount') && $request->has('subtotal_discount_type')) ? 1 : 0; 
		$subtotal_tax_amount = ($request->has('subtotal_tax')) ? ($request->input('subtotal_tax_amount') ? : 0) : 0;
		$subtotal_shipping_and_handling_amount = ($request->has('subtotal_shipping_and_handling')) ? ($request->input('subtotal_shipping_and_handling_amount') ? : 0) : 0;

		$data['subtotal_discount_amount'] = $subtotal_discount_amount;
		$data['subtotal_tax_amount'] = $subtotal_tax_amount;
		$data['subtotal_shipping_and_handling_amount'] = $subtotal_shipping_and_handling_amount;
		$quotation->fill($data);
		$quotation->save();

		$data = $request->all();

		if($action == 'store')
			storeCustomField($this->form,$quotation->id, $data);
		else
			updateCustomField($this->form,$quotation->id, $data);

		$currency = $quotation->Currency;

		$subtotal = 0;
		foreach($items as $key => $item){
			$item_amount = 0;
			$quotation_item = \App\QuotationItem::firstOrNew(['item_key' => $key]);
			$quotation_item->quotation_id = $quotation->id;
			$quotation_item->item_key = $key;
			if(!array_key_exists($key, $item_name_details)){
				$item_detail = \App\Item::find($item);
				$quotation_item->item_id = $item;
				$quotation_item->item_name = $item_detail->name;
			} else 
			$quotation_item->item_name = $item;
			$quotation_item->item_quantity = ($request->input('item_type') != 'amount_only') ? $quantities[$key] : 1;
			$quotation_item->unit_price = $prices[$key];
			$quotation_item->item_discount = ($request->has('line_item_discount')) ? $discounts[$key] : 0;
			$quotation_item->item_discount_type = ($request->has('line_item_discount') && array_key_exists($key, $discount_types)) ? 1 : 0;
			$quotation_item->item_tax = ($request->has('line_item_tax')) ? $taxations[$key] : 0;
			$quotation_item->item_description = (array_key_exists($key, $descriptions)) ? $descriptions[$key] : null;

			$item_amount = $quotation_item->item_quantity * $quotation_item->unit_price;
			if($quotation_item->item_discount_type)
				$item_amount -= $quotation_item->item_discount;
			else
				$item_amount -= $item_amount*($quotation_item->item_discount/100);
			$item_amount += $item_amount*($quotation_item->item_tax/100);
			$quotation_item->item_amount = round($item_amount,$currency->decimal_place);
			$quotation_item->save();

			$subtotal += $item_amount;
		}

		if($subtotal_discount_type)
			$subtotal -= $subtotal_discount_amount;
		else
			$subtotal -= $subtotal*($subtotal_discount_amount/100);

		$subtotal += $subtotal*($subtotal_tax_amount/100);
		$subtotal += $subtotal_shipping_and_handling_amount;

		$quotation->total = round($subtotal,$currency->decimal_place);
		if($action == 'store')
			$quotation->uuid = Uuid::generate();

		$quotation->save();

		if($action == 'store'){
		    foreach($request->input('upload_key') as $upload_key){
		    	$uploads = \App\Upload::whereModule('quotation')->whereUploadKey($upload_key)->get();
		    	foreach($uploads as $upload){
	                $upload->module_id = $quotation->id;
	                $upload->status = 1;
	                $upload->save();
	                \Storage::move('temp_attachments/'.$upload->attachments, 'attachments/'.$upload->attachments);
		    	}
		    }
		}

		if($request->input('form_action') == 'send'){
			$quotation->status = 'sent';
			$quotation->save();
			$action_type = 'pdf';
			$pdf = PDF::loadView('quotation.print', compact('quotation','action_type'));
			
			$mail = array();
			$mail_data = $this->templateContent(['slug' => 'send-quotation','quotation' => $quotation]);
			
			if(count($mail_data)){
		   	 	$mail['email'] = $quotation->Customer->email;
		   	 	$mail['filename'] = 'Quotation_'.$quotation->quotation_prefix.getQuotationNumber($quotation).'.pdf';
		   	 	$mail['subject'] = $mail_data['subject'];
		   	 	$body = $mail_data['body'];

		   	 	\Mail::send('emails.email', compact('body'), function ($message) use($pdf,$mail) {
		   	 		$message->attachData($pdf->output(), $mail['filename']);
		   	 		$message->to($mail['email'])->subject($mail['subject']);
		   	 	});
		   	 	$this->logEmail(array('to' => $mail['email'],'subject' => $mail['subject'],'body' => $body,'module' => 'quotation','module_id' =>$quotation->id));
			}
		}

		if($action == "update"){
			$this->logActivity(['module' => 'quotation','module_id' => $quotation->id, 'activity' => 'updated']);
			$message = trans('quotation').' '.trans('messages.updated');
		}
		else{
			$this->logActivity(['module' => 'quotation','module_id' => $quotation->id, 'activity' => 'added']);
			$message = trans('quotation').' '.trans('messages.generated');
		}

        return response()->json(['message' => $message, 'status' => 'success','redirect' => '/quotation/'.$quotation->uuid]);
	}

	public function listEmail(Request $request){

		$quotation = Quotation::find($request->input('quotation_id'));

		if(!$quotation || !$this->quotationAccessible($quotation))
			return;

		$emails = \App\Email::whereModule('quotation')->whereModuleId($request->input('quotation_id'))->orderBy('created_at','desc')->get();

		return view('quotation.email_list',compact('emails'));
	}

	public function markAsSent(Request $request){
		$quotation = Quotation::find($request->input('quotation_id'));

		if(!$quotation || !$this->quotationAccessible($quotation))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		if($quotation->status == 'sent')
	    	return response()->json(['status' => 'error','message' => trans('messages.quotation_already_marked_as_sent')]);

		$quotation->status = 'sent';
		$quotation->save();
		$this->logActivity(['module' => 'quotation','module_id' => $quotation->id, 'activity' => 'marked_as_sent']);

    	return response()->json(['status' => 'success','message' => trans('messages.quotation').' '.trans('messages.marked').' '.trans('messages.as').' '.trans('messages.sent')]);
	}

	public function markAsDead(Request $request){
		$quotation = Quotation::find($request->input('quotation_id'));

		if(!$quotation || !$this->quotationAccessible($quotation))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		if($quotation->status != 'sent' || $quotation->expiry_date > date('Y-m-d'))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		$quotation->status = 'dead';
		$quotation->save();
		$this->logActivity(['module' => 'quotation','module_id' => $quotation->id, 'activity' => 'marked_as_dead']);

    	return response()->json(['status' => 'success','message' => trans('messages.quotation').' '.trans('messages.marked').' '.trans('messages.as').' '.trans('messages.dead')]);
	}

	public function cancel(Request $request){
		$quotation = Quotation::find($request->input('quotation_id'));

		if(!$quotation || !$this->quotationAccessible($quotation))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		if($quotation->status == 'invoice')
	    	return response()->json(['status' => 'error','message' => trans('messages.cannot_cancel_invoiced_quotation')]);

		$quotation->is_cancelled = 1;
		$quotation->save();
		$this->logActivity(['module' => 'quotation','module_id' => $quotation->id, 'activity' => 'cancelled']);

    	return response()->json(['status' => 'success','message' => trans('messages.quotation').' '.trans('messages.cancelled')]);
	}

	public function undoCancel(Request $request){
		$quotation = Quotation::find($request->input('quotation_id'));

		if(!$quotation || !$this->quotationAccessible($quotation) || !$quotation->is_cancelled)
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		$quotation->is_cancelled = 0;
		$quotation->save();
		$this->logActivity(['module' => 'quotation','module_id' => $quotation->id, 'activity' => 'undo_cancelled']);

    	return response()->json(['status' => 'success','message' => trans('messages.quotation').' '.trans('messages.updated')]);
	}

	public function convert(Request $request){
		$quotation = Quotation::find($request->input('quotation_id'));

		if(!$quotation || !$this->quotationAccessible($quotation))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		if($quotation->status != 'sent' && $quotation->status != 'accepted')
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		$invoice = new \App\Invoice;
		$invoice->uuid = Uuid::generate();
		$invoice->customer_id = $quotation->customer_id;
		$invoice->user_id = \Auth::user()->id;
		$invoice->currency_id = $quotation->currency_id;
		$invoice->invoice_prefix = config('config.invoice_prefix');
		$invoice->invoice_number = getInvoiceNumber();
		$invoice->date = date('Y-m-d');
		$invoice->reference_number = $quotation->reference_number;
		$invoice->due_date = 'no_due_date';
		$invoice->line_item_tax = $quotation->line_item_tax;
		$invoice->line_item_discount = $quotation->line_item_discount;
		$invoice->line_item_description = $quotation->line_item_description;
		$invoice->subtotal_tax = $quotation->subtotal_tax;
		$invoice->subtotal_discount = $quotation->subtotal_discount;
		$invoice->subtotal_shipping_and_handling = $quotation->subtotal_shipping_and_handling;
		$invoice->item_type = $quotation->item_type;
		$invoice->subtotal_tax_amount = $quotation->subtotal_tax_amount;
		$invoice->subtotal_discount_amount = $quotation->subtotal_discount_amount;
		$invoice->subtotal_discount_type = $quotation->subtotal_discount_type;
		$invoice->subtotal_shipping_and_handling_amount = $quotation->subtotal_shipping_and_handling_amount;
		$invoice->total = $quotation->total;
		$invoice->quotation_id = $quotation->id;
		$invoice->save();

		$quotation->status = 'invoice';
		$quotation->invoice_id = $invoice->id;
		$quotation->save();

		foreach($quotation->QuotationItem as $quotation_item){
			$invoice_item = new \App\InvoiceItem;
			$invoice_item->item_key = randomString(40);
			$invoice_item->invoice_id = $invoice->id;
			$invoice_item->item_id = $quotation_item->item_id;
			$invoice_item->item_name = $quotation_item->item_name;
			$invoice_item->item_quantity = $quotation_item->item_quantity;
			$invoice_item->unit_price = $quotation_item->unit_price;
			$invoice_item->item_discount = $quotation_item->item_discount;
			$invoice_item->item_discount_type = $quotation_item->item_discount_type;
			$invoice_item->item_tax = $quotation_item->item_tax;
			$invoice_item->item_amount = $quotation_item->item_amount;
			$invoice_item->item_description = $quotation_item->item_description;
			$invoice_item->save();
		}
		$this->logActivity(['module' => 'quotation','module_id' => $quotation->id, 'activity' => 'converted']);

    	return response()->json(['status' => 'success','message' => trans('messages.quotation').' '.trans('messages.converted'),'redirect' => '/invoice/'.$invoice->uuid]);
	}

	public function copy(Request $request){
		$quotation = Quotation::find($request->input('quotation_id'));

		if(!$quotation || !$this->quotationAccessible($quotation))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		$new_quotation = $quotation->replicate();
		$new_quotation->uuid = Uuid::generate();
		$new_quotation->quotation_number = getQuotationNumber();
		$new_quotation->status = 'draft';
		$new_quotation->save();

		foreach($quotation->QuotationItem as $quotation_item){
			$new_quotation_item = $quotation_item->replicate();
			$new_quotation_item->quotation_id = $new_quotation->id;
			$new_quotation_item->item_key = randomString(40);
			$new_quotation_item->save();
		}
		$this->logActivity(['module' => 'quotation','module_id' => $quotation->id, 'activity' => 'copied']);

    	return response()->json(['status' => 'success','message' => trans('messages.quotation').' '.trans('messages.copied'),'redirect' => '/quotation/'.$new_quotation->uuid]);
	}

	public function email(Request $request){
		$quotation = Quotation::find($request->input('quotation_id'));

		if(!$quotation || !$this->quotationAccessible($quotation))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		$slug = $request->input('email');

		if($quotation->status == 'invoice' && ($slug == 'quotation-reminder' || $slug == 'quotation-expired' ))
	    	return response()->json(['status' => 'error','message' => trans('messages.quotation_already_converted')]);

		if($slug == 'send-quotation'){
			$quotation->status = 'sent';
			$quotation->save();
		}

		$action_type = 'pdf';
		$pdf = PDF::loadView('quotation.print', compact('quotation','action_type'));
		$mail = array();
		$mail_data = $this->templateContent(['slug' => $slug,'quotation' => $quotation]);
		if(count($mail_data)){
	   	 	$mail['email'] = $quotation->Customer->email;
	   	 	$mail['filename'] = 'Quotation_'.$quotation->quotation_prefix.getQuotationNumber($quotation).'.pdf';
	   	 	$mail['subject'] = $mail_data['subject'];
	   	 	$body = $mail_data['body'];

	   	 	\Mail::send('emails.email', compact('body'), function ($message) use($pdf,$mail) {
	   	 		$message->attachData($pdf->output(), $mail['filename']);
	   	 		$message->to($mail['email'])->subject($mail['subject']);
	   	 	});
	   	 	$this->logEmail(array('to' => $mail['email'],'subject' => $mail['subject'],'body' => $body,'module' => 'quotation','module_id' =>$quotation->id));
			$this->logActivity(['module' => 'quotation','module_id' => $quotation->id, 'activity' => 'mail_sent']);
		}

    	return response()->json(['status' => 'success','message' => trans('messages.email').' '.trans('messages.sent')]);
	}

	public function customEmail($uuid){
		$quotation = Quotation::whereUuid($uuid)->first();

		if(!$quotation || !$this->quotationAccessible($quotation))
            return view('global.error',['message' => trans('messages.invalid_link')]);

        $templates = \App\Template::whereCategory('quotation')->get()->pluck('name','id')->all();
        return view('quotation.custom_email',compact('quotation','templates'));
	}

	public function postCustomEmail(Request $request, $uuid){

		$quotation = Quotation::whereUuid($uuid)->first();

		if(!$quotation || !$this->quotationAccessible($quotation))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

        $validation = Validator::make($request->all(),[
            'subject' => 'required',
            'body' => 'required'
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        $mail['email'] = $quotation->Customer->email;
        $mail['subject'] = $request->input('subject');
        $body = clean($request->input('body'),'custom');

        \Mail::send('emails.email', compact('body'), function($message) use ($mail){
            $message->to($mail['email'])->subject($mail['subject']);
        });
        $this->logEmail(array('to' => $mail['email'],'subject' => $mail['subject'],'body' => $body,'module' => 'quotation','module_id' =>$quotation->id));

        $this->logActivity(['module' => 'quotation','module_id' => $quotation->id,'activity' => 'mail_sent']);
        return response()->json(['message' => trans('messages.mail').' '.trans('messages.sent'), 'status' => 'success']);
	}

	public function destroy(Request $request,Quotation $quotation){

		if(!Entrust::can('delete-quotation') || !$this->quotationAccessible($quotation))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);
		
        if(getMode()){
            $uploads = \App\Upload::whereModule('quotation')->whereModuleId($quotation->id)->get();
            foreach($uploads as $upload)
                \Storage::delete('quotation/'.$upload->attachments);
            \App\Upload::whereModule('quotation')->whereModuleId($quotation->id)->delete();
        }

		$this->logActivity(['module' => 'quotation','module_id' => $quotation->id,'activity' => 'deleted']);
		deleteCustomField($this->form, $quotation->id);
		$quotation->delete();

	    return response()->json(['status' => 'success','message' => trans('messages.quotation').' '.trans('messages.deleted'),'redirect' => '/quotation']);
	}

	public function discussion(Request $request){
		$quotation = Quotation::find($request->input('quotation_id'));

		if(!$quotation || !$this->isAccessible($quotation))
			return;

		return view('quotation.discussion',compact('quotation'))->render();
	}

	public function storeDiscussion(Request $request, $quotation_id){
		$quotation = Quotation::find($quotation_id);

		if(!$quotation || !$this->isAccessible($quotation) || $quotation->status == 'dead')
            return response()->json(['message' => trans('messages.invalid_link'), 'status' => 'error']);

        $validation = Validator::make($request->all(),['comment' => 'required']);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

		$quotation_discussion = new \App\QuotationDiscussion;
		$quotation_discussion->user_id = \Auth::user()->id;
		$quotation_discussion->quotation_id = $quotation_id;
		$quotation_discussion->comment = $request->input('comment');
		$quotation_discussion->save();
		$this->logActivity(['module' => 'quotation','module_id' => $quotation->id, 'sub_module' => 'discussion','sub_module_id' => $quotation_discussion->id, 'activity' => 'discussion_started']);

        return response()->json(['message' => trans('messages.discussion').' '.trans('messages.posted'), 'status' => 'success']);
	}

	public function storeDiscussionReply(Request $request){
		$quotation_discussion = \App\QuotationDiscussion::find($request->input('quotation_discussion_id'));

		if(!$quotation_discussion)
        	return response()->json(['message' => trans('messages.invalid_link'), 'status' => 'error']);

		$quotation = ($quotation_discussion) ? $quotation_discussion->Quotation : null;

		if(!$quotation || !$this->isAccessible($quotation) || $quotation->status == 'dead')
        	return response()->json(['message' => trans('messages.invalid_link'), 'status' => 'error']);

        $validation = Validator::make($request->all(),['comment' => 'required']);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        $new_quotation_discussion = new \App\QuotationDiscussion;
        $new_quotation_discussion->user_id = \Auth::user()->id;
        $new_quotation_discussion->quotation_id = $quotation_discussion->quotation_id;
        $new_quotation_discussion->comment = $request->input('comment');
        $new_quotation_discussion->reply_id = $request->input('quotation_discussion_id');
        $new_quotation_discussion->save();
		$this->logActivity(['module' => 'quotation','module_id' => $quotation->id, 'sub_module' => 'discussion','sub_module_id' => $quotation_discussion->id, 'activity' => 'discussion_replied']);

        $new_data = '<li class="media">
						<a class="pull-left" href="#">'.
						  getAvatar($new_quotation_discussion->user_id,40).
						'</a>
						<div class="media-body">
						  <h4 class="media-heading"><a href="#">'.$new_quotation_discussion->User->full_name.'</a> <small>'.showDateTime($new_quotation_discussion->created_at).'</small></h4>'.
						  $new_quotation_discussion->comment.
						'</div>
					  </li>';

        return response()->json(['message' => trans('messages.comment').' '.trans('messages.posted'), 'status' => 'success','new_data' => $new_data]);
	}
}