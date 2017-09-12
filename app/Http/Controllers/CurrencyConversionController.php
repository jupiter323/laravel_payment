<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\CurrencyConversion;

Class CurrencyConversionController extends Controller{
    use BasicController;

	public function index(){
		$currency = getCurrency();
		$currencies = \App\Currency::all()->pluck('detail','id')->all();

		$data = array(
	        		trans('messages.date'),
	        		trans('messages.default'),
	        		trans('messages.rate'),
	        		trans('messages.currency'),
        		);

		$table_data['currency-conversion-table'] = array(
				'source' => 'currency-conversion',
				'title' => 'Currency Conversion List',
				'id' => 'currency_conversion_table',
				'data' => $data,
				'form' => 'currency-conversion-filter-form'
			);

		$assets = ['datatable'];
                $menu='currency_conversion';

		return view('currency.conversion',compact('currencies','currency','table_data','assets','menu'));
	}

	public function currencyConversionField(Request $request){
		$currency_conversions = CurrencyConversion::where('date','=',$request->input('date'))->get();
		$currencies = \App\Currency::all();
		$default_currency = getCurrency();
		$currency = \App\Currency::find($request->input('currency_id'));

        $client = new \GuzzleHttp\Client();
        $res = $client->get('http://api.fixer.io/'.$request->input('date').'?base='.$currency->name);
        $conversion_string = json_decode($res->getBody(),true);
        $conversions = array_key_exists('rates', $conversion_string) ? $conversion_string['rates'] : [];

        if(!$currency->is_default)
		return view('currency.conversion_field',compact('currency_conversions','currencies','default_currency','conversions','conversion_string','currency'))->render();
	}

	public function lists(Request $request){

		$query = CurrencyConversion::whereNotNull('id');

		if($request->has('currency_id'))
			$query->whereIn('currency_id',$request->input(['currency_id']));

        if($request->has('start_date') && $request->has('end_date'))
        	$query->whereBetween('date',[$request->input('start_date'),$request->input('end_date')]);

        $currency_conversions = $query->get();
        $default_currency = \App\Currency::whereIsDefault(1)->first();

        $rows = array();

        foreach($currency_conversions as $currency_conversion){

        	if($currency_conversion->currency_id != $default_currency->id)
			$rows[] = array(
				showDate($currency_conversion->date),
				'1 '.$default_currency->detail.' = ',
				round($currency_conversion->rate,5),
				$currency_conversion->Currency->detail,
				);
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function store(Request $request){

		$currencies = \App\Currency::all();
		$default_currency = getCurrency();

		$error = 0;
		foreach($currencies as $currency){
			if($request->has($currency->id) && !is_numeric($request->input($currency->id)))
				$error++;
		}

		if($error)
        	return response()->json(['message' => trans('messages.only_numeric_values_allowed'), 'status' => 'error']);

		foreach($currencies as $currency){
			if($currency->id != $default_currency->id){
				$currency_conversion = CurrencyConversion::firstOrNew(['date' => $request->input('date'),'currency_id' => $currency->id]);
				$currency_conversion->rate = ($request->has($currency->id)) ? $request->input($currency->id) : (($currency->name == $default_currency->name) ? 1 : 0);
				$currency_conversion->save();
			}
		}

		$this->logActivity(['module' => 'currency_conversion','module_id' => $currency_conversion->id,'activity' => 'updated']);
		
        return response()->json(['message' => trans('messages.currency').' '.trans('messages.conversion').' '.trans('messages.saved'), 'status' => 'success']);
	}

	public function fetchCurrency(Request $request){
		$currency_conversions = CurrencyConversion::where('date','=',$request->input('conversion_date'))->get();
		$currencies = \App\Currency::all();
		$default_currency = getCurrency();

        $client = new \GuzzleHttp\Client();
        $res = $client->get('http://api.fixer.io/'.$request->input('conversion_date').'?base='.$default_currency->name);
        $conversion_string = json_decode($res->getBody(),true);
        $conversions = array_key_exists('rates', $conversion_string) ? $conversion_string['rates'] : [];

		return view('currency.fetch',compact('currency_conversions','currencies','default_currency','conversions','conversion_string'))->render();
	}
}