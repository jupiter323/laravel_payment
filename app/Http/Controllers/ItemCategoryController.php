<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\ItemCategoryRequest;
use App\ItemCategory;

Class ItemCategoryController extends Controller{
    use BasicController;

	public function index(){

	}

	public function show(){
	}

	public function create(){
	}

	public function lists(){
		$item_categories = ItemCategory::all();
		return view('item_category.list',compact('item_categories'))->render();
	}

	public function edit(ItemCategory $item_category){
		return view('item_category.edit',compact('item_category'));
	}

	public function store(ItemCategoryRequest $request, ItemCategory $item_category){	

		$item_category->fill($request->all())->save();

		$this->logActivity(['module' => 'item_category','module_id' => $item_category->id,'activity' => 'added']);

    	$new_data = array('value' => $item_category->name,'id' => $item_category->id,'field' => 'item_category_id');
        return response()->json(['message' => trans('messages.item').' '.trans('messages.category').' '.trans('messages.added'), 'status' => 'success','new_data' => $new_data]);
	}

	public function update(ItemCategoryRequest $request, ItemCategory $item_category){

		$item_category->fill($request->all())->save();

		$this->logActivity(['module' => 'item_category','module_id' => $item_category->id,'activity' => 'updated']);

        return response()->json(['message' => trans('messages.item').' '.trans('messages.category').' '.trans('messages.updated'), 'status' => 'success']);
	}

	public function destroy(ItemCategory $item_category,Request $request){

		$this->logActivity(['module' => 'item_category','module_id' => $item_category->id,'activity' => 'deleted']);

        $item_category->delete();

        return response()->json(['message' => trans('messages.item').' '.trans('messages.category').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}
?>