<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\ItemPriceRequest;
use Entrust;
use App\ItemPrice;

Class ItemPriceController extends Controller{
    use BasicController;

	protected $form = 'item-price-form';

    public function __construct()
    {
        $this->middleware(['staff_accessible']);
    }

	public function index(ItemPrice $item_price){

		if(!Entrust::can('manage-item-price'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

        $data = array(
        		trans('messages.option'),
        		trans('messages.item').' '.trans('messages.name'),
        		trans('messages.unit').' '.trans('messages.price')
        		);

        $data = putCustomHeads($this->form, $data);
        $menu = 'item_price';
        $assets = ['datatable'];
        $table_data['item-price-table'] = array(
			'source' => 'item-price',
			'title' => 'Item Price List',
			'id' => 'item_price_table',
			'data' => $data
		);
        $items = \App\Item::all()->pluck('full_item_name','id')->all();
        $currencies = \App\Currency::all()->pluck('name','id')->all();

		return view('item_price.index',compact('menu','table_data','items','currencies','assets'));
	}

	public function lists(Request $request){

		$item_prices = ItemPrice::all();
        $rows=array();
        $col_ids = getCustomColId($this->form);
        $values = fetchCustomValues($this->form);

        foreach($item_prices as $item_price){

			$row = array(
				'<div class="btn-group btn-group-xs">'.
				'<a href="#" data-href="item-price/'.$item_price->id.'/edit" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="'.trans('messages.edit').'"></i></a>'.
				delete_form(['item-price.destroy',$item_price->id]).
				'</div>',
				$item_price->Item->full_item_name,
				currency($item_price->unit_price,1,$item_price->Currency->id)
				);	
			$id = $item_price->id;

			foreach($col_ids as $col_id)
				array_push($row,isset($values[$id][$col_id]) ? $values[$id][$col_id] : '');
        	$rows[] = $row;
			
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function edit(ItemPrice $item_price){

		if(!Entrust::can('manage-item-price'))
            return view('common.error',['message' => trans('messages.permission_denied')]);

        $items = \App\Item::all()->pluck('full_item_name','id')->all();
        $currencies = \App\Currency::all()->pluck('name','id')->all();
		$custom_field_values = getCustomFieldValues($this->form,$item_price->id);

		return view('item_price.edit',compact('item_price','items','custom_field_values','currencies'));
	}

	public function store(ItemPriceRequest $request, ItemPrice $item_price){

		if(!Entrust::can('manage-item-price'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        $validation = validateCustomField($this->form,$request);
        
        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

		$data = $request->all();
	    $item_price->fill($data);
		$item_price->save();

		storeCustomField($this->form,$item_price->id, $data);
		$this->logActivity(['module' => 'item_price','module_id' => $item_price->id,'activity' => 'added']);

        return response()->json(['message' => trans('messages.item').' '.trans('messages.price').' '.trans('messages.added'), 'status' => 'success']);
	}

	public function update(ItemPriceRequest $request, ItemPrice $item_price){

		if(!Entrust::can('manage-item-price'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        $validation = validateCustomField($this->form,$request);
        
        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);
        
		$data = $request->all();
		$item_price->fill($data);
		$item_price->save();

		updateCustomField($this->form,$item_price->id, $data);
		$this->logActivity(['module' => 'item_price','module_id' => $item_price->id,'activity' => 'updated']);
		
        return response()->json(['message' => trans('messages.item').' '.trans('messages.price').' '.trans('messages.updated'), 'status' => 'success']);
	}

	public function destroy(ItemPrice $item_price,Request $request){

		if(!Entrust::can('manage-item-price'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

		$this->logActivity(['module' => 'item_price','module_id' => $item_price->id,'activity' => 'deleted']);

		deleteCustomField($this->form, $item_price->id);
        $item_price->delete();

        return response()->json(['message' => trans('messages.item').' '.trans('messages.price').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}
?>