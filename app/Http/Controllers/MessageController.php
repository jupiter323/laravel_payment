<?php
namespace App\Http\Controllers;
use Entrust;
use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use Validator;
use App\Message;

Class MessageController extends Controller{
    use BasicController;

	public function __construct()
	{
		$this->middleware('feature_available:enable_message');
	}

	public function validateLiveMessage($type,$value){
		$message = Message::where($type,'=',$value)->where(function($query) {
			$query->where(function($query1){
				$query1->where('from_user_id','=',\Auth::user()->id)
				->where('delete_sender','=','0');
			})->orWhere(function($query2){
				$query2->where('to_user_id','=',\Auth::user()->id)
				->where('delete_receiver','=','0');
			});
		})->first();
		return ($message) ? : 0;
	}

	public function validateDeleteMessage($type,$value){
		$message = Message::where($type,'=',$value)->where(function($query) {
			$query->where(function($query1){
				$query1->where('from_user_id','=',\Auth::user()->id)
				->where('delete_sender','=','1');
			})->orWhere(function($query2){
				$query2->where('to_user_id','=',\Auth::user()->id)
				->where('delete_receiver','=','1');
			});
		})->first();
		return ($message) ? : 0;
	}

	public function index(){

		$table_data['inbox-table'] = array(
			'source' => 'message/inbox',
			'title' => 'Inbox',
			'id' => 'inbox_table',
			'data' => array(
        		trans('messages.option'),
        		trans('messages.from'),
        		trans('messages.subject'),
        		trans('messages.date_time'),
        		''
        		)
			);

		$table_data['sent-table'] = array(
			'source' => 'message/sent',
			'title' => 'Sent',
			'id' => 'sent_table',
			'data' => array(
        		trans('messages.option'),
        		trans('messages.to'),
        		trans('messages.subject'),
        		trans('messages.date_time'),
        		''
        		)
			);

		$table_data['starred-table'] = array(
			'source' => 'message/starred',
			'title' => 'Starred',
			'id' => 'starred_table',
			'data' => array(
        		trans('messages.option'),
        		'',
        		trans('messages.subject'),
        		trans('messages.date_time'),
        		''
        		)
			);

		$table_data['trash-table'] = array(
			'source' => 'message/trash',
			'title' => 'Trash',
			'id' => 'trash_table',
			'data' => array(
        		trans('messages.option'),
        		'',
        		trans('messages.subject'),
        		trans('messages.date_time'),
        		''
        		)
			);

		$users = \App\User::whereHas('roles',function($query){
			$query->where('name','!=',config('constant.default_customer_role'));
		})->where('id','!=',\Auth::user()->id)->get()->pluck('name_with_designation_and_department','id')->all();
		$messages = Message::whereToUserId(\Auth::user()->id)
			->whereDeleteReceiver('0')->whereIsRead(0)
			->get();
        $count_inbox = count($messages);

        $assets = ['summernote','datatable'];
        $menu = 'message';

		return view('message.index',compact('users','count_inbox','assets','menu','table_data'));
	}

	public function starred(Request $request){

		$message = $this->validateLiveMessage('token',$request->input('token'));

		if(!$message)
	        return response()->json(['message' => trans('messages.invalid_link'), 'status' => 'error']);

		if(\Auth::user()->id == $message->from_user_id)
			$message->is_starred_sender = ($message->is_starred_sender) ? 0 : 1;
		else
			$message->is_starred_receiver = ($message->is_starred_receiver) ? 0 : 1;
		$message->save();

        return response()->json(['status' => 'success']);
	}

	public function lists($type,Request $request){

		if($type == 'inbox')
			$inbox_message = Message::whereToUserId(\Auth::user()->id)
				->select(\DB::raw('reply_id'))
				->whereDeleteReceiver(0)
				->whereNotNull('reply_id')
				->groupBy('reply_id')
				->get()
				->pluck('reply_id')
				->all();
		elseif($type == 'sent')
			$sent_message = Message::whereFromUserId(\Auth::user()->id)
				->select(\DB::raw('reply_id'))
				->whereDeleteSender(0)
				->whereNotNull('reply_id')
				->groupBy('reply_id')
				->get()
				->pluck('reply_id')
				->all();

		if($type == 'sent')
			$messages = Message::where(function($query) use($sent_message){
				$query->where(function($query1) use($sent_message){
					$query1->where('from_user_id','=',\Auth::user()->id)
					->where('delete_sender','=','0')
					->whereNull('reply_id');
				})->orWhereIn('id',$sent_message);
			})->orderBy('created_at','desc')->get();
		elseif($type == 'inbox')
			$messages = Message::where(function($query) use($inbox_message){
				$query->where(function($query1) use($inbox_message){
					$query1->where('to_user_id','=',\Auth::user()->id)
					->where('delete_receiver','=','0')
					->whereNull('reply_id');
				})->orWhereIn('id',$inbox_message);
			})->orderBy('created_at','desc')->get();
		elseif($type == 'starred')
			$messages = Message::where(function($query){
				$query->where(function($query1){
					$query1->where('from_user_id','=',\Auth::user()->id)
					->where('delete_sender','=',0)
					->where('is_starred_sender','=',1);
				})->orWhere(function($query2){
					$query2->where('to_user_id','=',\Auth::user()->id)
					->where('delete_receiver','=',0)
					->where('is_starred_receiver','=',1);
				});
			})->orderBy('created_at','desc')->get();
		elseif($type == 'trash')
			$messages = Message::where(function($query){
				$query->where(function($query1){
					$query1->where('from_user_id','=',\Auth::user()->id)
					->where('delete_sender','=',1);
				})->orWhere(function($query2){
					$query2->where('to_user_id','=',\Auth::user()->id)
					->where('delete_receiver','=',1);
				});
			})->orderBy('created_at','desc')->get();

        $rows=array();
        foreach($messages as $message){

        	$starred = 0;
			if(\Auth::user()->id == $message->from_user_id)
				$starred = ($message->is_starred_sender) ? 1 : 0;
			else
				$starred = ($message->is_starred_receiver) ? 1 : 0;

			$option = (($type != 'trash') ? '<div class="btn-group btn-group-xs"><a href="/message/'.$message->token.'" class="btn btn-default btn-xs" data-toggle="tooltip" title="'.trans('messages.view').'"> <i class="fa fa-arrow-circle-right"></i></a>' : '').
				(($type != 'trash') ? '<a href="#" data-source="/message/starred" data-extra="&token='.$message->token.'" class="btn btn-default btn-xs" data-ajax="1"> <i class="fa fa-'.($starred ? 'star starred' : 'star-o').'"></i></a>' : '').
				(($type == 'trash') ? '<a href="#" data-source="/message/restore" data-extra="&token='.$message->token.'" class="btn btn-default btn-xs" data-ajax="1"> <i class="fa fa-retweet" data-toggle="tooltip" data-title="'.trans('messages.restore').'"></i></a>' : '').
				(($type != 'trash') ? delete_form(['message.trash',$message->id]) : delete_form(['message.destroy',$message->id])).'</div>';

				$source = (\Auth::user()->id == $message->from_user_id) ? $message->UserTo->full_name : $message->UserFrom->full_name;

				if($type == 'starred' || $type == 'trash')
					$source .= (\Auth::user()->id == $message->from_user_id) ? ' <span class="label label-success">Sent</span>' : ' <span class="label label-info">Inbox</span>';

				$unread = 0;
				if($type == 'inbox' && ((!$message->is_read && $message->to_user_id == \Auth::user()->id) || ($message->Replies->where('to_user_id','=',\Auth::user()->id)->where('is_read','=',0)->count())))
					$unread = 1;

				if($message->Replies->count() && ($type == 'inbox' || $type == 'sent'))
					$source .= ' ('.(($message->Replies->where('to_user_id','=',\Auth::user()->id)->where('delete_receiver','=',0)->count())+($message->Replies->where('from_user_id','=',\Auth::user()->id)->where('delete_sender','=',0)->count())+1).')';

				if($type == 'trash' && $message->reply_id != null && (($message->Reply->to_user_id == \Auth::user()->id && $message->Reply->delete_receiver == 1) || ($message->Reply->from_user_id == \Auth::user()->id && $message->Reply->delete_sender == 1)))
					$show = 0;
				else
					$show = 1;

				if($show)
					$rows[] = array('<div class="btn-group btn-group-xs">'.$option.'</div>', 
						($unread) ? ('<strong>'.$source.'</strong>') : $source,
						($unread) ? ('<strong>'.$message->subject.'</strong>') : $message->subject,
						($unread) ? ('<strong>'.showDateTime($message->created_at).'</strong>') : showDateTime($message->created_at),
						($message->attachments != '') ? '<i class="fa fa-paperclip"></i>' : ''
					);	
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function forward($token){

		$message = $this->validateLiveMessage('token',$token);

		if(!$message)
            return view('global.error',['message' => trans('messages.permission_denied')]);

        \App\Upload::whereModule('message')->whereModuleId($message->id)->whereStatus(1)->update(['is_temp_delete' => 0]);

        $uploads = \App\Upload::whereModule('message')->whereModuleId($message->id)->whereStatus(1)->get();

		$users = \App\User::whereHas('roles',function($query){
			$query->where('name','!=',config('constant.default_customer_role'));
		})->where('id','!=',\Auth::user()->id)->get()->pluck('full_name','id')->all();
		return view('message.forward',compact('message','users','uploads'));
	}

	public function postForward(Request $request, $token){

		$message = $this->validateLiveMessage('token',$token);

		if(!$message)
            return response()->json(['message' => trans('messages.invalid_link'), 'status' => 'error']);

        $validation = Validator::make($request->all(),[
            'to_user_id' => 'required',
            'subject' => 'required'
        ]);
        $friendly_name = array('to_user_id' => 'receiver');
        $validation->setAttributeNames($friendly_name); 

        if($validation->fails())
            return response()->json(['message' => $validation->messages()->first(), 'status' => 'error']);

        $existing_upload = \App\Upload::whereModule('message')->whereModuleId($message->id)->whereIsTempDelete(0)->count();

        $new_upload_count = 0;
        foreach($request->input('upload_key') as $upload_key)
            $new_upload_count += \App\Upload::whereModule('message')->whereUploadKey($upload_key)->count();

        if($existing_upload + $new_upload_count > config('constant.max_file_allowed.message'))
            return response()->json(['message' => trans('messages.max_file_allowed',['attribute' => config('constant.max_file_allowed.message')]),'status' => 'error']);

        $new_message = new Message;
        $new_message->subject = $request->input('subject');
        $new_message->body = clean($request->input('body'),'custom');
        $new_message->attachments = $message->attachments;
        $new_message->to_user_id = $request->input('to_user_id');
        $new_message->from_user_id = \Auth::user()->id;
        $new_message->token = randomString(30);
        $new_message->attachments = ($existing_upload + $new_upload_count) ? 1 : 0;
        $new_message->save();

        $existing_uploads = \App\Upload::whereModule('message')->whereModuleId($message->id)->whereStatus(1)->whereIsTempDelete(0)->get();
        foreach($existing_uploads as $existing_upload){
        	$new_upload_key = randomString(40);
        	$new_upload = new \App\Upload;
    		$new_upload->user_id = \Auth::user()->id;
    		$new_upload->module = 'message';
    		$new_upload->user_filename = $existing_upload->user_filename;
    		$upload_attachment = explode('.',$existing_upload->attachments);
    		$new_upload->attachments = str_random(50).'.'.$upload_attachment[1];
    		$new_upload->module_id = $new_message->id;
    		$new_upload->upload_key = $new_upload_key;
    		$new_upload->status = 1;
    		$new_upload->save();
    		\Storage::copy('attachments/'.$existing_upload->attachments, 'attachments/'.$new_upload->attachments);
        }

        foreach($request->input('upload_key') as $upload_key){
            $uploads = \App\Upload::whereModule('message')->whereUploadKey($upload_key)->get();
            $new_upload_key = randomString(40);
            foreach($uploads as $upload){
                $upload->module_id = $new_message->id;
                $upload->status = 1;
                $upload->save();
                \Storage::move('temp_attachments/'.$upload->attachments, 'attachments/'.$upload->attachments);
            }
        }

        \App\Upload::whereModule('message')->whereModuleId($message->id)->whereStatus(1)->whereIsTempDelete(1)->update(['is_temp_delete' => 0]);

        $this->logActivity(['module' => 'message','module_id' => $new_message->id,'activity' => 'forwarded']);

        return response()->json(['message' => trans('messages.message').' '.trans('messages.sent'), 'status' => 'success']);
	}

	public function load(Request $request){

		$message = $this->validateLiveMessage('token',$request->input('token'));

		if($message){
			$replies = Message::where('reply_id','=',$message->id)->where(function($query){
				$query->where(function($query1){
					$query1->where('to_user_id','=',\Auth::user()->id)->where('delete_receiver','=','0');
				})->orWhere(function($query2){
					$query2->where('from_user_id','=',\Auth::user()->id)->where('delete_sender','=','0');
				});
			})->get();
    		return view('message.load',compact('message','replies'))->render();
		}
	}

	public function reply($id,Request $request){

		$message = $this->validateLiveMessage('id',$id);

		if(!$message)
            return response()->json(['message' => trans('messages.invalid_link'), 'status' => 'error']);

        $file_uploaded_count = \App\Upload::whereIn('upload_key',$request->input('upload_key'))->count();

        if($file_uploaded_count > config('constant.max_file_allowed.message'))
        	return response()->json(['message' => trans('messages.max_file_allowed',['attribute' => config('constant.max_file_allowed.message')]),'status' => 'error']);

		$data = $request->all();

		$reply = new Message;
	    $reply->fill($data);
	    $reply->token = randomString(30);
		$reply->subject = 'Re: '.$message->subject;
		$reply->body = clean($request->input('body'),'custom');
		$reply->from_user_id = \Auth::user()->id;
	    $reply->reply_id = $message->id;
	    $reply->attachments = ($file_uploaded_count) ? 1 : 0;
	    $reply->is_read = 0;
		$reply->to_user_id = ($message->from_user_id == \Auth::user()->id) ? $message->to_user_id : $message->from_user_id;
		$reply->save();

	    foreach($request->input('upload_key') as $upload_key){
	    	$uploads = \App\Upload::whereModule('message')->whereUploadKey($upload_key)->get();
	    	foreach($uploads as $upload){
                $upload->module_id = $reply->id;
                $upload->status = 1;
                $upload->save();
                \Storage::move('temp_attachments/'.$upload->attachments, 'attachments/'.$upload->attachments);
	    	}
	    }

        $this->logActivity(['module' => 'message','module_id' => $reply->id,'activity' => 'replied']);
	    
        return response()->json(['message' => trans('messages.message').' '.trans('messages.sent'), 'status' => 'success']);
	}

	public function store(MessageRequest $request){

        $file_uploaded_count = \App\Upload::whereIn('upload_key',$request->input('upload_key'))->count();

        if($file_uploaded_count > config('constant.max_file_allowed.message'))
        	return response()->json(['message' => trans('messages.max_file_allowed',['attribute' => config('constant.max_file_allowed.message')]),'status' => 'error']);

		$data = $request->all();

		$message = new Message;
	    $message->fill($data);
	    $message->token = randomString(30);
	    $message->body = clean($request->input('body'),'custom');
	    $message->from_user_id = \Auth::user()->id;
	    $message->is_read = 0;
	    $message->attachments = ($file_uploaded_count) ? 1 : 0;
		$message->save();

	    foreach($request->input('upload_key') as $upload_key){
	    	$uploads = \App\Upload::whereModule('message')->whereUploadKey($upload_key)->get();
	    	foreach($uploads as $upload){
                $upload->module_id = $message->id;
                $upload->status = 1;
                $upload->save();
                \Storage::move('temp_attachments/'.$upload->attachments, 'attachments/'.$upload->attachments);
	    	}
	    }

		$this->logActivity(['module' => 'message','module_id' => $message->id,'activity' => 'sent']);

        return response()->json(['message' => trans('messages.message').' '.trans('messages.sent'), 'status' => 'success']);
	}

    public function download($file){
        $upload = \App\Upload::whereAttachments($file)->whereModule('message')->whereStatus(1)->first();

        if(!$upload)
            return redirect('/message')->withErrors(trans('messages.invalid_link'));

        $message = Message::find($upload->module_id);

        if(!$message)
            return redirect('/message')->withErrors(trans('messages.invalid_link'));

        if($message->to_user_id != \Auth::user()->id && $message->from_user_id != \Auth::user()->id)
            return redirect('/message')->withErrors(trans('messages.permission_denied'));

        if(!\Storage::exists('attachments/'.$upload->attachments))
            return redirect('/message')->withErrors(trans('messages.file_not_found'));

        $download_path = storage_path().config('constant.storage_root').'attachments/'.$upload->attachments;

        return response()->download($download_path, $upload->user_filename);
    }

	public function view($token){

		$message = $this->validateLiveMessage('token',$token);

		if(!$message)
			return redirect('/message')->withErrors(trans('messages.invalid_link'));	

		if($message->Replies->count())
			Message::where('reply_id','=',$message->id)->where('to_user_id','=',\Auth::user()->id)->update(['is_read' => 1]);

		if($message->reply)
			return redirect('/message/'.$message->Reply->token);

		if(\Auth::user()->id == $message->to_user_id){
			$message->is_read = 1;
			$message->save();
		}

		$assets = ['summernote'];

		return view('message.view',compact('message','assets'));
	}

	public function trash($id,Request $request){

		$message = $this->validateLiveMessage('id',$id);

		if(!$message)
        	return response()->json(['message' => trans('messages.invalid_link'), 'status' => 'error']);

		$this->logActivity(['module' => 'message','module_id' => $message->id,'activity' => 'trashed']);

		if($message->to_user_id == \Auth::user()->id)
			$message->delete_receiver = 1;
		else
			$message->delete_sender = 1;	
		$message->save();

		if($message->Replies->count()){
			$sender_messages = $message->Replies->where('from_user_id','=',\Auth::user()->id)->pluck('id');
			Message::whereIn('id',$sender_messages)->update(['delete_sender' => 1]);
			$receiver_messages = $message->Replies->where('to_user_id','=',\Auth::user()->id)->pluck('id');
			Message::whereIn('id',$receiver_messages)->update(['delete_receiver' => 1]);
		}

	    return response()->json(['message' => trans('messages.message').' '.trans('messages.trashed'), 'status' => 'success']);
	}

	public function restore(Request $request){

		$message = $this->validateDeleteMessage('token',$request->input('token'));

		if(!$message)
	        return response()->json(['message' => trans('messages.invalid_link'), 'status' => 'error']);

		if($message->reply_id != null && (($message->Reply->to_user_id == \Auth::user()->id && $message->Reply->delete_receiver > 0) || ($message->Reply->from_user_id == \Auth::user()->id && $message->Reply->delete_sender > 0)))
        	return response()->json(['message' => trans('messages.invalid_link'), 'status' => 'error']);

		$this->logActivity(['module' => 'message','module_id' => $message->id,'activity' => 'restored']);

		if($message->to_user_id == \Auth::user()->id)
			$message->delete_receiver = 0;
		else
			$message->delete_sender = 0;	
		$message->save();

		if($message->Replies->count()){
			$sender_messages = $message->Replies->where('from_user_id','=',\Auth::user()->id)->pluck('id');
			Message::whereIn('id',$sender_messages)->update(['delete_sender' => 0]);
			$receiver_messages = $message->Replies->where('to_user_id','=',\Auth::user()->id)->pluck('id');
			Message::whereIn('id',$receiver_messages)->update(['delete_receiver' => 0]);
		}

        return response()->json(['message' => trans('messages.message').' '.trans('messages.restored'), 'status' => 'success']);
	}

	public function destroy($id,Request $request){

		$message = $this->validateDeleteMessage('id',$id);

		if(!$message)
        	return response()->json(['message' => trans('messages.invalid_link'), 'status' => 'error']);

        if(getMode()){
	        $uploads = \App\Upload::whereModule('message')->whereModuleId($message->id)->get();
	        foreach($uploads as $upload)
	            \Storage::delete('attachments/'.$upload->attachments);
	        \App\Upload::whereModule('message')->whereModuleId($message->id)->delete();
	    }
	    
		$this->logActivity(['module' => 'message','module_id' => $message->id,'activity' => 'deleted']);

		if($message->to_user_id == \Auth::user()->id)
			$message->delete_receiver = 2;
		else
			$message->delete_sender = 2;	
		$message->save();

		if($message->Replies->count()){
			$sender_messages = $message->Replies->where('from_user_id','=',\Auth::user()->id)->pluck('id');
			Message::whereIn('id',$sender_messages)->update(['delete_sender' => 2]);
			$receiver_messages = $message->Replies->where('to_user_id','=',\Auth::user()->id)->pluck('id');
			Message::whereIn('id',$receiver_messages)->update(['delete_receiver' => 2]);
		}

        return response()->json(['message' => trans('messages.message').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}