<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\ExpenseCategoryRequest;
use App\ExpenseCategory;

Class ExpenseCategoryController extends Controller{
    use BasicController;

	public function index(){
	}

	public function show(){
	}

	public function create(){
	}

	public function lists(){
		$expense_categories = ExpenseCategory::all();
		return view('expense_category.list',compact('expense_categories'))->render();
	}

	public function edit(ExpenseCategory $expense_category){
		return view('expense_category.edit',compact('expense_category'));
	}

	public function store(ExpenseCategoryRequest $request, ExpenseCategory $expense_category){	

		$expense_category->fill($request->all())->save();

		$this->logActivity(['module' => 'expense_category','module_id' => $expense_category->id,'activity' => 'added']);

    	$new_data = array('value' => $expense_category->name,'id' => $expense_category->id,'field' => 'expense_category_id');
    	$data = $this->lists();
        $response = ['message' => trans('messages.expense').' '.trans('messages.category').' '.trans('messages.added'), 'status' => 'success','data' => $data,'new_data' => $new_data]; 
        return response()->json($response);	
	}

	public function update(ExpenseCategoryRequest $request, ExpenseCategory $expense_category){

		$expense_category->fill($request->all())->save();

		$this->logActivity(['module' => 'expense_category','module_id' => $expense_category->id,'activity' => 'updated']);

        return response()->json(['message' => trans('messages.expense').' '.trans('messages.category').' '.trans('messages.updated'), 'status' => 'success']);
	}

	public function destroy(ExpenseCategory $expense_category,Request $request){

		$this->logActivity(['module' => 'expense_category','module_id' => $expense_category->id,'activity' => 'deleted']);

        $expense_category->delete();

        return response()->json(['message' => trans('messages.expense').' '.trans('messages.category').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}
?>