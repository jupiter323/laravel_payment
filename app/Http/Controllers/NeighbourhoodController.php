<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\NeighbourhoodRequest;
use Entrust;
use App\Neighbourhood  ;
use App\Taxregimen;
use App\Zipcode;


Class NeighbourhoodController extends Controller{
    use BasicController;

	protected $form = 'Neighbourhood-form';

	
	public function index(Neighbourhood  $neighbourhood ){

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
				'source' => 'neighbourhood ',
				'title' => 'Neighbourhood  List',
				'id' => 'neighbourhood_table',
				'data' => $data
			);

		$assets = ['datatable'];
		$menu = 'neighbourhood ';
		return view('neighbourhood.index',compact('table_data','assets','menu'));
	}

	public function lists(Request $request){
		if(!Entrust::can('list-company'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

		$neighbourhoods = Neighbourhood::all();
        $col_ids = getCustomColId($this->form);
        $values = fetchCustomValues($this->form);
        $rows = array();

        foreach($neighbourhoods as $neighbourhood ){

        	$address = $neighbourhood->address_line_1.' '.$neighbourhood->address_line_2.' <br />'.
        				$neighbourhood->city.' '.$neighbourhood->state.' '.$neighbourhood->zipcode.' '.((isset($neighbourhood->country_id) ? config('country.'.$neighbourhood->country_id) : ''));

			$row = array(
				'<div class="btn-group btn-group-xs">'.
				(Entrust::can('edit-company') ? '<a href="#" data-href="/neighbourhood/'.$neighbourhood ->id.'/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="'.trans('messages.edit').'"></i></a> ' : '').
				(Entrust::can('delete-company') ? delete_form(['neighbourhood.destroy',$neighbourhood->id]) : '').
				'</div>',
				$neighbourhood->name,
				$neighbourhood->code,
				
				$neighbourhood 
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

	public function create(Neighbourhood $neighbourhood ){
                if(!Entrust::can('list-company'))
		return redirect('/home')->withErrors(trans('messages.permission_denied'));
		$data = array(
	        		trans('messages.option'),
	        		trans('messages.name'),
	        		trans('messages.code'),
	        		
        		     );
		$data = putCustomHeads($this->form, $data);
                $taxregimen= Taxregimen::pluck('tax_regimen_name', 'tr_id');
                $zipcode= Zipcode::pluck('zipcode', 'id');

		$business_type=array('1'=>'Individual','2'=>'Company');
              
		$assets = ['datatable'];
		$menu = 'neighbourhood_add';
		return view('neighbourhood.create',compact('assets','menu','business_type','taxregimen','zipcode'));
	}



	public function edit(Neighbourhood $neighbourhood ){
                if(!Entrust::can('edit-company'))
                return view('global.error',['message' => trans('messages.permission_denied')]);
		$custom_field_values = getCustomFieldValues($this->form,$neighbourhood->id);
                $neighbourhood=array();
                $taxregimen= Taxregimen::pluck('tax_regimen_name', 'tr_id');
		$business_type=array('1'=>'Individual','2'=>'Company');
		return view('neighbourhood.edit',compact('neighbourhood','custom_field_values','business_type','taxregimen','neighbourhood'));
	}


public function store_view(Neighbourhood $neighbourhood )
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

               
		$assets = ['datatable'];
		$menu = 'neighbourhood_add';
		return view('neighbourhood.store',compact('assets','menu','business_type','taxregimen'));

}


	public function store(NeighbourhoodRequest $request, Neighbourhood $neighbourhood ){	

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

		$neighbourhood->fill($data)->save();
		storeCustomField($this->form,$neighbourhood->id, $data);



		$this->logActivity(['module' => 'neighbourhood','module_id' => $neighbourhood->id,'activity' => 'added']);

        return response()->json(['message' => trans('messages.neighbourhood').' '.trans('messages.added'), 'status' => 'success']);
return view('neighbourhood.edit');
	}

	public function update(NeighbourhoodRequest $request, Neighbourhood $neighbourhood ){

		if(!Entrust::can('edit-company'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

		$data = $request->all();
		$neighbourhood->fill($data)->save();

		$this->logActivity(['module' => 'neighbourhood','module_id' => $neighbourhood->id,'activity' => 'updated']);

		updateCustomField($this->form,$neighbourhood->id, $data);
		
        return response()->json(['message' => trans('messages.neighbourhood').' '.trans('messages.updated'), 'status' => 'success']);
	}

	public function destroy(Neighbourhood $neighbourhood ,Request $request){
		if(!Entrust::can('delete-company') || $neighbourhood->is_hidden == 1)
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

		$this->logActivity(['module' => 'company','module_id' => $company->id,'activity' => 'deleted']);

		deleteCustomField($this->form, $neighbourhood->id);
        
        $neighbourhood->delete();
        
        return response()->json(['message' => trans('messages.neighbourhood').' '.trans('messages.deleted'), 'status' => 'success']);
	}




}
?>