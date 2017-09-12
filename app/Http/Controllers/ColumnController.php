<?php
namespace App\Http\Controllers;
use App\CustomField;
use App\Column;
use Illuminate\Http\Request;
use App\Http\Requests\CustomFieldRequest;
use App\Http\Requests\ColumnRequest;


Class ColumnController extends Controller{
    use BasicController;

	public function __construct()
	{
		$this->middleware('feature_available:enable_custom_field');
	}

	public function index(Column $column){

		$table_data['column-table'] = array(
			'source' => 'column',
			'title' => 'Column List',
			'id' => 'column_table',
			'data' => array(
        		trans('messages.option'),
        		trans('messages.form'),
        		trans('messages.title'),
        		trans('messages.type'),
        		trans('messages.option'),
        		trans('messages.required')
        		)
			);

		$assets = ['datatable','tags'];

		return view('column.index',compact('table_data','assets'));
	}

public function create(){
        $column= \App\Column::all()->pluck('title','id')->all();

return view('column.create',compact('column'));
}

	public function lists(Request $request){
		$columns= Column::all();

		$rows = array();
		foreach($columns as $column){
			$rows[] = array(
				delete_form(['column.destroy',$column->id]),
				toWord($column->form),
				$column->title,
				ucfirst($column->type),
				implode('<br />',explode(',',$column->options)),
				($column->is_required) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'
				);
		}
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function store(ColumnRequest $request, Column $column){

		$data = $request->all();
        $column->fill($data);

		$options = explode(',',$request->input('options'));
		$options = array_unique($options);
		$column->options = implode(',',$options);
		$column->name = createSlug($request->input('title'));
		$column->save();

		$this->logActivity(['module' => 'column','module_id' => $column->id,'activity' => 'added']);

        return response()->json(['message' => trans('messages.column').' '.trans('messages.field').' '.trans('messages.added'), 'status' => 'success']);
	}

	public function destroy(Column $column,Request $request){

		$this->logActivity(['module' => 'column','module_id' => $column->id,'activity' => 'deleted']);

        $column->delete();

        return response()->json(['message' => trans('messages.column').' '.trans('messages.field').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}
?>