<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Entrust;
use File;

Class UserUploadController extends Controller{
    use BasicController;

	public function index(){

		if(!Entrust::can('upload-customer'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

        $data = array(
        		trans('messages.option'),
        		trans('messages.staff'),
        		trans('messages.total'),
        		trans('messages.upload'),
        		trans('messages.upload_rejected'),
        		trans('messages.date')
        		);

        $menu = 'customer';
        $table_data['user-upload-table'] = array(
			'source' => 'customer-upload',
			'title' => 'User Upload List',
			'id' => 'user_upload',
			'data' => $data
		);
		$assets = ['datatable'];

		return view('user_upload.index',compact('table_data','menu','assets'));
	}

	public function showFails($id){
		$user_upload = \App\UserUpload::find($id);

		if(!$user_upload)
            return view('global.error',['message' => trans('messages.permission_denied')]);

		$user_upload_fails = \App\UserUploadFail::whereUserUploadId($id)->get();

		return view('user_upload.show',compact('user_upload','user_upload_fails'));
	}

	public function lists(Request $request){

		$user_uploads = \App\UserUpload::all();
        $rows=array();

        foreach($user_uploads as $user_upload){
			$rows[] = array(
					'<div class="btn-group btn-group-xs">
					<a href="#" data-href="/customer-upload-log/'.$user_upload->id.'" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="'.trans('messages.view').'"></i></a>'.
					'<a href="/customer-upload-log/'.$user_upload->id.'/download" class="btn btn-default btn-xs" data-toggle="tooltip" title="'.trans('messages.download').'"> <i class="fa fa-download"></i></a>'.
					delete_form(['user-upload.destroy',$user_upload->id]).
					'</div>',
					$user_upload->User->name_with_designation_and_department,
					$user_upload->total,
					$user_upload->uploaded,
					(($user_upload->rejected) ? '<a href="#" data-href="/customer-upload-log/'.$user_upload->id.'" data-toggle="modal" data-target="#myModal">'.$user_upload->rejected.'</a>' : $user_upload->rejected),
					showDate($user_upload->created_at)
					);	
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function download($id){
		if(!Entrust::can('upload-user'))
			return redirect('/home')->withErrors(trans('messages.permission_denied'));

		$user_upload = \App\UserUpload::find($id);

		if(!$user_upload)
			return redirect('/home')->withErrors(trans('messages.invalid_link'));

		$file = config('constant.upload_path.user').$user_upload->filename;

		if(File::exists($file))
			return response()->download($file);
		else
			return redirect()->back()->withErrors(trans('messages.file_not_found'));
	}

	public function destroy($id,Request $request){

		$user_upload = \App\UserUpload::find($id);

		if(!$user_upload)
            return response()->json(['message' => trans('messages.permission_denied'), 'status' => 'error']);

		$this->logActivity(['module' => 'user','module_id' => $user_upload->id,'activity' => 'deleted']);

        $user_upload->delete();

        return response()->json(['message' => trans('messages.user').' '.trans('messages.upload').' '.trans('messages.log').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}