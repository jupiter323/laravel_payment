<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\IncomeCategoryRequest;
use App\IncomeCategory;

Class IncomeCategoryController extends Controller{
    use BasicController;

	public function index(){
	}

	public function show(){
	}

	public function create(){
	}

	public function lists(){
		$income_categories = IncomeCategory::all();
		return view('income_category.list',compact('income_categories'))->render();
	}

	public function edit(IncomeCategory $income_category){
		return view('income_category.edit',compact('income_category'));
	}

	public function store(IncomeCategoryRequest $request, IncomeCategory $income_category){	

		$income_category->fill($request->all())->save();

		$this->logActivity(['module' => 'income_category','module_id' => $income_category->id,'activity' => 'added']);

    	$new_data = array('value' => $income_category->name,'id' => $income_category->id,'field' => 'income_category_id');
    	$data = $this->lists();
        $response = ['message' => trans('messages.income').' '.trans('messages.category').' '.trans('messages.added'), 'status' => 'success','data' => $data,'new_data' => $new_data]; 
        return response()->json($response);	
	}

	public function update(IncomeCategoryRequest $request, IncomeCategory $income_category){

		$income_category->fill($request->all())->save();

		$this->logActivity(['module' => 'income_category','module_id' => $income_category->id,'activity' => 'updated']);

        return response()->json(['message' => trans('messages.income').' '.trans('messages.category').' '.trans('messages.updated'), 'status' => 'success']);
	}

	public function destroy(IncomeCategory $income_category,Request $request){

		$this->logActivity(['module' => 'income_category','module_id' => $income_category->id,'activity' => 'deleted']);

        $income_category->delete();

        return response()->json(['message' => trans('messages.income').' '.trans('messages.category').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}
?>