<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyRequest;
use Entrust;
use App\Company;
use App\Taxregimen;


Class CompanyController extends Controller{
    use BasicController;

	protected $form = 'company-form';

	
	public function index(Company $company){

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

		$table_data['company-table'] = array(
				'source' => 'company',
				'title' => 'Company List',
				'id' => 'company_table',
				'data' => $data
			);

		$assets = ['datatable'];
		$menu = 'company';
		return view('company.index',compact('table_data','assets','menu'));
	}

	public function lists(Request $request){
		if(!Entrust::can('list-company'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

		$companies = Company::all();
        $col_ids = getCustomColId($this->form);
        $values = fetchCustomValues($this->form);
        $rows = array();

        foreach($companies as $company){

        	$address = $company->address_line_1.' '.$company->address_line_2.' <br />'.
        				$company->city.' '.$company->state.' '.$company->zipcode.' '.((isset($company->country_id) ? config('country.'.$company->country_id) : ''));

			$row = array(
				'<div class="btn-group btn-group-xs">'.
				(Entrust::can('edit-company') ? '<a href="#" data-href="/company/'.$company->id.'/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="'.trans('messages.edit').'"></i></a> ' : '').
				(Entrust::can('delete-company') ? delete_form(['company.destroy',$company->id]) : '').
				'</div>',
				$company->name,
				$company->email,
				$company->phone,
				$company->website,
				$address
				);
			$id = $company->id;

			foreach($col_ids as $col_id)
				array_push($row,isset($values[$id][$col_id]) ? $values[$id][$col_id] : '');
			$rows[] = $row;
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}


	public function show(){
	}

	public function create(Company $company){
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

$taxregimen= Taxregimen::pluck('tax_regimen_name', 'tr_id');


		$business_type=array('1'=>'Individual','2'=>'Company');

                $neighbourhood=array();
		$assets = ['datatable'];
		$menu = 'company_add';
		return view('company.create',compact('assets','menu','business_type','taxregimen','neighbourhood'));


	}



	public function edit(Company $company){
                if(!Entrust::can('edit-company'))
                return view('global.error',['message' => trans('messages.permission_denied')]);
		$custom_field_values = getCustomFieldValues($this->form,$company->id);
                $neighbourhood=array();
                $taxregimen= Taxregimen::pluck('tax_regimen_name', 'tr_id');
		$business_type=array('1'=>'Individual','2'=>'Company');
		return view('company.edit',compact('company','custom_field_values','business_type','taxregimen','neighbourhood'));
	}


public function store_view(Company $company)
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

$taxregimen= Taxregimen::pluck('tax_regimen_name', 'tr_id');


		$business_type=array('1'=>'Individual','2'=>'Company');

$neighbourhood=array();
		$assets = ['datatable'];
		$menu = 'company_add';
		return view('company.store',compact('assets','menu','business_type','taxregimen','neighbourhood'));

}


	public function store(CompanyRequest $request, Company $company){	

		if(!Entrust::can('create-company'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

$data = $request->all();
     if ($request->file('logo')){
	    $image = $request->file('logo');
	    $input['imagename'] = 'Company_'.time().'.'.$image->getClientOriginalExtension();
	    $destinationPath = public_path('/uploads/logo');
	    $image->move($destinationPath, $input['imagename']);
	    $str='uploads/logo';
	    $path1=$str.'/'.$input['imagename'];    
            unset($data['logo']);
            $data['logo']=$path1;        
        } 

  if ($request->file('email_logo')){
	    $image = $request->file('email_logo');
	    $input['imagename'] = 'Email_'.time().'.'.$image->getClientOriginalExtension();
	    $destinationPath = public_path('/uploads/email_logo');
	    $image->move($destinationPath, $input['imagename']);
	    $str1='uploads/email_logo';
	    $path2=$str1.'/'.$input['imagename'];            
            unset($data['email_logo']);      
            $data['email_logo']=$path2;
       } 

if ($request->file('private')){
	    $image = $request->file('private');
	    $input['imagename'] = 'private_'.time().'.'.$image->getClientOriginalExtension();
	    $destinationPath = public_path('/uploads/private_key');
	    $image->move($destinationPath, $input['imagename']);
	    $str2='uploads/private_key';
	    $path3=$str2.'/'.$input['imagename'];  
            unset($data['private']);  
            $data['private']=$path3;      
       } 
if ($request->file('public')){
	    $image = $request->file('public');
	    $input['imagename'] = 'public_'.time().'.'.$image->getClientOriginalExtension();
	    $destinationPath = public_path('/uploads/public_key');
	    $image->move($destinationPath, $input['imagename']);
	    $str3='uploads/public_key';
	    $path4=$str3.'/'.$input['imagename']; 
            unset($data['public']);         
            $data['public']=$path4;         
       } 
if ($request->input('pass')){
            $pass= $request->input('pass');
            $password = bcrypt($pass);
            unset($data['pass']);         
            $data['pass']=$password;      
		}
                
                
                
                
		$company->fill($data)->save();
		storeCustomField($this->form,$company->id, $data);



		$this->logActivity(['module' => 'company','module_id' => $company->id,'activity' => 'added']);

        return response()->json(['message' => trans('messages.company').' '.trans('messages.added'), 'status' => 'success']);
return view('company.edit');
	}

	public function update(CompanyRequest $request, Company $company){

		if(!Entrust::can('edit-company'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

		$data = $request->all();
		$company->fill($data)->save();

		$this->logActivity(['module' => 'company','module_id' => $company->id,'activity' => 'updated']);

		updateCustomField($this->form,$company->id, $data);
		
        return response()->json(['message' => trans('messages.company').' '.trans('messages.updated'), 'status' => 'success']);
	}

	public function destroy(Company $company,Request $request){
		if(!Entrust::can('delete-company') || $company->is_hidden == 1)
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

		$this->logActivity(['module' => 'company','module_id' => $company->id,'activity' => 'deleted']);

		deleteCustomField($this->form, $company->id);
        
        $company->delete();
        
        return response()->json(['message' => trans('messages.company').' '.trans('messages.deleted'), 'status' => 'success']);
	}




}
?>