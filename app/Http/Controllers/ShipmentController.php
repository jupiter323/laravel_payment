<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\ShipmentRequest;
use App\ShipmentAddress;


Class ShipmentController extends Controller{
    use BasicController;

	public function index(){
	}

	public function show(){
	}

	public function create(){
                 $neighbourhood=array();
		return view('shipment_address.create',compact('shipment_address','neighbourhood'));
	}

	public function lists(){
		$shipment_address= ShipmentAddress::all();
		return view('shipment_address.list',compact('shipment_address'))->render();
	}

	public function edit(ShipmentAddress $shipment_address){
		return view('shipment_address.edit',compact('shipment_address'));
	}

	public function store(ShipmentRequest $request, ShipmentAddress $shipment_address){	

		$shipment_address->fill($request->all());
		
		if($request->input('is_default')){
			$shipment_address->is_default = 1;
			ShipmentAddress::whereNotNull('id')->update(['is_default' => 0]);
		}

		$shipment_address->save();

		$this->logActivity(['module' => 'shipment_address','module_id' => $shipment_address->id,'activity' => 'added']);

    	$new_data = array('value' => $shipment_address->shipment_address,'id' => $shipment_address->id,'field' => 'taxation_id');
        return response()->json(['message' => trans('messages.shipment').' '.trans('messages.added'), 'status' => 'success','new_data' => $new_data]);
	}

	public function update(ShipmentRequest $request, ShipmentAddress $shipment_address){

		if($request->input('is_default')){
			ShipmentAddress::where('id','!=',$shipment_address->id)->update(['is_default' => 0]);
			$shipment_address->is_default = 1;
		}

		$shipment_address->fill($request->all())->save();
		
		$this->logActivity(['module' => 'shipment_address','module_id' => $shipment_address->id,'activity' => 'updated']);

        return response()->json(['message' => trans('messages.shipment').' '.trans('messages.updated'), 'status' => 'success']);
	}

	public function destroy(ShipmentAddress $shipment_address,Request $request){

		$this->logActivity(['module' => 'shipment_address','module_id' => $shipment_address->id,'activity' => 'deleted']);

        $shipment_address->delete();

        return response()->json(['message' => trans('messages.shipment').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}
?>