<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentMethodRequest;
use App\PaymentMethod;

Class PaymentMethodController extends Controller{
    use BasicController;

	public function index(){
	}

	public function show(){
	}

	public function create(){
		return view('payment_method.create',compact('payment_method'));

	}

	public function lists(){
		$payment_methods = PaymentMethod::all();
		return view('payment_method.list',compact('payment_methods'))->render();
	}

	public function edit(PaymentMethod $payment_method){
		return view('payment_method.edit',compact('payment_method'));
	}

	public function store(PaymentMethodRequest $request, PaymentMethod $payment_method){	

		$payment_method->fill($request->all())->save();

		$this->logActivity(['module' => 'payment_method','module_id' => $payment_method->id,'activity' => 'added']);

    	$new_data = array('value' => $payment_method->name,'id' => $payment_method->id,'field' => 'payment_method_id');
        return response()->json(['message' => trans('messages.payment').' '.trans('messages.method').' '.trans('messages.added'), 'status' => 'success','new_data' => $new_data]);
	}

	public function update(PaymentMethodRequest $request, PaymentMethod $payment_method){

		$payment_method->fill($request->all())->save();

		$this->logActivity(['module' => 'payment_method','module_id' => $payment_method->id,'activity' => 'updated']);

        return response()->json(['message' => trans('messages.payment').' '.trans('messages.method').' '.trans('messages.updated'), 'status' => 'success']);
	}

	public function destroy(PaymentMethod $payment_method,Request $request){

		$this->logActivity(['module' => 'payment_method','module_id' => $payment_method->id,'activity' => 'deleted']);

        $payment_method->delete();

        return response()->json(['message' => trans('messages.payment').' '.trans('messages.method').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}
?>