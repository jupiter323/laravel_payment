<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\InvoiceRequest;
use Entrust;
use App\Invoice;
use App\Unit;
use App\Document;

use Uuid;
use PDF;
use Validator;
ini_set('memory_limit', '-1'); 

Class InvoiceController extends Controller{
    use BasicController;

	protected $form = 'invoice-form';

    public function __construct()
    {
        $this->middleware(['staff_accessible'])->except(['index','lists','show','previewInvoice','printInvoice','pdfInvoice','fetchActionButton','fetchStatus','listPayment','showPayment','validateCoupon','fetch','download']);
    }

	public function index(){

		if(!Entrust::can('list-invoice'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

        $data = array(
        		trans('messages.option'),
        		trans('messages.number'),
        		trans('messages.customer'),
        		trans('messages.amount'),
        		trans('messages.date'),
        		trans('messages.due').' '.trans('messages.date'),
        		trans('messages.status')
        		);

        $data = putCustomHeads($this->form, $data);
        $table_data['invoice-table'] = array(
			'source' => 'invoice',
			'title' => 'Invoice List',
			'id' => 'invoice_table',
			'data' => $data,
			'form' => 'invoice-filter-form',
		);

		$customers = \App\User::whereHas('roles',function($query){
			$query->where('name',config('constant.default_customer_role'));
		})->get()->pluck('full_name','id')->all();

		$query = getAccessibleUser(\Auth::user()->id,1);
		$users = $query->get()->pluck('name_with_designation_and_department','id')->all();
		$currencies = \App\Currency::all()->pluck('detail','id')->all();
		$invoice_status = ['draft' => trans('messages.invoice_draft'),'sent' => trans('messages.invoice_sent')];
		$invoice_payment_status = ['unpaid' => trans('messages.unpaid'),'partially_paid' => trans('messages.partially_paid'),'paid' => trans('messages.paid')];

		$menu = 'invoice';
		$assets = ['datatable'];

		return view('invoice.index',compact('menu','table_data','assets','customers','currencies','invoice_status','invoice_payment_status','users'));
	}

	public function lists(Request $request){
		if(!Entrust::can('list-invoice'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

		$query = Invoice::whereNotNull('id');

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

		if($request->input('recurring'))
			$query->whereIsRecurring(1);

        if($request->has('customer_id'))
            $query->whereIn('customer_id',$request->input('customer_id'));

        if($request->has('user_id'))
            $query->whereIn('user_id',$request->input('user_id'));

        if($request->has('status'))
            $query->whereIn('status',$request->input('status'));

        if($request->has('payment_status'))
            $query->whereIn('payment_status',$request->input('payment_status'));

        if($request->has('start_date') && $request->has('end_date'))
            $query->whereBetween('date',[$request->input('start_date'),$request->input('end_date')]);

        if($request->input('overdue'))
        	$query->whereNotNull('due_date_detail')->where('due_date_detail','<',date('Y-m-d'));

		$invoices = $query->get();
        $col_ids = getCustomColId($this->form);
        $values = fetchCustomValues($this->form);
        $rows = array();

        foreach($invoices as $invoice){

        	if($invoice->is_cancelled)
        		$status = '<span class="label label-danger">'.trans('messages.cancelled').'</span>';
        	elseif($invoice->status == 'draft')
        		$status = '<span class="label label-info">'.trans('messages.invoice_draft').'</span>';
        	elseif($invoice->status == 'sent'){
        		$status = '<span class="label label-success">'.trans('messages.invoice_sent').'</span>';

    		if($invoice->payment_status == 'unpaid')
    			$status .= ' <span class="label label-danger">'.trans('messages.unpaid').'</span>';
    		elseif($invoice->payment_status == 'partially_paid')
    			$status .= ' <span class="label label-warning">'.trans('messages.partially_paid').'</span>';
    		elseif($invoice->payment_status == 'paid')
    			$status .= ' <span class="label label-success">'.trans('messages.paid').'</span>';
        	}

			$row = array(
				'<div class="btn-group btn-group-xs">'.
				'<a href="/invoice/'.$invoice->uuid.'" class="btn btn-xs btn-default"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="'.trans('messages.edit').'"></i></a>'.
				(Entrust::can('edit-invoice') ? '<a href="/invoice/'.$invoice->uuid.'/edit" class="btn btn-xs btn-default" data-toggle="tooltip" title="'.trans('messages.edit').'"> <i class="fa fa-edit" ></i></a> ' : '').
				(Entrust::can('delete-invoice') ? delete_form(['invoice.destroy',$invoice->id]) : '').
				'</div>',
				$invoice->invoice_prefix.getInvoiceNumber($invoice),
				($invoice->Customer) ? $invoice->Customer->full_name : '',
				currency($invoice->total,1,$invoice->Currency->id),
				showDate($invoice->date),
				showDate($invoice->due_date_detail),
				$status
				);
			$id = $invoice->id;

			foreach($col_ids as $col_id)
				array_push($row,isset($values[$id][$col_id]) ? $values[$id][$col_id] : '');
			$rows[] = $row;
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function fetch(Request $request){

		$query = Invoice::whereNotNull('id');

		if(!Entrust::hasRole(config('constant.default_customer_role'))){
			if(Entrust::can('manage-all-designation')){}
			elseif(Entrust::can('manage-subordinate-designation'))
				$query->whereIn('user_id',getAccessibleUserList(\Auth::user()->id,1));
			else
				$query->where('user_id',\Auth::user()->id);
		} else
			$query->where('status','!=','draft')->where('customer_id',\Auth::user()->id);

		if($request->input('type') == 'unpaid')
			$query->whereStatus('unpaid');

		if($request->input('type') == 'partially_paid')
			$query->whereStatus('partially_paid');

		if($request->input('type') == 'overdue')
			$query->where('status','!=','paid')->whereNotNull('due_date_detail')->where('due_date_detail','<',date('Y-m-d'));

		if($request->input('type') == 'recurring')
			$query->whereIsRecurring('1')->orderBy('date','desc')->get()->take(5);

		$invoices = $query->orderBy('date','desc')->get()->take(5);

		$type = $request->input('type');
		$size = 'xs';
		return view('invoice.fetch',compact('invoices','type','size'))->render();
	}

	public function create(){

		if(!Entrust::can('create-invoice'))
			return redirect('/invoice')->withErrors(trans('messages.permission_denied'));

		$invoice_due_date_lists = translateList(config('lists.invoice_due_date'));
		$item_type_lists = translateList(config('lists.item_type'));
		$customers = \App\User::whereHas('roles',function($query){
			$query->where('name',config('constant.default_customer_role'));
		})->get()->pluck('full_name','id')->all();
		$currencies = \App\Currency::all()->pluck('detail','id')->all();
                $shipment_address = \App\ShipmentAddress::all()->pluck('shipment_address','id')->all();
               // $unit= array();

		if(!count($currencies))
			return redirect('/invoice')->withErrors(trans('messages.no_currency_defined'));

		$default_currency = (\App\Currency::whereIsDefault(1)->count()) ? \App\Currency::whereIsDefault(1)->first() : \App\Currency::first();
		$taxations = \App\Taxation::all()->pluck('detail','value')->all();
                $documents = \App\Document ::all()->pluck('name','id')->all();
                $payment_methods = \App\PaymentMethod ::all()->pluck('name','id')->all();

if (Auth::check())
 {
 $id=Auth::user()->id;
 }   
$profiles=\App\Profile::where('user_id',$id)->get();
foreach ($profiles as $profile)
{
$company_id=$profile['company_id'];
$companys=\App\Company::where('id',$company_id)->get();
}
		return view('invoice.create',compact('invoice_due_date_lists','customers','currencies','default_currency','taxations','test','item_type_lists','documents','shipment_address','payment_methods','companys'));
	}

	public function addRow(){
		$items = \App\Item::all()->pluck('full_item_name','id')->all();
		$taxations = \App\Taxation::all()->pluck('detail','value')->all();
		$unique_id = randomString(40);
                $units= \App\Unit::all()->pluck('name','id')->all();
			
		$data = view('invoice.add_row',compact('items','taxations','unique_id','units'))->render();
        return response()->json(['data' => $data, 'message' => trans('messages.row_added'), 'status' => 'success']);
	}

	public function edit($uuid){

		if(!Entrust::can('edit-invoice'))
			return redirect('/invoice')->withErrors(trans('messages.permission_denied'));

		$invoice = Invoice::whereUuid($uuid)->first();

		if(!$invoice || !$this->invoiceAccessible($invoice))
			return redirect('/invoice')->withErrors(trans('messages.invalid_link'));

		$currency = $invoice->Currency;
		$invoice_due_date_lists = translateList(config('lists.invoice_due_date'));
		$item_type_lists = translateList(config('lists.item_type'));
		$customers = \App\User::whereHas('roles',function($query){
			$query->where('name',config('constant.default_customer_role'));
		})->get()->pluck('full_name','id')->all();
		$currencies = \App\Currency::all()->pluck('detail','id')->all();
		$items = \App\Item::all()->pluck('full_item_name','id')->all();
		$invoice_items = $invoice->InvoiceItem;
		$custom_field_values = getCustomFieldValues($this->form,$invoice->id);

        \App\Upload::whereModule('invoice')->whereModuleId($invoice->id)->whereStatus(1)->update(['is_temp_delete' => 0]);
        $uploads = \App\Upload::whereModule('invoice')->whereModuleId($invoice->id)->whereStatus(1)->get();

		return view('invoice.edit',compact('invoice','currency','invoice_due_date_lists','customers','currencies','invoice_items','items','uuid','item_type_lists','custom_field_values','uploads'));
	}

	public function isAccessible($invoice){

		$accessible = 1;
		if(!Entrust::hasRole(config('constant.default_customer_role')) && !$this->invoiceAccessible($invoice))
			$accessible = 0;
		elseif(Entrust::hasRole(config('constant.default_customer_role')) && ($invoice->customer_id != \Auth::user()->id || $invoice->status != 'sent'))
			$accessible = 0;

		return $accessible;
	}

	public function show($uuid){

		$invoice = Invoice::whereUuid($uuid)->first();

		if(!$invoice || !$this->isAccessible($invoice))
			return redirect('/invoice')->withErrors(trans('messages.invalid_link'));

		$income_categories = \App\IncomeCategory::all()->pluck('name','id')->all();
		$payment_methods = \App\PaymentMethod::whereType('income')->get()->pluck('name','id')->all();
		$accounts = \App\Account::all()->pluck('name','id')->all();
		$recurring_days = translateListValue(config('lists.recurring_days'));

		$assets = ['tags','summernote'];
		$menu = 'invoice';

		if(Entrust::hasRole(config('constant.default_customer_role')) && config('config.enable_customer_payment') && config('config.enable_stripe_payment'))
			array_push($assets, 'stripe');

		if(Entrust::hasRole(config('constant.default_customer_role')) && config('config.enable_customer_payment') && config('config.enable_tco_payment'))
			array_push($assets, 'tco');

		$paid = $this->getInvoiceTransaction($invoice,'sum');
		$balance = $invoice->total - $paid;

        $invoice_uploads = \App\Upload::whereModule('invoice')->whereModuleId($invoice->id)->whereStatus(1)->get();

		return view('invoice.show',compact('invoice','income_categories','payment_methods','accounts','assets','recurring_days','balance','invoice_uploads','menu'));
	}

	public function previewInvoice($uuid){

		$invoice = Invoice::whereUuid($uuid)->first();

		if(!$invoice || (!$this->isAccessible($invoice) && \Auth::check()))
			return redirect('/invoice')->withErrors(trans('messages.invalid_link'));

		$no_payment = 1;
		return view('invoice.preview',compact('invoice','no_payment'));
	}

	public function getInvoiceColor($invoice){
		if($invoice->payment_status == 'unpaid')
			$invoice_color = '#C9302C';
		elseif($invoice->payment_status == 'partially_paid')
			$invoice_color = '#EC971F';
		elseif($invoice->payment_status == 'paid')
			$invoice_color = '#5CB85C';
		else
			$invoice_color = '#337AB7';

		return $invoice_color;
	}

	public function printInvoice($uuid){

		$invoice = Invoice::whereUuid($uuid)->first();

		if(!$invoice || !$this->isAccessible($invoice))
			return redirect('/invoice')->withErrors(trans('messages.invalid_link'));

		$invoice_color = $this->getInvoiceColor($invoice);
		$action_type = 'print';

		return view('invoice.print',compact('invoice','invoice_color','action_type'));
	}

	public function pdfInvoice($uuid){

		$invoice = Invoice::whereUuid($uuid)->first();

		if(!$invoice || !$this->isAccessible($invoice))
			return redirect('/invoice')->withErrors(trans('messages.invalid_link'));

		$invoice_color = $this->getInvoiceColor($invoice);
		$action_type = 'pdf';

		$pdf = PDF::loadView('invoice.print', compact('invoice','invoice_color','action_type'));
		return $pdf->download($uuid.'.pdf');
	}

	public function download($file){
        $upload = \App\Upload::whereAttachments($file)->whereModule('invoice')->whereStatus(1)->first();

        if(!$upload)
            return redirect('/invoice')->withErrors(trans('messages.invalid_link'));

        $invoice = Quotation::find($upload->module_id);

		if(!$invoice || !$this->isAccessible($invoice))
            return redirect('/invoice')->withErrors(trans('messages.invalid_link'));

        if(!\Storage::exists('attachments/'.$upload->attachments))
            return redirect('/invoice')->withErrors(trans('messages.file_not_found'));

        $download_path = storage_path().config('constant.storage_root').'attachments/'.$upload->attachments;

        return response()->download($download_path, $upload->user_filename);
	}

	public function fetchStatus(Request $request){
		$invoice = Invoice::find($request->input('invoice_id'));

		if(!$invoice || !$this->isAccessible($invoice))
			return;

		$paid = $this->getInvoiceTransaction($invoice,'sum');

		if($paid == 0)
			$invoice->payment_status = 'unpaid';
		elseif($paid > 0 && $paid < $invoice->total)
			$invoice->payment_status = 'partially_paid';
		else
			$invoice->payment_status = 'paid';
		$invoice->save();

		$size = 'md';
		return view('invoice.status',compact('invoice','size'))->render();
	}

	public function fetchActionButton(Request $request){
		$invoice = Invoice::find($request->input('invoice_id'));

		if(!$invoice || !$this->isAccessible($invoice))
			return;

		return view('invoice.action_button',compact('invoice'))->render();
	}

	public function store(InvoiceRequest $request,$invoice_id = null){

		$invoice = ($invoice_id) ? Invoice::find($invoice_id) : new Invoice;
		$action = ($invoice_id) ? 'update' : 'store';

		if($action == 'store' && !Entrust::can('create-invoice'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error','force_redirect' => '/invoice']);

		if($action == 'update' && (!$invoice || !Entrust::can('edit-invoice') || !$this->invoiceAccessible($invoice)))
            return response()->json(['message' => trans('messages.invalid_link'), 'status' => 'error','force_redirect' => '/invoice']);

		if($action == 'update' && $this->getInvoiceTransaction($invoice,'count') && $invoice->currency_id != $request->input('currency_id'))
            return response()->json(['message' => trans('messages.currency_cannot_be_changed_after_payment'), 'status' => 'error']);

		if($request->has('send_invoice')){

	        $validation = Validator::make($request->all(),['customer_id' => 'required','date' => 'required']);
	        $friendly_names = ['customer_id' => 'customer'];
	        $validation->setAttributeNames($friendly_names);

	        if($validation->fails())
	            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

	        $validation = validateCustomField($this->form,$request);
	        
	        if($validation->fails())
                return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);
		}

		$previous_invoice_query = Invoice::whereNotNull('id');
		if($action == 'update')
			$previous_invoice_query->where('id','!',$invoice->id);

		$previous_invoice_number = $previous_invoice_query->where('invoice_number','>',$request->input('invoice_number'))->count();

		if($previous_invoice_number || !$request->input('invoice_number'))
            return response()->json(['message' => trans('messages.invalid_invoice_number'), 'status' => 'error']);

		if($request->input('invoice_due_date') == 'due_on_date' && (!$request->has('due_date_detail') || $request->input('date') > $request->input('due_date_detail')))
            return response()->json(['message' => trans('messages.due_date_detail_required'), 'status' => 'error']);

		if($action == 'update'){
			$transaction = $this->getInvoiceTransaction($invoice,'last');

			if($transaction && $transaction->date < $request->input('date'))
	            return response()->json(['message' => trans('messages.payment_date_less_than_invoice_date'), 'status' => 'error']);
		}

		$items = $request->input('item_name');
		$item_name_details = ($request->input('item_name_detail')) ? : [];
		$quantities = ($request->input('item_quantity')) ? : [];
		$prices = ($request->input('item_price')) ? : [];
		$discounts = ($request->input('item_discount')) ? : [];
               
		$discount_types = ($request->input('item_discount_type')) ? : [];
		$taxations = ($request->input('item_tax')) ? : [];
		$descriptions = ($request->input('item_description')) ? : [];
		$subtotal1s = ($request->input('subtotal1')) ? : [];


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

	        if($file_uploaded_count > config('constant.max_file_allowed.invoice'))
	        	return response()->json(['message' => trans('messages.max_file_allowed',['attribute' => config('constant.max_file_allowed.invoice')]),'status' => 'error']);
        } elseif($action == 'update'){
	        $existing_upload = \App\Upload::whereModule('invoice')->whereModuleId($invoice->id)->whereIsTempDelete(0)->count();
	        $new_upload_count = 0;
	        foreach($request->input('upload_key') as $upload_key)
	            $new_upload_count += \App\Upload::whereModule('invoice')->whereUploadKey($upload_key)->count();
	        if($existing_upload + $new_upload_count > config('constant.max_file_allowed.invoice'))
	            return response()->json(['message' => trans('messages.max_file_allowed',['attribute' => config('constant.max_file_allowed.invoice')]),'status' => 'error']);
	        foreach($request->input('upload_key') as $upload_key){
	            $uploads = \App\Upload::whereModule('invoice')->whereUploadKey($upload_key)->get();
	            foreach($uploads as $upload){
	                $upload->module_id = $invoice->id;
	                $upload->status = 1;
	                $upload->save();
	                \Storage::move('temp_attachments/'.$upload->attachments, 'attachments/'.$upload->attachments);
	            }
	        }
	        $temp_delete_uploads = \App\Upload::whereModule('invoice')->whereModuleId($invoice->id)->whereIsTempDelete(1)->get();
	        foreach($temp_delete_uploads as $temp_delete_upload)
	            \Storage::delete('attachments/'.$temp_delete_upload->attachments);
	        \App\Upload::whereModule('invoice')->whereModuleId($invoice->id)->whereIsTempDelete(1)->delete();
        }

		$data = $request->all();
		if(!$request->input('due_date_detail'))
			unset($data['due_date_detail']);

		if($action == "update"){
			$previous_items = \App\InvoiceItem::whereInvoiceId($invoice->id)->pluck('item_key')->all();
			foreach($previous_items as $previous_item)
				if(!array_key_exists($previous_item, $items))
				\App\InvoiceItem::whereItemKey($previous_item)->delete();
		}

		if($request->input('due_date') == 'no_due_date')
			$invoice->due_date_detail = null;
		elseif($request->input('due_date') == 'due_on_date')
			$invoice->due_date_detail = $request->input('due_date_detail');
		else
			$invoice->due_date_detail = date('Y-m-d', strtotime($request->input('date') . ' +'.config('lists.invoice_due_date_day.'.$request->input('due_date')).' day'));

		if($action == 'store'){
			$invoice->enable_partial_payment = config('config.default_invoice_partial_payment');
			$invoice->invoice_prefix = $request->input('invoice_prefix');
			$invoice->invoice_number = getInvoiceNumber();
			$invoice->user_id = \Auth::user()->id;
		}

		$subtotal_discount_amount = ($request->has('subtotal_discount')) ? ($request->input('subtotal_discount_amount') ? : 0) : 0;
		$subtotal_discount_type = ($request->has('subtotal_discount') && $request->has('subtotal_discount_type')) ? 1 : 0; 
		$subtotal_tax_amount = ($request->has('subtotal_tax')) ? ($request->input('subtotal_tax_amount') ? : 0) : 0;
		$subtotal_shipping_and_handling_amount = ($request->has('subtotal_shipping_and_handling')) ? ($request->input('subtotal_shipping_and_handling_amount') ? : 0) : 0;

		$data['subtotal_discount_amount'] = $subtotal_discount_amount;
		$data['subtotal_tax_amount'] = $subtotal_tax_amount;
		$data['subtotal_shipping_and_handling_amount'] = $subtotal_shipping_and_handling_amount;
		$invoice->fill($data);
		$invoice->save();

		$data = $request->all();

		if($action == 'store')
			storeCustomField($this->form,$invoice->id, $data);
		else
			updateCustomField($this->form,$invoice->id, $data);

		$currency = $invoice->Currency;

		$subtotal = 0;
		foreach($items as $key => $item){
			$item_amount = 0;
			$invoice_item = \App\InvoiceItem::firstOrNew(['item_key' => $key]);
			$invoice_item->invoice_id = $invoice->id;
			$invoice_item->item_key = $key;
			if(!array_key_exists($key, $item_name_details)){
				$item_detail = \App\Item::find($item);
				$invoice_item->item_id = $item;
				$invoice_item->item_name = $item_detail->name;
			} else 
                        $invoice_item->unit= $item_detail->unit;
			$invoice_item->item_name = $item;
			$invoice_item->item_quantity = ($request->input('item_type') != 'amount_only') ? $quantities[$key] : 1;
			$invoice_item->unit_price = $prices[$key];
			$invoice_item->item_discount = ($request->has('line_item_discount')) ? $discounts[$key] : 0;
			$invoice_item->subtotal1 = $invoice_item->item_quantity * $invoice_item->unit_price;
                        $invoice->subtotal1=$invoice_item->item_quantity * $invoice_item->unit_price;

			$invoice_item->item_discount_type = ($request->has('line_item_discount') && array_key_exists($key, $discount_types)) ? 1 : 0;
			$invoice_item->item_tax = ($request->has('line_item_tax')) ? $taxations[$key] : 0;
			$invoice_item->item_description = (array_key_exists($key, $descriptions)) ? $descriptions[$key] : null;
			


			$item_amount = $invoice_item->item_quantity * $invoice_item->unit_price;
			if($invoice_item->item_discount_type)
				$item_amount -= $invoice_item->item_discount;

			else
				$item_amount -= $item_amount*($invoice_item->item_discount/100);

                        $invoice_item->subtotal2 = $item_amount;
                        $invoice->subtotal2 = $item_amount;


			$item_amount += $item_amount*($invoice_item->item_tax/100);
                        $invoice_item->subtotal3 = $item_amount;
                        $invoice->subtotal3 = $item_amount;
			$invoice_item->item_amount = round($item_amount,$currency->decimal_place);
			$invoice_item->save();

			$subtotal += $item_amount;
		}

		if($subtotal_discount_type)
			$subtotal -= $subtotal_discount_amount;
		else
			$subtotal -= $subtotal*($subtotal_discount_amount/100);

		$subtotal += $subtotal*($subtotal_tax_amount/100);
		$subtotal += $subtotal_shipping_and_handling_amount;

		$invoice->total = round($subtotal,$currency->decimal_place);
		if($action == 'store')
			$invoice->uuid = Uuid::generate();
                        
		$invoice->save();

		if($action == 'store'){
		    foreach($request->input('upload_key') as $upload_key){
		    	$uploads = \App\Upload::whereModule('invoice')->whereUploadKey($upload_key)->get();
		    	foreach($uploads as $upload){
	                $upload->module_id = $invoice->id;
	                $upload->status = 1;
	                $upload->save();
	                \Storage::move('temp_attachments/'.$upload->attachments, 'attachments/'.$upload->attachments);
		    	}
		    }
		}



		if($request->input('form_action') == 'send'){
			$invoice->status = 'sent';
			$invoice->save();
			$invoice_color = $this->getInvoiceColor($invoice);
			$action_type = 'pdf';
			$pdf = PDF::loadView('invoice.print', compact('invoice','invoice_color','action_type'));
			
			$mail = array();
			$mail_data = $this->templateContent(['slug' => 'send-invoice','invoice' => $invoice]);
			
			if(count($mail_data)){
		   	 	$mail['email'] = $invoice->Customer->email;
		   	 	$mail['filename'] = 'Invoice_'.$invoice->invoice_prefix.getInvoiceNumber($invoice).'.pdf';
		   	 	$mail['subject'] = $mail_data['subject'];
		   	 	$body = $mail_data['body'];

		   	 	\Mail::send('emails.email', compact('body'), function ($message) use($pdf,$mail) {
		   	 		$message->attachData($pdf->output(), $mail['filename']);
		   	 		$message->to($mail['email'])->subject($mail['subject']);
		   	 	});
		   	 	$this->logEmail(array('to' => $mail['email'],'subject' => $mail['subject'],'body' => $body,'module' => 'invoice','module_id' =>$invoice->id));
			}
		}






		if($action == "update"){
			$this->logActivity(['module' => 'invoice','module_id' => $invoice->id,'activity' => 'updated']);
			$message = trans('invoice').' '.trans('messages.updated');
		}
		else{
			$this->logActivity(['module' => 'invoice','module_id' => $invoice->id,'activity' => 'added']);
			$message = trans('invoice').' '.trans('messages.generated');
		}

        return response()->json(['message' => $message, 'status' => 'success','redirect' => '/invoice/'.$invoice->uuid]);
	}

	public function payment(Request $request, $invoice_id){
		$invoice = Invoice::find($invoice_id);

		if(!$invoice || !$this->invoiceAccessible($invoice))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		if($invoice->status == 'draft')
	    	return response()->json(['status' => 'error','message' => trans('messages.no_payment_on_draft_invoice')]);

		if($invoice->is_cancelled)
	    	return response()->json(['status' => 'error','message' => trans('messages.no_payment_on_cancelled_invoice')]);

		if(!$invoice->enable_partial_payment && $invoice->total != $request->input('amount'))
	    	return response()->json(['status' => 'error','message' => trans('messages.partial').' '.trans('messages.payment').' '.trans('messages.disabled')]);

		$validation_rules = [
            'account_id' => 'required',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'payment_method_id' => 'required',
            'income_category_id' => 'required'
        ];

        $friendly_names = [
        	'account_id' => 'account',
        	'payment_method_id' => 'payment method',
        	'income_category_id' => 'income category',
        ];

        $validation = Validator::make($request->all(),$validation_rules);
        $validation->setAttributeNames($friendly_names);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        $validation = validateCustomField('income-form',$request);
        
        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        if($request->input('date') < $invoice->date)
            return response()->json(['message' => trans('messages.payment_date_less_than_invoice_date'), 'status' => 'error']);

        $total_paid = $this->getInvoiceTransaction($invoice,'sum');

        if($request->input('amount') > ($invoice->total - $total_paid))
            return response()->json(['message' => trans('messages.payment_amount_greater_than_balance'), 'status' => 'error']);

        $file_uploaded_count = \App\Upload::whereIn('upload_key',$request->input('upload_key'))->count();

        if($file_uploaded_count > config('constant.max_file_allowed.invoice-payment'))
        	return response()->json(['message' => trans('messages.max_file_allowed',['attribute' => config('constant.max_file_allowed.invoice-payment')]),'status' => 'error']);

		$transaction = new \App\Transaction;
		$transaction->amount = $request->input('amount');
		$transaction->currency_id = $invoice->currency_id;
		$transaction->account_id = $request->input('account_id');
		$transaction->date = $request->input('date');
		$transaction->description = $request->input('description');
		$transaction->payment_method_id = $request->input('payment_method_id');
		$transaction->tags = $request->input('tags');
		$transaction->income_category_id = $request->input('income_category_id');
		$transaction->invoice_id = $invoice->id;
		$transaction->user_id = \Auth::user()->id;
		$transaction->customer_id = $invoice->customer_id;
		$transaction->head = 'income';
		$transaction->token = strtoupper(randomString(25));

		$transaction->save();

	    foreach($request->input('upload_key') as $upload_key){
	    	$uploads = \App\Upload::whereModule('invoice-payment')->whereUploadKey($upload_key)->get();
	    	foreach($uploads as $upload){
                $upload->module_id = $transaction->id;
                $upload->status = 1;
                $upload->save();
                \Storage::move('temp_attachments/'.$upload->attachments, 'attachments/'.$upload->attachments);
	    	}
	    }

		$this->updateInvoicePaymentStatus($invoice);
		$this->logActivity(['module' => 'invoice','module_id' => $invoice->id,'sub_module' => 'payment', 'sub_module_id' => $transaction->id, 'activity' => 'added']);

		if($request->input('send_invoice_payment_confirmation_email')){
			$mail = array();
			$mail_data = $this->templateContent(['slug' => 'invoice-payment-confirmation','transaction' => $transaction]);
			
			if(count($mail_data)){
		   	 	$mail['email'] = $invoice->Customer->email;
		   	 	$mail['subject'] = $mail_data['subject'];
		   	 	$body = $mail_data['body'];
		   	 	\Mail::send('emails.email', compact('body'), function ($message) use($mail) {
		   	 		$message->to($mail['email'])->subject($mail['subject']);
		   	 	});
		   	 	$this->logEmail(array('to' => $mail['email'],'subject' => $mail['subject'],'body' => $body,'module' => 'invoice','module_id' =>$invoice->id));
			}
		}

	    return response()->json(['status' => 'success','message' => trans('messages.payment').' '.trans('messages.added')]);
	}

	public function listPayment(Request $request){
		$invoice = Invoice::find($request->input('invoice_id'));

		if(!$invoice || !$this->isAccessible($invoice))
			return;

		$total_paid = $this->getInvoiceTransaction($invoice,'sum');
		$invoice_transactions = $this->getInvoiceTransaction($invoice);

		return view('invoice.payment_list',compact('invoice','total_paid','invoice_transactions'));
	}

	public function showPayment($transaction_id){
		$transaction = \App\Transaction::find($transaction_id);

		if(!$transaction || !$transaction->Invoice)
            return view('global.error',['message' => trans('messages.invalid_link')]);

        $invoice = $transaction->Invoice;

        if(!$this->isAccessible($invoice))
            return view('global.error',['message' => trans('messages.permission_denied')]);

        $uploads = \App\Upload::whereModule('invoice-payment')->whereModuleId($transaction->id)->whereStatus(1)->get();
        return view('invoice.payment_show',compact('invoice','transaction','uploads'));
	}

	public function editPayment($transaction_id){
		$transaction = \App\Transaction::find($transaction_id);

		if(!$transaction || !$transaction->Invoice || $transaction->source != null)
            return view('global.error',['message' => trans('messages.invalid_link')]);

        $invoice = $transaction->Invoice;

        if(!$this->invoiceAccessible($invoice))
            return view('global.error',['message' => trans('messages.permission_denied')]);

		$income_categories = \App\IncomeCategory::all()->pluck('name','id')->all();
		$payment_methods = \App\PaymentMethod::whereType('income')->get()->pluck('name','id')->all();
		$accounts = \App\Account::all()->pluck('name','id')->all();
		$custom_field_values = getCustomFieldValues('income-form',$transaction->id);

        \App\Upload::whereModule('invoice-payment')->whereModuleId($transaction->id)->whereStatus(1)->update(['is_temp_delete' => 0]);
        $uploads = \App\Upload::whereModule('invoice-payment')->whereModuleId($transaction->id)->whereStatus(1)->get();

        return view('invoice.payment_edit',compact('invoice','transaction','income_categories','payment_methods','accounts','custom_field_values','uploads'));
	}

	public function updatePayment(Request $request, $transaction_id){
		$transaction = \App\Transaction::find($transaction_id);

		if(!$transaction || !$transaction->Invoice || $transaction->source != null)
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

        $invoice = $transaction->Invoice;

        if(!$this->invoiceAccessible($invoice))
	    	return response()->json(['status' => 'error','message' => trans('messages.permission_denied')]);

		if(!$invoice->enable_partial_payment && $invoice->total != $request->input('amount'))
	    	return response()->json(['status' => 'error','message' => trans('messages.partial').' '.trans('messages.payment').' '.trans('messages.disabled')]);

		if($invoice->status == 'draft')
	    	return response()->json(['status' => 'error','message' => trans('messages.no_payment_on_draft_invoice')]);

		if($invoice->is_cancelled)
	    	return response()->json(['status' => 'error','message' => trans('messages.no_payment_on_cancelled_invoice')]);

		$validation_rules = [
            'account_id' => 'required',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'payment_method_id' => 'required',
            'income_category_id' => 'required'
        ];

        $friendly_names = [
        	'account_id' => 'account',
        	'payment_method_id' => 'payment method',
        	'income_category_id' => 'income category',
        ];

        $validation = Validator::make($request->all(),$validation_rules);
        $validation->setAttributeNames($friendly_names);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        $validation = validateCustomField('income-form',$request);
        
        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        if($request->input('date') < $invoice->date)
            return response()->json(['message' => trans('messages.payment_date_less_than_invoice_date'), 'status' => 'error']);

        $total_paid = 0;
        $invoice_transactions = $this->getInvoiceTransaction($invoice);
        foreach($invoice_transactions as $transaction)
        	if($transaction->id != $transaction_id)
        	$total_paid += $transaction->amount;

        if($request->input('amount') > ($invoice->total - $total_paid))
            return response()->json(['message' => trans('messages.payment_amount_greater_than_balance'), 'status' => 'error']);

        $existing_upload = \App\Upload::whereModule('invoice-payment')->whereModuleId($transaction->id)->whereIsTempDelete(0)->count();

        $new_upload_count = 0;
        foreach($request->input('upload_key') as $upload_key)
            $new_upload_count += \App\Upload::whereModule('invoice-payment')->whereUploadKey($upload_key)->count();

        if($existing_upload + $new_upload_count > config('constant.max_file_allowed.invoice-payment'))
            return response()->json(['message' => trans('messages.max_file_allowed',['attribute' => config('constant.max_file_allowed.invoice-payment')]),'status' => 'error']);

        foreach($request->input('upload_key') as $upload_key){
            $uploads = \App\Upload::whereModule('invoice-payment')->whereUploadKey($upload_key)->get();
            foreach($uploads as $upload){
                $upload->module_id = $transaction->id;
                $upload->status = 1;
                $upload->save();
                \Storage::move('temp_attachments/'.$upload->attachments, 'attachments/'.$upload->attachments);
            }
        }

        $temp_delete_uploads = \App\Upload::whereModule('invoice-payment')->whereModuleId($transaction->id)->whereIsTempDelete(1)->get();
        foreach($temp_delete_uploads as $temp_delete_upload)
            \Storage::delete('attachments/'.$temp_delete_upload->attachments);

        \App\Upload::whereModule('invoice-payment')->whereModuleId($transaction->id)->whereIsTempDelete(1)->delete();

		$transaction->amount = $request->input('amount');
		$transaction->account_id = $request->input('account_id');
		$transaction->date = $request->input('date');
		$transaction->description = $request->input('description');
		$transaction->payment_method_id = $request->input('payment_method_id');
		$transaction->tags = $request->input('tags');
		$transaction->income_category_id = $request->input('income_category_id');

		$transaction->save();
		$this->logActivity(['module' => 'invoice','module_id' => $invoice->id,'sub_module' => 'payment', 'sub_module_id' => $transaction->id, 'activity' => 'updated']);
		$this->updateInvoicePaymentStatus($invoice);

	    return response()->json(['status' => 'success','message' => trans('messages.payment').' '.trans('messages.updated')]);
	}

	public function listEmail(Request $request){

		$invoice = Invoice::find($request->input('invoice_id'));

		if(!$invoice || !$this->invoiceAccessible($invoice))
			return;

		$emails = \App\Email::whereModule('invoice')->whereModuleId($request->input('invoice_id'))->orderBy('created_at','desc')->get();

		return view('invoice.email_list',compact('emails'));
	}

	public function withdraw($transaction_id){
		$transaction = \App\Transaction::find($transaction_id);

		if(!$transaction || !$transaction->Invoice || $transaction->source != null)
            return view('global.error',['message' => trans('messages.invalid_link')]);

        $invoice = $transaction->Invoice;

        if(!$this->invoiceAccessible($invoice))
            return view('global.error',['message' => trans('messages.permission_denied')]);

        $default_currency = \App\Currency::whereIsDefault(1)->first();
		$accounts = \App\Account::all()->pluck('name','id')->all();
		$income_categories = \App\IncomeCategory::all()->pluck('name','id')->all();
		$payment_methods = \App\PaymentMethod::whereType('income')->get()->pluck('name','id')->all();
		$conversion_rate = $this->getCurrencyValue($transaction->currency_id);
        return view('invoice.payment_withdraw',compact('invoice','transaction','accounts','default_currency','conversion_rate','income_categories','payment_methods'));
	}

	public function postWithdraw(Request $request, $transaction_id){
		$transaction = \App\Transaction::find($transaction_id);

		if(!$transaction || !$transaction->Invoice || $transaction->source == null)
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

        $invoice = $transaction->Invoice;

        if(!$this->invoiceAccessible($invoice))
	    	return response()->json(['status' => 'error','message' => trans('messages.permission_denied')]);

		$validation_rules = [
            'processing_fee' => 'required|numeric|min:0',
            'conversion_rate' => 'sometimes|required',
            'date' => 'required|date',
            'account_id' => 'required'
        ];

        $validation = Validator::make($request->all(),$validation_rules);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        if($request->input('processing_fee') > $transaction->amount)
            return response()->json(['message' => trans('messages.processing_fee_cannot_greater_than_amount'), 'status' => 'error']);

        if($request->input('date') < date('Y-m-d',strtotime($transaction->created_at)))
            return response()->json(['message' => trans('messages.withdraw_date_cannot_less_than_transaction_date'), 'status' => 'error']);

		$transaction->processing_fee = $request->input('processing_fee');
		$transaction->withdraw_remarks = $request->input('withdraw_remarks');
		$transaction->account_id = $request->input('account_id');
		$transaction->payment_method_id = $request->input('payment_method_id');
		$transaction->income_category_id = $request->input('income_category_id');
		$transaction->date = $request->input('date');
		$transaction->is_withdrawn = 1;
		$transaction->conversion_rate = $request->has('conversion_rate') ? $request->input('conversion_rate') : 1;
		$transaction->save();
		$this->logActivity(['module' => 'invoice','module_id' => $invoice->id,'sub_module' => 'payment', 'sub_module_id' => $transaction->id, 'activity' => 'withdrawn']);
	    return response()->json(['status' => 'success','message' => trans('messages.payment').' '.trans('messages.updated')]);
	}

	public function partialPayment(Request $request){
		$invoice = Invoice::find($request->input('invoice_id'));

		if(!$invoice || !$this->invoiceAccessible($invoice))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		if($request->input('action') == 'enable'){
			if($invoice->enable_partial_payment == 1)
	    		return response()->json(['status' => 'error','message' => trans('messages.partial_payment_already_enabled')]);

			$invoice->enable_partial_payment = 1;
			$invoice->save();
			$this->logActivity(['module' => 'invoice','module_id' => $invoice->id,'sub_module' => 'partial_payment', 'sub_module_id' => $invoice->id, 'activity' => 'enabled']);

		} elseif ($request->input('action') == 'disable') {
			if($invoice->enable_partial_payment == 0)
	    		return response()->json(['status' => 'error','message' => trans('messages.partial_payment_already_disabled')]);

			if($this->getInvoiceTransaction($invoice,'sum'))
	    		return response()->json(['status' => 'error','message' => trans('messages.cannot_disable_partial_payment')]);

			$invoice->enable_partial_payment = 0;
			$invoice->save();
			$this->logActivity(['module' => 'invoice','module_id' => $invoice->id,'sub_module' => 'partial_payment', 'sub_module_id' => $invoice->id, 'activity' => 'disabled']);
		}

	    return response()->json(['status' => 'success','message' => trans('messages.partial').' '.trans('messages.payment').' '.trans('messages.updated')]);
	}

	public function recurring(Request $request, $invoice_id){
		$invoice = Invoice::find($invoice_id);

		if(!$invoice || !$this->invoiceAccessible($invoice))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		if($invoice->is_cancelled)
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

        $validation = Validator::make($request->all(),[
        		'recurring_frequency' => 'required_if:is_recurring,1',
        		'recurrence_from_date' => 'required_if:is_recurring,1|date',
        		'recurrence_upto' => 'required_if:is_recurring,1|date'
        	]);
        $validation->setAttributeNames(['is_recurring' => 'recurring']);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        if($request->input('recurrence_from_date') < $invoice->date || $request->input('recurrence_upto') < $invoice->date)
            return response()->json(['message' => trans('messages.recurring_date_cannot_less_than_invoice_date'), 'status' => 'error']);

        $invoice->is_recurring = $request->input('is_recurring');
        $invoice->recurrence_from_date = ($request->input('is_recurring')) ? $request->input('recurrence_from_date') : null;
        $invoice->recurrence_upto = ($request->input('is_recurring')) ? $request->input('recurrence_upto') : null;
        $invoice->recurring_frequency = ($request->input('is_recurring')) ? $request->input('recurring_frequency') : 0;
        $recurring_days = $request->input('recurring_frequency');
        $invoice->next_recurring_date = ($request->input('is_recurring')) ? date('Y-m-d', strtotime($request->input('recurrence_from_date'). ' + '.$recurring_days.' days')) : null;
        $invoice->save();
        $this->logActivity(['module' => 'invoice','module_id' => $invoice->id,'sub_module' => 'recurrence', 'sub_module_id' => $invoice->id, 'activity' => 'updated']);

	    return response()->json(['status' => 'success','message' => trans('messages.invoice').' '.trans('messages.updated')]);
	}

	public function listRecurring(Request $request){
		$invoice = Invoice::find($request->input('invoice_id'));

		if(!$invoice || !$this->invoiceAccessible($invoice))
			return;

		return view('invoice.recurring_list',compact('invoice'));
	}

	public function cancel(Request $request){
		$invoice = Invoice::find($request->input('invoice_id'));

		if(!$invoice || !$this->invoiceAccessible($invoice))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		if($this->getInvoiceTransaction($invoice,'sum'))
	    	return response()->json(['status' => 'error','message' => trans('messages.cannot_cancel_payment_already_made')]);

		$invoice->is_cancelled = 1;
		$invoice->save();
		$this->logActivity(['module' => 'invoice','module_id' => $invoice->id, 'activity' => 'cancelled']);

    	return response()->json(['status' => 'success','message' => trans('messages.invoice').' '.trans('messages.cancelled')]);
	}

	public function undoCancel(Request $request){
		$invoice = Invoice::find($request->input('invoice_id'));

		if(!$invoice || !$this->invoiceAccessible($invoice) || !$invoice->is_cancelled)
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		$invoice->is_cancelled = 0;
		$invoice->save();
		$this->logActivity(['module' => 'invoice','module_id' => $invoice->id, 'activity' => 'undo_cancelled']);

    	return response()->json(['status' => 'success','message' => trans('messages.invoice').' '.trans('messages.updated')]);
	}

	public function copy(Request $request){
		$invoice = Invoice::find($request->input('invoice_id'));

		if(!$invoice || !$this->invoiceAccessible($invoice))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		$new_invoice = $invoice->replicate();
		$new_invoice->uuid = Uuid::generate();
		$new_invoice->invoice_number = getInvoiceNumber();
		$new_invoice->status = 'draft';
		$new_invoice->payment_status = 'unpaid';
		$new_invoice->save();

		foreach($invoice->InvoiceItem as $invoice_item){
			$new_invoice_item = $invoice_item->replicate();
			$new_invoice_item->invoice_id = $new_invoice->id;
			$new_invoice_item->item_key = randomString(40);
			$new_invoice_item->save();
		}
		$this->logActivity(['module' => 'invoice','module_id' => $invoice->id, 'activity' => 'copied']);

    	return response()->json(['status' => 'success','message' => trans('messages.invoice').' '.trans('messages.copied'),'redirect' => '/invoice/'.$new_invoice->uuid]);
	}

	public function markAsSent(Request $request){
		$invoice = Invoice::find($request->input('invoice_id'));

		if(!$invoice || !$this->invoiceAccessible($invoice))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		if($invoice->status == 'sent')
	    	return response()->json(['status' => 'error','message' => trans('messages.invoice_already_marked_as_sent')]);

		$invoice->status = 'sent';
		$invoice->save();
		$this->logActivity(['module' => 'invoice','module_id' => $invoice->id, 'activity' => 'marked_as_sent']);

    	return response()->json(['status' => 'success','message' => trans('messages.invoice').' '.trans('messages.marked').' '.trans('messages.as').' '.trans('messages.sent')]);
	}

	public function email(Request $request){
		$invoice = Invoice::find($request->input('invoice_id'));

		if(!$invoice || !$this->invoiceAccessible($invoice))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		$slug = $request->input('email');

		if($invoice->payment_status == 'paid' && ($slug == 'invoice-payment-reminder' || $slug == 'invoice-overdue' ))
	    	return response()->json(['status' => 'error','message' => trans('messages.invoice_already_paid')]);

		if($slug == 'send-invoice'){
			$invoice->status = 'sent';
			$invoice->save();
		}

		$action_type = 'pdf';
		$invoice_color = $this->getInvoiceColor($invoice);
		$pdf = PDF::loadView('invoice.print', compact('invoice','invoice_color','action_type'));
		$mail = array();
		$mail_data = $this->templateContent(['slug' => $slug,'invoice' => $invoice]);
		if(count($mail_data)){
	   	 	$mail['email'] = $invoice->Customer->email;
	   	 	$mail['filename'] = 'Invoice_'.$invoice->invoice_prefix.getInvoiceNumber($invoice).'.pdf';
	   	 	$mail['subject'] = $mail_data['subject'];
	   	 	$body = $mail_data['body'];

	   	 	\Mail::send('emails.email', compact('body'), function ($message) use($pdf,$mail) {
	   	 		$message->attachData($pdf->output(), $mail['filename']);
	   	 		$message->to($mail['email'])->subject($mail['subject']);
	   	 	});
	   	 	$this->logEmail(array('to' => $mail['email'],'subject' => $mail['subject'],'body' => $body,'module' => 'invoice','module_id' =>$invoice->id));
			$this->logActivity(['module' => 'invoice','module_id' => $invoice->id, 'activity' => 'mail_sent']);
		}

    	return response()->json(['status' => 'success','message' => trans('messages.email').' '.trans('messages.sent')]);
	}

	public function customEmail($uuid){
		$invoice = Invoice::whereUuid($uuid)->first();

		if(!$invoice || !$this->invoiceAccessible($invoice))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

        $templates = \App\Template::whereCategory('invoice')->get()->pluck('name','id')->all();
        return view('invoice.custom_email',compact('invoice','templates'));
	}

	public function postCustomEmail(Request $request, $uuid){

		$invoice = Invoice::whereUuid($uuid)->first();

		if(!$invoice || !$this->invoiceAccessible($invoice))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

        $validation = Validator::make($request->all(),[
            'subject' => 'required',
            'body' => 'required'
        ]);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        $mail['email'] = $invoice->Customer->email;
        $mail['subject'] = $request->input('subject');
        $body = clean($request->input('body'),'custom');

        \Mail::send('emails.email', compact('body'), function($message) use ($mail){
            $message->to($mail['email'])->subject($mail['subject']);
        });
        $this->logEmail(array('to' => $mail['email'],'subject' => $mail['subject'],'body' => $body,'module' => 'invoice','module_id' =>$invoice->id));
		$this->logActivity(['module' => 'invoice','module_id' => $invoice->id, 'activity' => 'mail_sent']);

        $this->logActivity(['module' => 'invoice','module_id' => $invoice->id,'activity' => 'mail_sent']);
        return response()->json(['message' => trans('messages.mail').' '.trans('messages.sent'), 'status' => 'success']);
	}

	public function validateCoupon(Request $request){
    	$amount = ($request->input('amount')) ? : '';
    	$coupon = ($request->input('coupon')) ? : '';
    	$invoice_id = ($request->input('invoice_id')) ? : '';
    	$invoice = Invoice::find($invoice_id);

    	if(!$invoice)
    		return;

    	$data = validateCoupon($amount,$invoice->Currency,$coupon);

	    return response()->json(['message' => $data['coupon_response']]);
	}

	public function destroy(Request $request,Invoice $invoice){

		if(!Entrust::can('delete-invoice') || !$this->invoiceAccessible($invoice))
	    	return response()->json(['status' => 'error','message' => trans('messages.invalid_link')]);

		if($invoice->Transaction->where('source','!=',null)->count())
	    	return response()->json(['status' => 'error','message' => trans('messages.customer_paid_invoice_cannot_deleted')]);
		
        if(getMode()){
            $uploads = \App\Upload::whereModule('invoice')->whereModuleId($invoice->id)->get();
            foreach($uploads as $upload)
                \Storage::delete('invoice/'.$upload->attachments);
            \App\Upload::whereModule('invoice')->whereModuleId($invoice->id)->delete();
        }

		$this->logActivity(['module' => 'invoice','module_id' => $invoice->id,'activity' => 'deleted']);
		deleteCustomField($this->form, $invoice->id);
		$invoice->delete();

	    return response()->json(['status' => 'success','message' => trans('messages.invoice').' '.trans('messages.deleted'),'redirect' => '/invoice']);
	}

	public function graphData(Request $request){

		$draft_invoices = \App\Invoice::whereStatus('draft')->count();
		$paid_invoices = \App\Invoice::whereStatus('sent')->wherePaymentStatus('paid')->count();
		$unpaid_invoices = \App\Invoice::whereStatus('sent')->wherePaymentStatus('unpaid')->where(function($query){
			$query->whereNull('due_date_detail')->orWhere(function($query1){
				$query1->whereNotNull('due_date_detail')->where('due_date_detail','>=',date('Y-m-d'));
			});
		})->count();
		$partially_paid_invoices = \App\Invoice::whereStatus('sent')->wherePaymentStatus('partially_paid')->where(function($query){
			$query->whereNull('due_date_detail')->orWhere(function($query1){
				$query1->whereNotNull('due_date_detail')->where('due_date_detail','>=',date('Y-m-d'));
			});
		})->count();
		$overdue_invoices = \App\Invoice::whereStatus('sent')->where('payment_status','!=','paid')->whereNotNull('due_date_detail')->where('due_date_detail','<=',date('Y-m-d'))->count();

		$invoice_payment_status_values = array(
				['value' => $draft_invoices,'name' => trans('messages.invoice_draft')],
				['value' => $paid_invoices,'name' => trans('messages.paid')],
				['value' => $unpaid_invoices,'name' => trans('messages.unpaid')],
				['value' => $partially_paid_invoices,'name' => trans('messages.partially_paid')],
				['value' => $overdue_invoices,'name' => trans('messages.overdue')],
			);
		$invoice_payment_status_data = array(
			trans('messages.invoice_draft'),
			trans('messages.paid'),
			trans('messages.unpaid'),
			trans('messages.partially_paid'),
			trans('messages.overdue')
			);
		$invoice_payment_status_graph_title = trans('messages.invoice');

		$draft_quotations = \App\Quotation::whereStatus('draft')->count();
		$dead_quotations = \App\Quotation::whereStatus('dead')->count();
		$invoice_quotations = \App\Quotation::whereStatus('invoice')->count();
		$accpted_quotations = \App\Quotation::whereStatus('accepted')->count();
		$rejected_quotations = \App\Quotation::whereStatus('rejected')->count();
		$sent_quotations = \App\Quotation::whereStatus('sent')->where('expiry_date','>=',date('Y-m-d'))->count();
		$expired_quotations = \App\Quotation::whereStatus('sent')->where('expiry_date','<',date('Y-m-d'))->count();

		$quotation_status_values = array(
				['value' => $draft_quotations,'name' => trans('messages.invoice_draft')],
				['value' => $dead_quotations,'name' => trans('messages.quotation_dead')],
				['value' => $accpted_quotations,'name' => trans('messages.accepted')],
				['value' => $rejected_quotations,'name' => trans('messages.quotation_rejected')],
				['value' => $invoice_quotations,'name' => trans('messages.quotation_converted')],
				['value' => $sent_quotations,'name' => trans('messages.invoice_sent')],
				['value' => $expired_quotations,'name' => trans('messages.expired')],
			);

		$quotation_status_data = array(
					trans('messages.invoice_draft'),
					trans('messages.quotation_dead'),
					trans('messages.quotation_converted'),
					trans('messages.invoice_sent'),
					trans('messages.expired')
				);
		$quotation_status_graph_title = trans('messages.quotation');

        $monthly_income_expense_graph_title = trans('messages.income').' Vs '.trans('messages.expense');
        $monthly_income_expense_unit = (\App\Currency::whereIsDefault(1)->count()) ? \App\Currency::whereIsDefault(1)->first()->symbol : '';
        $monthly_income_expense_graph_data = array();
        $monthly_income_expense_graph_value = array();
        $income_value = array();
        $expense_value = array();
        for($i=0;$i<12;$i++){
            $month_year = date('Y-m', strtotime(date('Y-m-d').' - '.$i.' months'));
            $month_year_name = date('M-Y',strtotime($month_year.'-01'));
            $monthly_income_expense_graph_data[] = $month_year_name;
            $first_day = date($month_year.'-01');
            $last_day  = date($month_year.'-t',strtotime($month_year.'-01'));
            $transactions = \App\Transaction::where('date','>=',$first_day)->where('date','<=',$last_day)->get();
            $total_income = 0;
            $total_expense = 0;
            foreach($transactions as $transaction)
                if($transaction->head == 'income')
                    $total_income += $transaction->amount * $transaction->conversion_rate;
                elseif($transaction->head == 'expense')
                    $total_expense += $transaction->amount * $transaction->conversion_rate;


            if(!getMode()){
            	$income_value[] = rand(10000,20000);
            	$expense_value[] = rand(5000,15000);
            } else {
	            $income_value[] = round($total_income,2);
	            $expense_value[] = round($total_expense,2);
            }
        }
        $monthly_income_expense_lenged = [trans('messages.income'),trans('messages.expense')];
        $monthly_income_expense_graph_value = [
                array(
                    'name' => trans('messages.income'),
                    'type' => 'line',
                    'data' => $income_value
                    ),
                array(
                    'name' => trans('messages.expense'),
                    'type' => 'line',
                    'data' => $expense_value
                    ),
            ];

		$data = ['invoice_payment_status_values' => $invoice_payment_status_values, 
			'invoice_payment_status_data' => $invoice_payment_status_data,
			'invoice_payment_status_graph_title' => $invoice_payment_status_graph_title,
			'quotation_status_values' => $quotation_status_values, 
			'quotation_status_data' => $quotation_status_data,
			'quotation_status_graph_title' => $quotation_status_graph_title,
			'monthly_income_expense_graph_title' => $monthly_income_expense_graph_title,
			'monthly_income_expense_graph_data' => $monthly_income_expense_graph_data,
			'monthly_income_expense_graph_value' => $monthly_income_expense_graph_value,
			'monthly_income_expense_unit' => $monthly_income_expense_unit,
			'monthly_income_expense_lenged' => $monthly_income_expense_lenged
			];
		return response()->json($data);
	}
}