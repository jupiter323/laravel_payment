<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use Entrust;
use App\Transaction;
use Validator;

Class TransactionController extends Controller{
    use BasicController;

	protected $income_form = 'income-form';
	protected $expense_form = 'expense-form';
	protected $account_transfer_form = 'account-transfer-form';
	protected $types = ['income','expense','account-transfer'];

    public function __construct()
    {
        $this->middleware(['staff_accessible'])->except(['fetch','show']);
    }

	public function index(){
	}

	public function income(){

		if(!Entrust::can('list-income'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

		$accounts = \App\Account::all()->pluck('name','id')->all();
		$income_categories = \App\IncomeCategory::all()->pluck('name','id')->all();
		$payment_methods = \App\PaymentMethod::whereType('income')->get()->pluck('name','id')->all();
		$customers = \App\User::whereHas('roles',function($query){
			$query->where('name',config('constant.default_customer_role'));
		})->get()->pluck('full_name','id')->all();
		$currencies = \App\Currency::all()->pluck('detail','id')->all();
		$default_currency = \App\Currency::whereIsDefault(1)->first();

		$data = array(
	        		trans('messages.option'),
	        		trans('messages.staff'),
	        		trans('messages.reference').' '.trans('messages.number'),
	        		trans('messages.amount'),
	        		trans('messages.category'),
	        		trans('messages.payer'),
	        		trans('messages.account'),
	        		trans('messages.payment').' '.trans('messages.method'),
	        		trans('messages.date'),
	        		trans('messages.description')
        		);

		$data = putCustomHeads($this->income_form, $data);

		$table_data['income-table'] = array(
				'source' => 'transaction/income',
				'title' => 'Income List',
				'id' => 'income_table',
				'data' => $data,
				'form' => 'income-filter-form'
			);

		$assets = ['datatable','tags'];
		$menu = 'transaction,income';
		$type = 'income';

		return view('transaction.income',compact('accounts','income_categories','payment_methods','customers','table_data','assets','menu','type','currencies','default_currency'));
	}

	public function expense(){
		if(!Entrust::can('list-expense'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

		$accounts = \App\Account::all()->pluck('name','id')->all();
		$expense_categories = \App\ExpenseCategory::all()->pluck('name','id')->all();
		$payment_methods = \App\PaymentMethod::whereType('expense')->get()->pluck('name','id')->all();
		$customers = \App\User::whereHas('roles',function($query){
			$query->where('name',config('constant.default_customer_role'));
		})->get()->pluck('full_name','id')->all();
		$currencies = \App\Currency::all()->pluck('detail','id')->all();
		$default_currency = \App\Currency::whereIsDefault(1)->first();

		$data = array(
	        		trans('messages.option'),
	        		trans('messages.staff'),
	        		trans('messages.reference').' '.trans('messages.number'),
	        		trans('messages.amount'),
	        		trans('messages.category'),
	        		trans('messages.payee'),
	        		trans('messages.account'),
	        		trans('messages.payment').' '.trans('messages.method'),
	        		trans('messages.date'),
	        		trans('messages.description')
        		);

		$data = putCustomHeads($this->expense_form, $data);

		$table_data['expense-table'] = array(
				'source' => 'transaction/expense',
				'title' => 'Expense List',
				'id' => 'expense_table',
				'data' => $data,
				'form' => 'expense-filter-form'
			);

		$assets = ['datatable','tags'];
		$menu = 'transaction,expense';
		$type = 'expense';

		return view('transaction.expense',compact('accounts','expense_categories','payment_methods','customers','table_data','assets','menu','type','currencies','default_currency'));
	}

	public function accountTransfer(){

		if(!Entrust::can('list-account-transfer'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

		$accounts = \App\Account::all()->pluck('name','id')->all();
		$payment_methods = \App\PaymentMethod::whereType('account_transfer')->get()->pluck('name','id')->all();
		$currencies = \App\Currency::all()->pluck('detail','id')->all();
		$default_currency = \App\Currency::whereIsDefault(1)->first();

		$data = array(
	        		trans('messages.option'),
	        		trans('messages.staff'),
	        		trans('messages.reference').' '.trans('messages.number'),
	        		trans('messages.amount'),
	        		trans('messages.from').' '.trans('messages.account'),
	        		trans('messages.to').' '.trans('messages.account'),
	        		trans('messages.payment').' '.trans('messages.method'),
	        		trans('messages.date'),
	        		trans('messages.description')
        		);

		$data = putCustomHeads($this->expense_form, $data);

		$table_data['account-transfer-table'] = array(
				'source' => 'transaction/account-transfer',
				'title' => 'Account Transfer List',
				'id' => 'account_transfer_table',
				'data' => $data,
				'form' => 'account-transfer-filter-form'
			);

		$assets = ['datatable','tags'];
		$menu = 'transaction,account_transfer';
		$type = 'account-transfer';

		return view('transaction.account_transfer',compact('accounts','payment_methods','table_data','assets','menu','type','currencies','default_currency'));
	}

	public function lists(Request $request, $type){

		if(!in_array($type,$this->types) || !Entrust::can('list-'.$type))
			return;

		$form = $this->getCustomForm($type);

		$query = Transaction::whereHead($type);

		if(!Entrust::hasRole(config('constant.default_customer_role'))){
			if(Entrust::can('manage-all-designation')){}			
			elseif(Entrust::can('manage-subordinate-designation'))
				$query->whereIn('user_id',getAccessibleUserList(\Auth::user()->id,1));
			else
				$query->where('user_id',\Auth::user()->id);
		} else
			$query->where('customer_id',\Auth::user()->id);

		if($request->has('reference_number'))
			$query->whereReferenceNumber($request->input('reference_number'));

		if($request->has('token'))
			$query->whereToken($request->input('token'));

		if($request->has('currency_id'))
			$query->whereIn('currency_id',$request->input('currency_id'));

		if($request->has('account_id'))
			$query->whereIn('account_id',$request->input('account_id'));

		if($request->has('from_account_id'))
			$query->whereIn('from_account_id',$request->input('from_account_id'));

		if($request->has('payment_method_id'))
			$query->whereIn('payment_method_id',$request->input('payment_method_id'));

		if($request->has('source'))
			$query->whereNotNull('source')->whereIn('source',$request->input('source'));

		if($request->has('income_category_id'))
			$query->whereIn('income_category_id',$request->input('income_category_id'));

		if($request->has('expense_category_id'))
			$query->whereIn('expense_category_id',$request->input('expense_category_id'));

		if($request->has('customer_id'))
			$query->where('customer_id',$request->input('expense_category_id'));

		if($request->has('has_attachment'))
			$query->whereNotNull('attachments');

		if($request->has('paid_by_customer'))
			$query->whereNotNull('source');

		if($request->has('withdraw_pending'))
			$query->whereNotNull('source')->whereIsWithdrawn(0);

		if($request->has('tags'))
			$query->whereRaw("find_in_set(?,tags)",[$request->input('tags')]);

        if($request->has('start_date') && $request->has('end_date'))
            $query->whereBetween('date',[$request->input('start_date'),$request->input('end_date')]);

		$transactions = $query->get();
        $col_ids = getCustomColId($form);
        $values = fetchCustomValues($form);
        $rows = array();
        $row = array();

        foreach($transactions as $transaction){

			$row = array(
				'<div class="btn-group btn-group-xs">'.
				'<a href="#" data-href="/transaction/'.$transaction->token.'" data-toggle="modal" data-target="#myModal" class="btn btn-xs btn-default"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="'.trans('messages.view').'"></i></a>'.
				((Entrust::can('edit-'.$type) && $transaction->source == null) ? '<a href="#" data-href="/transaction/'.$transaction->id.'/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="'.trans('messages.edit').'"></i></a> ' : '').
				(($transaction->attachments) ? '<a href="/transaction/'.$transaction->token.'/download-attachment" class="btn btn-xs btn-default"> <i class="fa fa-paperclip" data-toggle="tooltip" title="'.trans('messages.download').'"></i></a> ' : '').
				((Entrust::can('delete-'.$type) && $transaction->source == null) ? delete_form(['transaction.destroy',$transaction->id]) : '').
				'</div>',
				$transaction->User->full_name.' '.(($transaction->source) ? ('<span class="label label-success">'.trans('messages.paid').' by '.trans('messages.customer').'</span>') : ''),
				$transaction->reference_number,
				currency($transaction->amount,1,$transaction->Currency->id)
				);

			if($type == 'income' || $type == 'expense') {
				if($type == 'income')
					$category = ($transaction->IncomeCategory) ? $transaction->IncomeCategory->name : '-';
				else
					$category = ($transaction->ExpenseCategory) ? $transaction->ExpenseCategory->name : '-';

				$customer = ($transaction->Customer) ? $transaction->Customer->full_name : '-';
				$account = ($transaction->Account) ? $transaction->Account->name : '-';

				array_push($row, $category);
				array_push($row, $customer);
				array_push($row, $account);

			} elseif($type == 'account-transfer') {
				$to_account = ($transaction->Account) ? $transaction->Account->name : '-';
				$from_account = ($transaction->FromAccount) ? $transaction->FromAccount->name : '-';
				array_push($row, $from_account);
				array_push($row, $to_account);
			}
			
			$payment_method = ($transaction->PaymentMethod) ? $transaction->PaymentMethod->name : '-';
			$attachment =  ($transaction->attachment) ? '<i class="fa fa-paperclip"></i>'  : '-';

			array_push($row, $payment_method);
			array_push($row, showDate($transaction->date));
			array_push($row, $transaction->description);

			$id = $transaction->id;

			foreach($col_ids as $col_id)
				array_push($row,isset($values[$id][$col_id]) ? $values[$id][$col_id] : '');
			$rows[] = $row;
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function show($token){
		$transaction = \App\Transaction::whereToken($token)->first();
		$type = $transaction->head;

		if(!in_array($type,$this->types) || (!$this->transactionAccessible($transaction) && $transaction->customer_id != \Auth::user()->id))
            return view('global.error',['message' => trans('messages.permission_denied')]);

        $uploads = \App\Upload::whereModule($type)->whereModuleId($transaction->id)->whereStatus(1)->get();
        $invoice = $transaction->Invoice;
        return view('transaction.show',compact('transaction','type','invoice','uploads'));
	}

	public function getCustomForm($type){

		if($type == 'income')
			$form = $this->income_form;
		elseif($type == 'expense')
			$form = $this->expense_form;
		elseif($type == 'account-transfer')
			$form = $this->account_transfer_form;

		return $form;
	}

	public function fetch(Request $request){

		$query = Transaction::whereNotNull('id');

		if(!Entrust::hasRole(config('constant.default_customer_role'))){
			if(Entrust::can('manage-all-designation')){}			
			elseif(Entrust::can('manage-subordinate-designation'))
				$query->whereIn('user_id',getAccessibleUserList(\Auth::user()->id,1));
			else
				$query->where('user_id',\Auth::user()->id);
		} else
			$query->where('customer_id',\Auth::user()->id);

		if($request->input('type') == 'income')
			$query->whereHead('income');
		if($request->input('type') == 'expense')
			$query->whereHead('expense');
		if($request->input('type') == 'account_transfer')
			$query->whereHead('account_transfer');

		$transactions = $query->orderBy('created_at','desc')->get()->take(5);

		return view('transaction.fetch',compact('transactions'))->render();
	}

	public function store(Request $request,$type){

		$data = $request->all();

		if(!in_array($type,$this->types) || !Entrust::can('create-'.$type))
            return response()->json(['message' => trans('messages.invalid_link'), 'status' => 'error']);

		$validation_rules = [
			'conversion_rate' => 'sometimes|required',
            'account_id' => 'required',
            'currency_id' => 'required',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'payment_method_id' => 'required',
            'attachments'=> 'mimes:'.config('config.allowed_upload_file')
        ];

        $friendly_names = [
        	'account_id' => 'account',
        	'currency_id' => 'currency',
        	'payment_method_id' => 'payment method'
        ];

        if($type == 'income'){
        	$validation_rules['income_category_id'] = 'required';
        	$friendly_names['income_category_id'] = 'income category';
        } elseif($type == 'expense'){
        	$validation_rules['expense_category_id'] = 'required';
        	$friendly_names['expense_category_id'] = 'expense category';
        } elseif($type == 'account-transfer'){
        	$validation_rules['from_account_id'] = 'required';
        	$friendly_names['from_account_id'] = 'from account';
        } 

        $validation = Validator::make($request->all(),$validation_rules);
        $validation->setAttributeNames($friendly_names);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        if($type == 'account-transfer' && $request->input('account_id') == $request->input('from_account_id'))
            return response()->json(['message' => trans('messages.different_accounts_for_account_transfer'), 'status' => 'error']);

        $form = $this->getCustomForm($type);
        $validation = validateCustomField($form,$request);
        
        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        $file_uploaded_count = \App\Upload::whereIn('upload_key',$request->input('upload_key'))->count();

        if($file_uploaded_count > config('constant.max_file_allowed.'.$type))
        	return response()->json(['message' => trans('messages.max_file_allowed',['attribute' => config('constant.max_file_allowed.'.$type)]),'status' => 'error']);

		$transaction = new Transaction;
		$transaction->user_id = \Auth::user()->id;
		$transaction->account_id = $request->input('account_id');
		$transaction->payment_method_id = $request->has('payment_method_id') ? $request->input('payment_method_id') : null;
		$transaction->amount = $request->input('amount');
		$transaction->currency_id = $request->input('currency_id');
		$transaction->date = $request->input('date');
		$transaction->conversion_rate = $request->has('conversion_rate') ? ($request->input('conversion_rate')) : 1;
		$transaction->description = $request->input('description');
		$transaction->tags = $request->has('tags') ? $request->input('tags') : null;
		$transaction->reference_number = $request->has('reference_number') ? $request->input('reference_number') : null;
		$transaction->head = $type;
		$transaction->token = strtoupper(randomString(25));

		if($type == 'income')
			$transaction->income_category_id = $request->input('income_category_id');
		elseif($type == 'expense')
			$transaction->expense_category_id = $request->input('expense_category_id');
		elseif($type == 'account-transfer')
			$transaction->from_account_id = $request->input('from_account_id');

		if($type == 'income' || $type == 'expense')
			$transaction->customer_id = $request->has('customer_id') ? $request->input('customer_id') : null;

		$transaction->save();

	    foreach($request->input('upload_key') as $upload_key){
	    	$uploads = \App\Upload::whereModule($type)->whereUploadKey($upload_key)->get();
	    	foreach($uploads as $upload){
                $upload->module_id = $transaction->id;
                $upload->status = 1;
                $upload->save();
                \Storage::move('temp_attachments/'.$upload->attachments, 'attachments/'.$upload->attachments);
	    	}
	    }

		storeCustomField($form,$transaction->id, $data);

		$this->logActivity(['module' => 'transaction','sub_module' => $type, 'module_id' => $transaction->id,'activity' => 'added']);

        return response()->json(['message' => trans('messages.transaction').' '.trans('messages.saved'), 'status' => 'success']);
	}

	public function edit($id){
		$transaction = Transaction::find($id);
		$type = $transaction->head;

		if(!in_array($type,$this->types) || !Entrust::can('edit-'.$type) || !$this->transactionAccessible($transaction) || $transaction->source != null)
            return view('global.error',['message' => trans('messages.permission_denied')]);

		$accounts = \App\Account::all()->pluck('name','id')->all();
		$income_categories = \App\IncomeCategory::all()->pluck('name','id')->all();
		$payment_methods = \App\PaymentMethod::whereType($type)->get()->pluck('name','id')->all();
		$customers = \App\User::whereHas('roles',function($query){
			$query->where('name',config('constant.default_customer_role'));
		})->get()->pluck('full_name','id')->all();
		$currencies = \App\Currency::all()->pluck('detail','id')->all();
		$default_currency = \App\Currency::whereIsDefault(1)->first();
		$expense_categories = \App\ExpenseCategory::all()->pluck('name','id')->all();
		$custom_field_values = getCustomFieldValues($this->getCustomForm($type),$transaction->id);

        \App\Upload::whereModule($type)->whereModuleId($transaction->id)->whereStatus(1)->update(['is_temp_delete' => 0]);
        $uploads = \App\Upload::whereModule($type)->whereModuleId($transaction->id)->whereStatus(1)->get();

		return view('transaction.edit',compact('accounts','income_categories','payment_methods','customers','currencies','default_currency','expense_categories','type','transaction','custom_field_values','uploads'));
	}

	public function update(Request $request,$id){

		$data = $request->all();
		$transaction = Transaction::find($id);
		$type = $transaction->head;

		if(!in_array($type,$this->types) || !Entrust::can('edit-'.$type) || !$this->transactionAccessible($transaction)  || $transaction->source != null)
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

		$validation_rules = [
			'conversion_rate' => 'sometimes|required',
            'account_id' => 'required',
            'currency_id' => 'required',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'payment_method_id' => 'required',
            'attachments'=> 'mimes:'.config('config.allowed_upload_file')
        ];

        $friendly_names = [
        	'account_id' => 'account',
        	'currency_id' => 'currency',
        	'payment_method_id' => 'payment method'
        ];

        if($type == 'income'){
        	$validation_rules['income_category_id'] = 'required';
        	$friendly_names['income_category_id'] = 'income category';
        } elseif($type == 'expense'){
        	$validation_rules['expense_category_id'] = 'required';
        	$friendly_names['expense_category_id'] = 'expense category';
        } elseif($type == 'account-transfer'){
        	$validation_rules['from_account_id'] = 'required';
        	$friendly_names['from_account_id'] = 'from account';
        } 

        $validation = Validator::make($request->all(),$validation_rules);
        $validation->setAttributeNames($friendly_names);

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

		$form = $this->getCustomForm($type);
        $validation = validateCustomField($form,$request);
        
        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        $existing_upload = \App\Upload::whereModule($type)->whereModuleId($transaction->id)->whereIsTempDelete(0)->count();

        $new_upload_count = 0;
        foreach($request->input('upload_key') as $upload_key)
            $new_upload_count += \App\Upload::whereModule($type)->whereUploadKey($upload_key)->count();

        if($existing_upload + $new_upload_count > config('constant.max_file_allowed.'.$type))
            return response()->json(['message' => trans('messages.max_file_allowed',['attribute' => config('constant.max_file_allowed.'.$type)]),'status' => 'error']);

        foreach($request->input('upload_key') as $upload_key){
            $uploads = \App\Upload::whereModule($type)->whereUploadKey($upload_key)->get();
            foreach($uploads as $upload){
                $upload->module_id = $transaction->id;
                $upload->status = 1;
                $upload->save();
                \Storage::move('temp_attachments/'.$upload->attachments, 'attachments/'.$upload->attachments);
            }
        }

        $temp_delete_uploads = \App\Upload::whereModule($type)->whereModuleId($transaction->id)->whereIsTempDelete(1)->get();
        foreach($temp_delete_uploads as $temp_delete_upload)
            \Storage::delete('attachments/'.$temp_delete_upload->attachments);

        \App\Upload::whereModule($type)->whereModuleId($transaction->id)->whereIsTempDelete(1)->delete();

		$transaction->account_id = $request->input('account_id');
		$transaction->payment_method_id = $request->has('payment_method_id') ? $request->input('payment_method_id') : null;
		$transaction->amount = $request->input('amount');
		$transaction->currency_id = $request->input('currency_id');
		$transaction->conversion_rate = $request->has('conversion_rate') ? ($request->input('conversion_rate')) : 1;
		$transaction->date = $request->input('date');
		$transaction->description = $request->input('description');
		$transaction->tags = $request->has('tags') ? $request->input('tags') : null;
		$transaction->reference_number = $request->has('reference_number') ? $request->input('reference_number') : null;

     	if ($request->hasFile('attachments') && getMode()) {
     		$existing_file = config('constant.upload_path.attachments').$transaction->attachments;
     		if(\File::exists($existing_file))
     			\File::delete($existing_file);

     		$filename = uniqid();
	 		$extension = $request->file('attachments')->getClientOriginalExtension();
	 		$file = $request->file('attachments')->move(config('constant.upload_path.attachments'), $filename.".".$extension);
	 		$transaction->attachments = $filename.".".$extension;
		}

		if($type == 'income')
			$transaction->income_category_id = $request->input('income_category_id');
		elseif($type == 'expense')
			$transaction->expense_category_id = $request->input('expense_category_id');
		elseif($type == 'account-transfer')
			$transaction->from_account_id = $request->input('from_account_id');

		if($type == 'income' || $type == 'expense')
			$transaction->customer_id = $request->has('customer_id') ? $request->input('customer_id') : null;

		$transaction->save();
		updateCustomField($form,$transaction->id, $data);

		$this->logActivity(['module' => 'transaction','sub_module' => $type, 'module_id' => $transaction->id,'activity' => 'updated']);

        return response()->json(['message' => trans('messages.transaction').' '.trans('messages.updated'), 'status' => 'success']);
	}

    public function download($file){
        $upload = \App\Upload::whereAttachments($file)->whereIn('module',['income','expense','account-transfer','invoice-payment'])->whereStatus(1)->first();

        if(!$upload)
            return redirect('/home')->withErrors(trans('messages.invalid_link'));

        $transaction = Transaction::find($upload->module_id);

        if(!$transaction)
            return redirect('/home')->withErrors(trans('messages.invalid_link'));

		$type = $transaction->head;

		if(!in_array($type,$this->types) || !Entrust::can('list-'.$type) || !$this->transactionAccessible($transaction))
			return redirect('/home')->withErrors(trans('messages.invalid_link'));
		
        if(!\Storage::exists('attachments/'.$upload->attachments))
            return redirect('/home')->withErrors(trans('messages.file_not_found'));

        $download_path = storage_path().config('constant.storage_root').'attachments/'.$upload->attachments;

        return response()->download($download_path, $upload->user_filename);
    }

	public function destroy(Request $request, $id){
		$transaction = Transaction::find($id);
		$type = $transaction->head;

		if(!in_array($type,$this->types) || !Entrust::can('delete-'.$type) || !$this->transactionAccessible($transaction) || $transaction->source != null)
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        if(getMode()){
            $uploads = \App\Upload::whereModule($type)->whereModuleId($transaction->id)->get();
            foreach($uploads as $upload)
                \Storage::delete('attachments/'.$upload->attachments);
            \App\Upload::whereModule($type)->whereModuleId($transaction->id)->delete();
        }

		$form = $this->getCustomForm($type);
		deleteCustomField($this->getCustomForm($type), $transaction->id);
		$invoice = ($transaction->invoice_id) ? $transaction->invoice : '';

		$this->logActivity(['module' => 'transaction','sub_module' => $type, 'module_id' => $transaction->id,'activity' => 'deleted']);

		$transaction->delete();

		if($invoice)
			$this->updateInvoicePaymentStatus($invoice);

        return response()->json(['message' => trans('messages.transaction').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}