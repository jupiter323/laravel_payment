<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use Entrust;
use App\Group;

Class GroupController extends Controller{
    use BasicController;

	

	protected $form = 'company-form';

	public function index(){

		if(!Entrust::can('list-company'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

		$data = array(
                                trans('messages.id'),
	        		trans('messages.name'),
	        		
        		);

		$data = putCustomHeads($this->form, $data);

		$table_data['company-table'] = array(
				'source' => 'Group',
				'title' => 'Group List',
				'id' => 'group_table',
				'data' => $data
			);

		$assets = ['datatable'];
		$menu = 'Group';
		return view('group.index',compact('table_data','assets','menu'));
	}



   public function create(){
	}


public function store(CompanyRequest $request, Company $company){	

		if(!Entrust::can('create-company'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

		$data = $request->all();
		$company->fill($data)->save();
		storeCustomField($this->form,$company->id, $data);

		$this->logActivity(['module' => 'company','module_id' => $company->id,'activity' => 'added']);

        return response()->json(['message' => trans('messages.company').' '.trans('messages.added'), 'status' => 'success']);
	}
	
}
?>