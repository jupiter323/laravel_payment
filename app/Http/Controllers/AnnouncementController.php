<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\AnnouncementRequest;
use Entrust;
use App\Announcement;

Class AnnouncementController extends Controller{
    use BasicController;

	protected $form = 'announcement-form';

	public function index(Announcement $announcement){

		if(!Entrust::can('list-announcement'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

        $data = array(
        		trans('messages.option'),
        		trans('messages.audience'),
        		trans('messages.title'),
        		trans('messages.designation'),
        		trans('messages.from').' '.trans('messages.date'),
        		trans('messages.to').' '.trans('messages.date'),
        		trans('messages.by')
        		);

        $data = putCustomHeads($this->form, $data);
        $menu = 'announcement';
        $table_data['announcement-table'] = array(
			'source' => 'announcement',
			'title' => 'Announcement List',
			'id' => 'announcement_table',
			'data' => $data
		);

        if(Entrust::can('manage-all-designation')){
        	$designations = \App\Designation::all()->pluck('designation_with_department','id')->all();
        }
        elseif(Entrust::can('manage-subordinate-designation'))
        	$designations = childDesignation(\Auth::user()->Profile->designation_id);
        else
        	$designations = [];
        $assets = ['summernote','datatable'];

		return view('announcement.index',compact('table_data','menu','designations','assets'));
	}

	public function lists(Request $request){

		if(Entrust::can('manage-all-designation'))
			$announcements = Announcement::all();
		elseif(Entrust::can('manage-subordinate-designation'))
			$announcements = Announcement::with('designation')->whereHas('designation', function($q) {
	            $q->whereIn('designation_id',getDesignation(\Auth::user(),1));
	        })->get();
		else
			$announcements = Announcement::with('designation')->whereHas('designation',function($q) {
				$q->whereDesignationId(\Auth::user()->Profile->designation_id);
			})->get();

        $rows=array();
        $col_ids = getCustomColId($this->form);
        $values = fetchCustomValues($this->form);

        foreach($announcements as $announcement){

        	if($announcement->belongsToMany('App\Designation','announcement_designation')->count()){
	        	$designation_name = "<ol class='nl'>";
	        	foreach($announcement->Designation as $designation)
				    $designation_name .= "<li>$designation->designation_with_department</li>";
	        	$designation_name .= "</ol>";
        	} else
        		$designation_name = trans('messages.all');

			$row = array(
				'<div class="btn-group btn-group-xs">'.
				((Entrust::can('edit-announcement') && $this->announcementAccessible($announcement)) ? '<a href="#" data-href="announcement/'.$announcement->id.'/edit" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="'.trans('messages.edit').'"></i></a> ' : '').
				((Entrust::can('delete-announcement') && $this->announcementAccessible($announcement)) ? delete_form(['announcement.destroy',$announcement->id]) : '').
				'</div>',
				($announcement->audience) ? trans('messages.staff') : trans('messages.customer'),
				$announcement->title,
				($announcement->audience) ? $designation_name : '',
				showDate($announcement->from_date),
				showDate($announcement->to_date),
				$announcement->User->full_name
				);	
			$id = $announcement->id;

			foreach($col_ids as $col_id)
				array_push($row,isset($values[$id][$col_id]) ? $values[$id][$col_id] : '');
        	$rows[] = $row;
			
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function show(Announcement $announcement){

        $uploads = \App\Upload::whereModule('announcement')->whereModuleId($announcement->id)->whereStatus(1)->get();
		return view('announcement.show',compact('announcement','uploads'));
	}

    public function download($file){
        $upload = \App\Upload::whereAttachments($file)->whereModule('announcement')->whereStatus(1)->first();

        if(!$upload)
            return redirect('/announcement')->withErrors(trans('messages.invalid_link'));

        $announcement = Announcement::find($upload->module_id);

        if(!$announcement)
            return redirect('/announcement')->withErrors(trans('messages.invalid_link'));

        if(!\Storage::exists('attachments/'.$upload->attachments))
            return redirect('/announcement')->withErrors(trans('messages.file_not_found'));

        $download_path = storage_path().config('constant.storage_root').'attachments/'.$upload->attachments;

        return response()->download($download_path, $upload->user_filename);
    }

	public function create(){

		if(!Entrust::can('create-announcement'))
            return view('global.error',['message' => trans('messages.permission_denied')]);

        if(Entrust::can('manage-all-designation'))
        	$designations = \App\Designation::all()->pluck('designation_with_department','id')->all();
        elseif(Entrust::can('manage-subordinate-designation'))
        	$designations = childDesignation(\Auth::user()->Profile->designation_id);
        else
        	$designation = [];
        $menu = ['announcement'];

		return view('announcement.create',compact('designations','menu'));
	}

	public function edit(Announcement $announcement){

		if(!Entrust::can('edit-announcement') || !$this->announcementAccessible($announcement))
            return view('global.error',['message' => trans('messages.permission_denied')]);

		$selected_designation = array();

		foreach($announcement->Designation as $designation){
			$selected_designation[] = $designation->id;
		}

        if(Entrust::can('manage-all-designation'))
        	$designations = \App\Designation::all()->pluck('designation_with_department','id')->all();
        elseif(Entrust::can('manage-subordinate-designation'))
    		$designations = childDesignation($announcement->User->Profile->designation_id);
        else
        	$designation = [];

        \App\Upload::whereModule('announcement')->whereModuleId($announcement->id)->whereStatus(1)->update(['is_temp_delete' => 0]);
        $uploads = \App\Upload::whereModule('announcement')->whereModuleId($announcement->id)->whereStatus(1)->get();

		$custom_field_values = getCustomFieldValues($this->form,$announcement->id);
        $menu = ['announcement'];

		return view('announcement.edit',compact('designations','announcement','selected_designation','custom_field_values','menu','uploads'));
	}

	public function store(AnnouncementRequest $request, Announcement $announcement){

		if(!Entrust::can('create-announcement'))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        $validation = validateCustomField($this->form,$request);
        
        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        $file_uploaded_count = \App\Upload::whereIn('upload_key',$request->input('upload_key'))->count();

        if($file_uploaded_count > config('constant.max_file_allowed.announcement'))
        	return response()->json(['message' => trans('messages.max_file_allowed',['attribute' => config('constant.max_file_allowed.announcement')]),'status' => 'error']);

		$child_designations = childDesignation(\Auth::user()->Profile->designation_id,1);
		array_push($child_designations, \Auth::user()->Profile->designation_id);
		$data = $request->all();
	    $announcement->fill($data);
	    $announcement->description = clean($request->input('description'),'custom');
		$announcement->user_id = \Auth::user()->id;
		$announcement->save();
		if($request->input('audience')){
			$designations = ($request->input('designation_id')) ? : $child_designations;
	    	$announcement->designation()->sync($designations);
		}
		storeCustomField($this->form,$announcement->id, $data);

	    foreach($request->input('upload_key') as $upload_key){
	    	$uploads = \App\Upload::whereModule('announcement')->whereUploadKey($upload_key)->get();
	    	foreach($uploads as $upload){
                $upload->module_id = $announcement->id;
                $upload->status = 1;
                $upload->save();
                \Storage::move('temp_attachments/'.$upload->attachments, 'attachments/'.$upload->attachments);
	    	}
	    }

		$this->logActivity(['module' => 'announcement','module_id' => $announcement->id,'activity' => 'added']);

        return response()->json(['message' => trans('messages.announcement').' '.trans('messages.added'), 'status' => 'success']);
	}

	public function update(AnnouncementRequest $request, Announcement $announcement){

		if(!Entrust::can('edit-announcement') || !$this->announcementAccessible($announcement))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        $validation = validateCustomField($this->form,$request);
        
        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);
        
        $existing_upload = \App\Upload::whereModule('announcement')->whereModuleId($announcement->id)->whereIsTempDelete(0)->count();

        $new_upload_count = 0;
        foreach($request->input('upload_key') as $upload_key)
            $new_upload_count += \App\Upload::whereModule('announcement')->whereUploadKey($upload_key)->count();

        if($existing_upload + $new_upload_count > config('constant.max_file_allowed.announcement'))
            return response()->json(['message' => trans('messages.max_file_allowed',['attribute' => config('constant.max_file_allowed.announcement')]),'status' => 'error']);

        foreach($request->input('upload_key') as $upload_key){
            $uploads = \App\Upload::whereModule('announcement')->whereUploadKey($upload_key)->get();
            foreach($uploads as $upload){
                $upload->module_id = $announcement->id;
                $upload->status = 1;
                $upload->save();
                \Storage::move('temp_attachments/'.$upload->attachments, 'attachments/'.$upload->attachments);
            }
        }

        $temp_delete_uploads = \App\Upload::whereModule('announcement')->whereModuleId($announcement->id)->whereIsTempDelete(1)->get();
        foreach($temp_delete_uploads as $temp_delete_upload)
            \Storage::delete('attachments/'.$temp_delete_upload->attachments);

        \App\Upload::whereModule('announcement')->whereModuleId($announcement->id)->whereIsTempDelete(1)->delete();

		$child_designations = childDesignation($announcement->User->Profile->designation_id,1);
		array_push($child_designations, \Auth::user()->Profile->designation_id);
		
		$data = $request->all();
		$announcement->fill($data);
	    $announcement->description = clean($request->input('description'),'custom');
		$announcement->save();
		if($request->input('audience')){
			$designations = ($request->input('designation_id')) ? : $child_designations;
	    	$announcement->designation()->sync($designations);
		}
		updateCustomField($this->form,$announcement->id, $data);
		$this->logActivity(['module' => 'announcement','module_id' => $announcement->id,'activity' => 'updated']);
		
        return response()->json(['message' => trans('messages.announcement').' '.trans('messages.updated'), 'status' => 'success']);
	}

	public function destroy(Announcement $announcement,Request $request){

		if(!Entrust::can('delete-announcement') || !$this->announcementAccessible($announcement))
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

        if(getMode()){
            $uploads = \App\Upload::whereModule('announcement')->whereModuleId($announcement->id)->get();
            foreach($uploads as $upload)
                \Storage::delete('attachments/'.$upload->attachments);
            \App\Upload::whereModule('announcement')->whereModuleId($announcement->id)->delete();
        }
        
		$this->logActivity(['module' => 'announcement','module_id' => $announcement->id,'activity' => 'deleted']);
		deleteCustomField($this->form, $announcement->id);
        $announcement->delete();

        return response()->json(['message' => trans('messages.announcement').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}
?>