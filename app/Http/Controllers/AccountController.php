<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\AccountRequest;
use Entrust;
use App\Account;

Class AccountController extends Controller{
    use BasicController;

	protected $form = 'account-form';

    public function __construct()
    {
        $this->middleware(['staff_accessible']);
    }

	public function index(Account $account){

		if(!Entrust::can('list-account'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

		$data = array(
	        		trans('messages.option'),
	        		trans('messages.name'),
	        		trans('messages.opening').' '.trans('messages.balance'),
	        		trans('messages.type'),
	        		trans('messages.bank').' '.trans('messages.name'),
	        		trans('messages.branch').' '.trans('messages.name'),
	        		trans('messages.bank').' '.trans('messages.code')
        		);

		$data = putCustomHeads($this->form, $data);

		$table_data['account-table'] = array(
				'source' => 'account',
				'title' => 'Account List',
				'id' => 'account_table',
				'data' => $data
			);

		$assets = ['datatable'];
		$menu = 'account';
		return view('account.index',compact('table_data','assets','menu'));
	}

	public function lists(Request $request){
		
		if(!Entrust::can('list-account'))
			return;

		$accounts = Account::all();
        $col_ids = getCustomColId($this->form);
        $values = fetchCustomValues($this->form);
        $rows = array();

        foreach($accounts as $account){

			$row = array(
				'<div class="btn-group btn-group-xs">'.
				(Entrust::can('edit-account') ? '<a href="#" data-href="/account/'.$account->id.'/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="'.trans('messages.edit').'"></i></a> ' : '').
				(Entrust::can('delete-account') ? delete_form(['account.destroy',$account->id]) : '').
				'</div>',
				$account->name,
				currency($account->opening_balance),
				toWord($account->type),
				(($account->type == 'bank') ? $account->bank_name : ''),
				(($account->type == 'bank') ? $account->branch_name : ''),
				(($account->type == 'bank') ? $account->branch_code : ''),
				);
			$id = $account->id;

			foreach($col_ids as $col_id)
				array_push($row,isset($values[$id][$col_id]) ? $values[$id][$col_id] : '');
			$rows[] = $row;
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function summary(){
		$default_currency = \App\Currency::whereIsDefault(1)->first();
		$data = array();
		$accounts = Account::all();
		foreach($accounts as $account){
			$balance = $account->opening_balance;
			foreach($account->Transaction as $transaction){
				if($transaction->head == 'income' || $transaction->head == 'account_transfer')
					$balance += $transaction->amount * $transaction->conversion_rate;
				elseif($transaction->head == 'expense')
					$balance -= $transaction->amount * $transaction->conversion_rate;
			}

			foreach($account->Transfer as $transfer)
				$balance -= $transfer->amount * $transfer->conversion_rate;

			$last_transaction = \App\Transaction::whereAccountId($account->id)->orWhere('from_account_id',$account->id)->orderBy('date','desc')->first();

			$data[] = [
						'name' => $account->name,
						'type' => toWord($account->type),
						'balance' => currency($balance,1,$default_currency->id),
						'last_transaction_date' => ($last_transaction) ? showDate($last_transaction->date) : '-'
					];
		}
		return view('account.summary',compact('data'))->render();
	}

	public function show(){
	}

	public function create(){
	}

	public function edit(Account $account){

		if(!Entrust::can('edit-account'))
            return view('global.error',['message' => trans('messages.permission_denied')]);

		$custom_field_values = getCustomFieldValues($this->form,$account->id);
		return view('account.edit',compact('account','custom_field_values'));
	}

	public function store(AccountRequest $request, Account $account){	

		if(!Entrust::can('create-account'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        $validation = validateCustomField($this->form,$request);
        
        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

		$data = $request->all();
		$data['type'] = ($request->input('type')) ? 'bank' : 'cash';
		$account->fill($data)->save();
		storeCustomField($this->form,$account->id, $data);

		$this->logActivity(['module' => 'account','module_id' => $account->id,'activity' => 'added']);

        return response()->json(['message' => trans('messages.account').' '.trans('messages.added'), 'status' => 'success']);
	}

	public function update(AccountRequest $request, Account $account){

		if(!Entrust::can('edit-account'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        $validation = validateCustomField($this->form,$request);
        
        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

		$data = $request->all();
		$data['type'] = ($request->input('type')) ? 'bank' : 'cash';
		if($data['type'] == 'cash'){
			$data['number'] = null;
			$data['bank_name'] = null;
			$data['branch_name'] = null;
			$data['branch_code'] = null;
		}
		$account->fill($data)->save();

		$this->logActivity(['module' => 'account','module_id' => $account->id,'activity' => 'updated']);

		updateCustomField($this->form,$account->id, $data);
		
        return response()->json(['message' => trans('messages.account').' '.trans('messages.updated'), 'status' => 'success']);
	}

	public function destroy(Account $account,Request $request){
		if(!Entrust::can('delete-account') || $account->is_hidden == 1)
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

		$this->logActivity(['module' => 'account','module_id' => $account->id,'activity' => 'deleted']);

		deleteCustomField($this->form, $account->id);
        
        $account->delete();
        
        return response()->json(['message' => trans('messages.account').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}
?>