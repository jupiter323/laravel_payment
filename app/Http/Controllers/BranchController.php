<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\BranchRequest;

use Entrust;
use App\Company;
use App\Zip;

use App\Branch;

use App\Taxregimen;


Class BranchController extends Controller{
    use BasicController;

	protected $form = 'branch-form';

	
	public function index(Branch $branch){

		if(!Entrust::can('list-company'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

		$data = array(
	        		trans('messages.option'),
	        		trans('messages.name'),
	        		trans('messages.email'),
	        		trans('messages.phone'),	        		
	        		trans('messages.address')
        		);

		$data = putCustomHeads($this->form, $data);

		$table_data['branch-table'] = array(
				'source' => 'branch',
				'title' => 'Branch List',
				'id' => 'branch_table',
				'data' => $data
			);

		$assets = ['datatable'];
		$menu = 'branch';
		return view('branch.index',compact('table_data','assets','menu'));
	}

	public function lists(Request $request){
		if(!Entrust::can('list-company'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

		$branches = Branch::all();
        $col_ids = getCustomColId($this->form);
        $values = fetchCustomValues($this->form);
        $rows = array();

        foreach($branches as $branch){

        	$address = $branch->street.' '.$branch->location.' <br />'.
        				$branch->city.' '.$branch->state.' '.$branch->zipcode.' '.((isset($branch->country_id) ? config('country.'.$branch->country_id) : ''));

			$row = array(
				'<div class="btn-group btn-group-xs">'.
				(Entrust::can('edit-company') ? '<a href="#" data-href="/branch/'.$branch->id.'/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="'.trans('messages.edit').'"></i></a> ' : '').
				(Entrust::can('delete-company') ? delete_form(['branch.destroy',$branch->id]) : '').
				'</div>',
				$branch->branch_name,
				$branch->email,
				$branch->phone,
				$address
				);
			$id = $branch->id;

			foreach($col_ids as $col_id)
				array_push($row,isset($values[$id][$col_id]) ? $values[$id][$col_id] : '');
			$rows[] = $row;
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}


	public function show(){
	}

	public function create(){
	}



	public function edit(Branch $branch){
                if(!Entrust::can('edit-company'))
                return view('global.error',['message' => trans('messages.permission_denied')]);

		$custom_field_values = getCustomFieldValues($this->form,$branch->id);
                $neighbourhood=array();  
              $companies = \App\Company::all()->pluck('name','id')->all();

		return view('branch.edit',compact('branch','custom_field_values','neighbourhood','companies'));
	}


public function store_view(Branch $branch)
{

if(!Entrust::can('list-company'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

		$data = array(
	        		trans('messages.option'),
	        		trans('messages.name'),
	        		trans('messages.email'),
	        		trans('messages.phone'),
	        		trans('messages.website'),
	        		trans('messages.address')
        		);

		$data = putCustomHeads($this->form, $data);
$neighbourhood=array();
$companies = \App\Company::all()->pluck('name','id')->all();
		$assets = ['datatable'];
		$menu = 'branch_add';

		return view('branch.store',compact('assets','menu','neighbourhood','companies'));

}


	public function store(BranchRequest $request, Branch $branch){	

		if(!Entrust::can('create-company'))
                return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);
                $data = $request->all();
		$branch->fill($data)->save();
		storeCustomField($this->form,$branch->id, $data);
		$this->logActivity(['module' => 'branch','module_id' => $branch->id,'activity' => 'added']);
                return response()->json(['message' => trans('messages.branch').' '.trans('messages.added'), 'status' => 'success']);
           return view('branch.edit');
	}

	public function update(BranchRequest $request, Branch $branch){

		if(!Entrust::can('edit-company'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

		$data = $request->all();
		$branch->fill($data)->save();

		$this->logActivity(['module' => 'branch','module_id' => $branch->id,'activity' => 'updated']);

		updateCustomField($this->form,$branch->id, $data);
		
        return response()->json(['message' => trans('messages.branch').' '.trans('messages.updated'), 'status' => 'success']);
	}

	public function destroy(Branch $branch,Request $request){
		if(!Entrust::can('delete-company') || $branch->is_hidden == 1)
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

		$this->logActivity(['module' => 'branch','module_id' => $branch->id,'activity' => 'deleted']);

		deleteCustomField($this->form, $branch->id);
        
        $branch->delete();
        
        return response()->json(['message' => trans('messages.branch').' '.trans('messages.deleted'), 'status' => 'success']);
	}




}
?>