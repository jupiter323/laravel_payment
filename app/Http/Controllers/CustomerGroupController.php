<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\CustomerGroupRequest;
use App\CustomerGroup;

Class CustomerGroupController extends Controller{
    use BasicController;

	public function index(){
	}

	public function show(){
	}

	public function create(){
	}

	public function lists(){
		$customer_groups = CustomerGroup::all();
		return view('customer_group.list',compact('customer_groups'))->render();
	}

	public function edit(CustomerGroup $customer_group){
		return view('customer_group.edit',compact('customer_group'));
	}

	public function store(CustomerGroupRequest $request, CustomerGroup $customer_group){	

		$customer_group->fill($request->all())->save();

		$this->logActivity(['module' => 'customer_group','module_id' => $customer_group->id,'activity' => 'added']);

    	$new_data = array('value' => $customer_group->name,'id' => $customer_group->id,'field' => 'customer_group_id');
    	$data = $this->lists();
        $response = ['message' => trans('messages.customer').' '.trans('messages.group').' '.trans('messages.added'), 'status' => 'success','data' => $data,'new_data' => $new_data]; 
        return response()->json($response);
	}

	public function update(CustomerGroupRequest $request, CustomerGroup $customer_group){

		$customer_group->fill($request->all())->save();

		$this->logActivity(['module' => 'customer_group','module_id' => $customer_group->id,'activity' => 'updated']);

        return response()->json(['message' => trans('messages.customer').' '.trans('messages.group').' '.trans('messages.updated'), 'status' => 'success']);
	}

	public function destroy(CustomerGroup $customer_group,Request $request){

		$this->logActivity(['module' => 'customer_group','module_id' => $customer_group->id,'activity' => 'deleted']);

        $customer_group->delete();

        return response()->json(['message' => trans('messages.customer').' '.trans('messages.group').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}
?>