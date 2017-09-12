<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\CampaignRequest;
use Entrust;
use App\Campaign;
use App\Jobs\ProcessCampaign;

Class CampaignController extends Controller{
    use BasicController;

	protected $form = 'campaign-form';

	public function index(Campaign $campaign){

		$data = array(
	        		trans('messages.option'),
	        		trans('messages.subject'),
	        		trans('messages.sender'),
	        		trans('messages.recipients'),
	        		trans('messages.staff'),
	        		trans('messages.date')
        		);

		$data = putCustomHeads($this->form, $data);

		$table_data['campaign-table'] = array(
				'source' => 'campaign',
				'title' => 'Campaign List',
				'id' => 'campaign_table',
				'data' => $data
			);

		$body = view('emails.default.default')->render();

		$company_address = $this->getCompanyAddress();
        $body = str_replace('[COMPANY_NAME]',config('config.company_name'),$body); 
        $body = str_replace('[COMPANY_EMAIL]',config('config.company_email'),$body); 
        $body = str_replace('[COMPANY_PHONE]',config('config.company_phone'),$body); 
        $body = str_replace('[COMPANY_WEBSITE]',config('config.company_website'),$body); 
        $body = str_replace('[COMPANY_ADDRESS]',$company_address,$body); 

        $company_logo = getCompanyLogo();
        $body = str_replace('[COMPANY_LOGO]',$company_logo,$body);

		$assets = ['datatable','summernote'];
 $menu='campaign';
		return view('campaign.index',compact('table_data','assets','body','menu'));
	}

	public function lists(Request $request){
		$campaigns = Campaign::all();
        $col_ids = getCustomColId($this->form);
        $values = fetchCustomValues($this->form);
        $rows = array();

        foreach($campaigns as $campaign){

        	$recipient_count = count(explode(',',$campaign->recipients));

			$row = array(
				'<div class="btn-group btn-group-xs">'.
				'<a href="#" data-href="/campaign/'.$campaign->id.'" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="'.trans('messages.view').'"></i></a> '.
				delete_form(['campaign.destroy',$campaign->id]).
				'</div>',
				$campaign->subject,
				$campaign->sender,
				$recipient_count,
				$campaign->User->name_with_designation_and_department,
				showDateTime($campaign->created_at)
				);
			$id = $campaign->id;

			foreach($col_ids as $col_id)
				array_push($row,isset($values[$id][$col_id]) ? $values[$id][$col_id] : '');
			$rows[] = $row;
        }
        $list['aaData'] = $rows;
        return json_encode($list);
	}

	public function show(Campaign $campaign){
		return view('campaign.show',compact('campaign'));
	}

	public function store(CampaignRequest $request, Campaign $campaign){	
        if(!getMode())
            return response()->json(['message' => trans('messages.disable_message'), 'status' => 'error']);

		$data = $request->all();

		$inclusion_lists = $request->input('inclusion') ? explode("\n", str_replace("\r", "", $request->input('inclusion'))) : [];
		$exclusion_lists = $request->input('exclusion') ? explode("\n", str_replace("\r", "", $request->input('exclusion'))) : [];

		$inclusion = array();
		foreach($inclusion_lists as $inclusion_list)
			if(filter_var($inclusion_list, FILTER_VALIDATE_EMAIL))
				$inclusion[] = $inclusion_list;

		$exclusion = array();
		foreach($exclusion_lists as $exclusion_list)
			if(filter_var($exclusion_list, FILTER_VALIDATE_EMAIL))
				$exclusion[] = $exclusion_list;

		if($request->input('audience') == 'customer')
			$contacts = \App\User::whereHas('roles',function($query){
				$query->where('name',config('constant.default_customer_role'));
			})->get()->pluck('email')->all();
		elseif($request->input('audience') == 'staff')
			$contacts = \App\User::whereHas('roles',function($query){
				$query->where('name','!=',config('constant.default_customer_role'));
			})->get()->pluck('email')->all();
		else
			$contacts = \App\User::all()->pluck('email')->all();

		$all_contacts = array_merge($contacts,$inclusion);
		$all_contacts = array_unique($all_contacts);
		$all_contacts = array_diff($all_contacts,$exclusion);

     	if ($request->hasFile('attachments') && getMode()) {
     		$filename = uniqid();
	 		$extension = $request->file('attachments')->getClientOriginalExtension();
	 		$file = $request->file('attachments')->move(config('constant.upload_path.attachments'), $filename.".".$extension);
	 		$campaign->attachments = $filename.".".$extension;
		}
		$campaign->subject = $request->input('subject');
		$campaign->sender = $request->input('sender');
		$campaign->body = clean($request->input('body'),'custom');
		$campaign->recipients = implode(',',$all_contacts);
		$campaign->audience = $request->input('audience');
		$campaign->inclusion = implode(',',$inclusion);
		$campaign->exclusion = implode(',',$exclusion);
		$campaign->user_id = \Auth::user()->id;
		$campaign->save();
		storeCustomField($this->form,$campaign->id, $data);
		dispatch(new ProcessCampaign($campaign->id));

		$this->logActivity(['module' => 'campaign','module_id' => $campaign->id,'activity' => 'added']);

        return response()->json(['message' => trans('messages.campaign').' '.trans('messages.added'),'status' => 'success']);
	}

	public function destroy(Campaign $campaign,Request $request){

		$this->logActivity(['module' => 'campaign','module_id' => $campaign->id,'activity' => 'deleted']);

		deleteCustomField($this->form, $campaign->id);
        
        $campaign->delete();
        
        return response()->json(['message' => trans('messages.campaign').' '.trans('messages.deleted'), 'status' => 'success']);
	}
}