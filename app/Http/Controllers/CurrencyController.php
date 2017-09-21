<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\CurrencyRequest;
use App\Currency;
use Entrust;

Class CurrencyController extends Controller{
    use BasicController;

	public function index(){
	}

	public function show(){
	}

    public function fetchDetail(Request $request){
        $currency = Currency::find($request->input('currency_id'));
        return response()->json(['symbol' => $currency->symbol,'position' => $currency->position,'decimal_place' => $currency->decimal_place,'message' => trans('messages.currency').' '.trans('messages.updated'), 'status' => 'success']);
    }

	public function create(){
		return view('currency.create',compact('currency'));
	}

	public function lists(){
		$currencies = Currency::all();
		return view('currency.list',compact('currencies'))->render();
	}

	public function edit(Currency $currency){
		return view('currency.edit',compact('currency'));
	}

	public function store(CurrencyRequest $request, Currency $currency){	
        if(!getMode())
            return response()->json(['message' => trans('messages.disable_message'), 'status' => 'error']);

		$currency->fill($request->all());
		
		if($request->input('is_default')){
			$currency->is_default = 1;
			Currency::whereNotNull('id')->update(['is_default' => 0]);
		}

		$currency->save();

		$this->logActivity(['module' => 'currency','module_id' => $currency->id,'activity' => 'added']);

    	$new_data = array('value' => $currency->detail,'id' => $currency->id,'field' => 'currency_id');
        $response = ['message' => trans('messages.currency').' '.trans('messages.added'), 'status' => 'success','new_data' => $new_data]; 
        $response = $this->getSetupGuide($response,'currency');
        return response()->json($response);
	}

	public function update(CurrencyRequest $request, Currency $currency){
        if(!getMode())
            return response()->json(['message' => trans('messages.disable_message'), 'status' => 'error']);

		if($request->input('is_default')){
			Currency::where('id','!=',$currency->id)->update(['is_default' => 0]);
			$currency->is_default = 1;
		}

		$currency->fill($request->all())->save();
		
		$this->logActivity(['module' => 'currency','module_id' => $currency->id,'activity' => 'updated']);

        return response()->json(['message' => trans('messages.currency').' '.trans('messages.updated'), 'status' => 'success']);
	}

	public function destroy(Currency $currency,Request $request){
        if(!getMode())
            return response()->json(['message' => trans('messages.disable_message'), 'status' => 'error']);

		$this->logActivity(['module' => 'currency','module_id' => $currency->id,'activity' => 'deleted']);

        $currency->delete();

        return response()->json(['message' => trans('messages.currency').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}
?>