<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
use Entrust;
use App\Item;

Class ItemController extends Controller{
    use BasicController;

	protected $form = 'item-form';

    public function __construct()
    {
        $this->middleware(['staff_accessible']);
    }

	public function index(Item $item){

		if(!Entrust::can('list-item'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

        $data = array(
        		trans('messages.option'),
        		trans('messages.name'),
        		trans('messages.code'),
        		trans('messages.category'),
        		trans('messages.unit').' '.trans('messages.price'),
        		trans('messages.taxation'),
        		trans('messages.discount')
        		);

        $data = putCustomHeads($this->form, $data);
        $menu = 'item';
        $assets = ['datatable'];
        $table_data['item-table'] = array(
			'source' => 'item',
			'title' => 'Item List',
			'id' => 'item_table',
			'data' => $data
		);
        $item_categories = \App\ItemCategory::all()->pluck('name','id')->all();
     //   $taxations = \App\Taxation::all()->pluck('detail','id')->all();
        $taxations = \App\TaxationGroup::all()->pluck('taxation_group_name','id')->all();
        $unit= \App\Unit::all()->pluck('name','id')->all();
        $currencies = \App\Currency::all()->pluck('detail','id')->all();
        $max_id=Item::max('id');
        $max_id+=1;

		return view('item.index',compact('table_data','menu','item_categories','taxations','assets','unit','currencies','max_id'));
	}

	public function lists(Request $request){

		$items = Item::all();
        $rows=array();
        $col_ids = getCustomColId($this->form);
        $values = fetchCustomValues($this->form);

        foreach($items as $item){

        	$price = '<ol>';
        	foreach($item->ItemPrice as $item_price){
        		$price .= '<li>'.$item_price->Currency->name.' : '.currency($item_price->unit_price,1,$item_price->Currency->id).'</li>';
        	}
        	$price .= '</ol>';

			$row = array(
				'<div class="btn-group btn-group-xs">'.
				((Entrust::can('edit-item')) ? '<a href="#" data-href="item/'.$item->id.'/edit" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="'.trans('messages.edit').'"></i></a> ' : '').
				((Entrust::can('delete-item')) ? delete_form(['item.destroy',$item->id]) : '').
				'</div>',
				$item->name,
				$item->code,
				$item->ItemCategory->name,
				$price,
				$item->Taxation->detail,
				round($item->discount,2)
				);	
			$id = $item->id;

			foreach($col_ids as $col_id)
				array_push($row,isset($values[$id][$col_id]) ? $values[$id][$col_id] : '');
        	$rows[] = $row;
			
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function fetchPrice(Request $request){
               
		$item = Item::find($request->input('item_id'));
		if($item)
		$item_price = \App\ItemPrice::whereItemId($item->id)->whereCurrencyId($request->input('currency_id'))->first();
		$currency = \App\Currency::find($request->input('currency_id'));

		$unit_price = isset($item_price) ? round($item_price->unit_price,$currency->decimal_place) : '';
		$discount = ($item) ? round($item->discount,$currency->decimal_place) : 0;
		$tax = ($item) ? round($item->Taxation->value,5) : 0;
		$description = ($item) ? $item->description : '';
                $unit= ($item) ? $item->unit: '';              
                
                $item_units=\App\Unit::where('id',$unit)->get();
                foreach($item_units as $itemunit)
                 {
                 $unit_name=$itemunit->name;
                 }
                
		if(!isset($item_price))
			$response = ['unit_price' => $unit_price, 'discount' => $discount, 'tax' => $tax, 'status' => 'error','description' => $description,'unit' => $unit_name, 'message' => trans('messages.item_price_not_set')];
		else
			$response = ['unit_price' => $unit_price, 'discount' => $discount, 'tax' => $tax, 'status' => 'success','description' => $description,'unit' => $unit_name, 'message' => trans('messages.item').' '.trans('messages.detail').' '.trans('messages.updated')];
		
        return response()->json($response);
	}

	public function create(){

		if(!Entrust::can('create-item'))
        return view('global.error',['message' => trans('messages.permission_denied')]);
        $item_categories = \App\ItemCategory::all()->pluck('name','id')->all();
      //  $taxations = \App\Taxation::all()->pluck('detail','id')->all();
        $taxations = \App\TaxationGroup::all()->pluck('taxation_group_name','id')->all();
        $unit= \App\Unit::all()->pluck('name','id')->all();
        $currencies = \App\Currency::all()->pluck('detail','id')->all();
        $max_id=Item::max('id');
        $max_id+=1;


	return view('item.create',compact('designations','item_categories','taxations','unit','currencies','max_id'));
	}

	public function edit(Item $item){

		if(!Entrust::can('edit-item'))
            return view('global.error',['message' => trans('messages.permission_denied')]);

        $item_categories = \App\ItemCategory::all()->pluck('name','id')->all();
        //$taxations = \App\Taxation::all()->pluck('taxation_name_with_value','id')->all();
        $taxations = \App\TaxationGroup::all()->pluck('taxation_group_name','id')->all();
        $unit= \App\Unit::all()->pluck('name','id')->all();
        $currencies = \App\Currency::all()->pluck('detail','id')->all();
	$custom_field_values = getCustomFieldValues($this->form,$item->id);
        $max_id=Item::max('id');
        $max_id+=1;

		return view('item.edit',compact('item','item_categories','custom_field_values','taxations','unit','currencies','max_id'));
	}

	public function store(ItemRequest $request, Item $item){

		if(!Entrust::can('create-item'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        $validation = validateCustomField($this->form,$request);
        
        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

		$data = $request->all();
	        $item->fill($data);
		$item->save();

                $data['item_id']=$item->id;
                $item_price= new \App\ItemPrice; 
                $item_price->fill($data);
                $item_price->save();
           
               /* $item_price= new \App\ItemPrice; 
                $item_price->item()->associate($item);
                $item_price->save();*/
            



		storeCustomField($this->form,$item->id, $data);
		$this->logActivity(['module' => 'item','module_id' => $item->id,'activity' => 'added']);

    	$new_data = array('value' => $item->full_item_name,'id' => $item->id,'field' => 'table-invoice-item select');
        return response()->json(['message' => trans('messages.item').' '.trans('messages.added'), 'status' => 'success','new_data' => $new_data]);	
	}

	public function update(ItemRequest $request, Item $item){

		if(!Entrust::can('edit-item'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        $validation = validateCustomField($this->form,$request);
        
        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);
        
		$data = $request->all();
		$item->fill($data);
		$item->save();

		updateCustomField($this->form,$item->id, $data);
		$this->logActivity(['module' => 'item','module_id' => $item->id,'activity' => 'updated']);
		
        return response()->json(['message' => trans('messages.item').' '.trans('messages.updated'), 'status' => 'success']);
	}

	public function destroy(Item $item,Request $request){

		if(!Entrust::can('delete-item'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

		$this->logActivity(['module' => 'item','module_id' => $item->id,'activity' => 'deleted']);

		deleteCustomField($this->form, $item->id);
        $item->delete();

        return response()->json(['message' => trans('messages.item').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}
?>