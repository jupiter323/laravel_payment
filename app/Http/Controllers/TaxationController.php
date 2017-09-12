<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\TaxationRequest;
use App\Taxation;

Class TaxationController extends Controller{
    use BasicController;

	public function index(){
	}

	public function show(){
	}

	public function create(){
		return view('taxation.create',compact('taxation'));
	}

	public function lists(){
		$taxations = Taxation::all();
		return view('taxation.list',compact('taxations'))->render();
	}

	public function edit(Taxation $taxation){
		return view('taxation.edit',compact('taxation'));
	}

	public function store(TaxationRequest $request, Taxation $taxation){	

		$taxation->fill($request->all());
		
		if($request->input('is_default')){
			$taxation->is_default = 1;
			Taxation::whereNotNull('id')->update(['is_default' => 0]);
		}

		$taxation->save();

		$this->logActivity(['module' => 'taxation','module_id' => $taxation->id,'activity' => 'added']);

    	$new_data = array('value' => $taxation->detail,'id' => $taxation->id,'field' => 'taxation_id');
        return response()->json(['message' => trans('messages.taxation').' '.trans('messages.added'), 'status' => 'success','new_data' => $new_data]);
	}

	public function update(TaxationRequest $request, Taxation $taxation){

		if($request->input('is_default')){
			Taxation::where('id','!=',$taxation->id)->update(['is_default' => 0]);
			$taxation->is_default = 1;
		}

		$taxation->fill($request->all())->save();
		
		$this->logActivity(['module' => 'taxation','module_id' => $taxation->id,'activity' => 'updated']);

        return response()->json(['message' => trans('messages.taxation').' '.trans('messages.updated'), 'status' => 'success']);
	}

	public function destroy(Taxation $taxation,Request $request){

		$this->logActivity(['module' => 'taxation','module_id' => $taxation->id,'activity' => 'deleted']);

        $taxation->delete();

        return response()->json(['message' => trans('messages.taxation').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}
?>