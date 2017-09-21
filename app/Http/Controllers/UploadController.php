<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Entrust;
use App\Upload;

Class UploadController extends Controller{
    use BasicController;

	public function upload(Request $request){

    	$extension = $request->file('file')->extension();

        $size = $request->file('file')->getSize();

    	if(!in_array($extension, explode(',',config('config.allowed_upload_file'))))
    		return response()->json(['error' => trans('messages.file_extension_not_allowed_to_upload')]);

        if($size > config('config.max_file_size_upload')*1024*1024)
            return response()->json(['error' => trans('messages.file_size_greater_than_max_allowed_file_size')]);

        $max_upload = config('constant.max_file_allowed.'.$request->input('module')) ? : 1;

        if(!$request->input('module_id'))
            $existing_upload = Upload::whereModule($request->input('module'))->whereUploadKey($request->input('key'))->whereUserId(\Auth::user()->id)->whereIsTempDelete(0)->count();
        else
        $existing_upload = Upload::where(function($query) use($request) {
            $query->whereModule($request->input('module'))->whereUploadKey($request->input('key'))->whereUserId(\Auth::user()->id);
        })->orWhere(function($query1) use($request){
            $query1->whereModule($request->input('module'))->whereModuleId($request->input('module_id'))->whereIsTempDelete(0);
        })->count();

        if($existing_upload >= $max_upload)
    		return response()->json(['error' => trans('messages.max_file_allowed',['attribute' => $max_upload])]);

        $filename_existing_upload = Upload::whereModule($request->input('module'))->whereUploadKey($request->input('key'))->whereUserId(\Auth::user()->id)->whereUserFilename($request->file('file')->getClientOriginalName())->count();

        if($filename_existing_upload)
            return response()->json(['error' => trans('messages.file_already_uploaded')]);

        if(!getMode())
            return response()->json(['error' => trans('messages.disable_message')]);

    	$filename = str_random(50);
        $file = $request->file('file')->storeAs('temp_attachments',$filename.".".$extension);
	 	$upload = new Upload;
	 	$upload->module = $request->input('module');
	 	$upload->upload_key = $request->input('key');
	 	$upload->attachments = $filename.".".$extension;
        $upload->user_filename = $request->file('file')->getClientOriginalName();
	 	$upload->user_id = \Auth::user()->id;
	 	$upload->save();

	 	return response()->json(['message' => trans('messages.file').' '.trans('messages.uploaded'),'status' => 'success','key' => $upload->upload_key]);
	}

    public function uploadList(Request $request){
        $uploads = Upload::whereModule($request->input('module'))->whereUploadKey($request->input('key'))->whereUserId(\Auth::user()->id)->get();

        if(!$uploads->count())
            return;

        return view('upload.list',compact('uploads'))->render();
    }

    public function uploadDelete(Request $request){
        $upload = Upload::find($request->input('id'));

        if(!$upload)
            return response()->json(['message' => trans('messages.invalid_link'),'status' => 'error']);

        if(!getMode())
            return response()->json(['message' => trans('messages.disable_message'),'status' => 'error']);

        \Storage::delete('temp_attachments/'.$upload->attachments);

        $upload->delete();
        return response()->json(['message' => trans('messages.file').' '.trans('messages.deleted'),'status' => 'success']);
    }

    public function uploadTempDelete(Request $request){
        $upload = Upload::find($request->input('id'));

        if(!$upload)
            return response()->json(['message' => trans('messages.invalid_link'),'status' => 'error']);

        if(!getMode())
            return response()->json(['message' => trans('messages.disable_message'),'status' => 'error']);

        $upload->is_temp_delete = 1;
        $upload->save();
        return response()->json(['message' => trans('messages.file').' '.trans('messages.deleted'),'status' => 'success']);
    }
}