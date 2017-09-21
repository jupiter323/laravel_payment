<?php
function delete_form($value,$param = array()){
    $name = (array_key_exists('name', $param)) ? $param['name'] : randomString(10);
    $form_option = ['method' => 'DELETE',
        'route' => $value,
        'class' => 'form-inline',
        'id' => $name.'_'.$value[1]
        ];

    $label = (array_key_exists('label', $param)) ? $param['label'] : '';
    $size = (array_key_exists('size', $param)) ? $param['size'] : 'xs';
    if(array_key_exists('redirect', $param))
        $form_option['data-redirect'] = $param['redirect'];
    if(array_key_exists('ajax', $param))
        $form_option['data-submit'] = $param['ajax'];
    if(array_key_exists('table-refresh', $param))
        $form_option['data-table-refresh'] = $param['table-refresh'];
    if(array_key_exists('refresh-content', $param))
        $form_option['data-refresh'] = $param['refresh-content'];

    $alert_message = trans('messages.action_confirm_message');
    if(array_key_exists('alert-message', $param))
        $alert_message = $param['alert-message'];

    $form = Form::open($form_option);
    $form .= Html::decode(Form::button('<i class="fa fa-trash-o"></i> '.$label,['data-toggle' => 'tooltip', 'title' => trans('messages.delete'), 'class' => 'btn btn-danger btn-'.$size, 'data-submit-alert-message' => 'Yes', 'type' => 'submit','data-alert-message' => $alert_message]));
    return $form .= Form::close();
}

function getPaymentGatewayList(){
    $gateways = array();
    if(config('config.enable_paypal_payment'))
        $gateways['paypal'] = 'Paypal';
    if(config('config.enable_stripe_payment'))
        $gateways['stripe'] = 'Stripe';
    if(config('config.enable_tco_payment'))
        $gateways['tco'] = 'Two Checkout';
    if(config('config.enable_payumoney_payment'))
        $gateways['payumoney'] = 'PayUMoney';

    if(config('config.enable_customer_payment'))
        return $gateways;
    else
        return [];
}

function getAmountWithoutDiscount($discounted_amount,$discount){
    return ($discount < 100) ? (($discounted_amount*100)/(100-$discount)) : 0;
}

function validateDate($date)
{
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

function validateCoupon($amount,$currency,$coupon = ''){
    $status = '';
    $coupon_response = '';
    $discount = 0;
    $payable_amount = '';
    if($coupon != ''){
        $coupon = \App\Coupon::whereCode($coupon)->first();

        if($coupon)
            $valid_day = ($coupon->valid_day) ? explode(',',$coupon->valid_day) : [];

        if(!$coupon || $coupon->valid_from > date('Y-m-d')){
            $status = 'error';
            $coupon_response = 'Invalid Coupon';
        }
        elseif($coupon->valid_to < date('Y-m-d')){
            $status = 'error';
            $coupon_response = 'Coupon Expired';
        }
        elseif($coupon->use_count >= $coupon->maximum_use_count){
            $status = 'error';
            $coupon_response = 'Coupon Usage Expired';
        }
        elseif($coupon->valid_day && count($valid_day) && !in_array(strtolower(date('l')),$valid_day)){
            $status = 'error';
            $coupon_days = ($coupon->valid_day) ? explode(',',strtoupper($coupon->valid_day)) : [];
            $coupon_response = 'Valid on '.implode(',',$coupon_days);
        }
        elseif($coupon->new_user && \App\Transaction::whereStatus('success')->whereUserId(\Auth::user()->id)->count() > 1){
            $status = 'error';
            $coupon_response = 'Coupon available for only New User';
        }
        else{
            $status = 'success';
            $coupon_response = 'Congrats! Discount '.round($coupon->discount).'% Coupon applied';
            $discount = $amount*($coupon->discount/100);
            $amount -= $discount;
        }
    }
    
    $payable_amount = ' Payable amount: '.currency($amount,1,$currency->id);
    if($status == 'success')
        $coupon_response = '<span style="color:green;font-weight:bold;">'.$coupon_response.$payable_amount.'</span>';
    else
        $coupon_response = '<span style="color:red;font-weight:bold;">'.$coupon_response.$payable_amount.'</span>';

    $data = array();
    $data['coupon_response'] = $coupon_response;
    $data['coupon'] = ($coupon && $status == 'success') ? $coupon->name : null;
    $data['amount'] = $amount;
    $data['status'] = $status;
    $data['discount'] = ($coupon && $status == 'success') ? $coupon->discount : 0;
    return $data;
}

function decimalValue($decimal){
    return '.'.str_pad(1, $decimal, '0', STR_PAD_LEFT);
}

function getInvoiceNumber($invoice = null){
    $digits = config('config.invoice_number_digit');
    $invoice_start_number = config('config.invoice_start_number');
    if($invoice == null){
        $current_number = (\App\Invoice::max('invoice_number')) ? : 0;
        $number = (($current_number >= $invoice_start_number) ? $current_number + 1 : $invoice_start_number);
    } else
        $number = $invoice->invoice_number;
    $invoice_number = str_pad($number, $digits, '0', STR_PAD_LEFT);
    return $invoice_number;
}

function getQuotationNumber($quotation = null){
    $digits = config('config.quotation_number_digit');
    $quotation_start_number = config('config.quotation_start_number');
    if($quotation == null){
        $current_number = (\App\Quotation::max('quotation_number')) ? : 0;
        $number = (($current_number >= $quotation_start_number) ? $current_number + 1 : $quotation_start_number);
    } else
        $number = $quotation->quotation_number;
    $quotation_number = str_pad($number, $digits, '0', STR_PAD_LEFT);
    return $quotation_number;
}

function getCurrency($currency_id = null){

    if($currency_id)
        $currency = \App\Currency::find($currency_id);
    else
        $currency = \App\Currency::whereIsDefault(1)->first();

    return ($currency) ? : null;
}

function currencyDecimalValue($currency_id = null){
    $currency = getCurrency($currency_id);
    return ($currency) ? '.'.str_pad(1, $currency->decimal_place, '0', STR_PAD_LEFT) : 2;
}

function currency($amount, $symbol = 0, $currency_id = null){

    if($currency_id)
        $currency = \App\Currency::find($currency_id);
    else
        $currency = \App\Currency::whereIsDefault(1)->first();

    $currency_decimal_value = ($currency) ? $currency->decimal_place : 2;
    $amount = round($amount,$currency_decimal_value);

    if(!$symbol || !$currency)
        return $amount;
    
    if($currency->position == 'suffix')
        return $amount.' '.$currency->symbol;
    else
        return $currency->symbol.' '.$amount;
}

function dateDiff($date1,$date2){
    if($date2 > $date1)
        return date_diff(date_create($date1),date_create($date2))->days + 1;
    else
        return date_diff(date_create($date2),date_create($date1))->days + 1;
}

function getDesignation($user, $self = 0){
    if($user->is_hidden)
        return \App\Designation::all()->pluck('id')->all();
    elseif($user->can('manage-all-designation'))
        return \App\Designation::whereIsHidden(0)->get()->pluck('id')->all();
    elseif($user->can('manage-subordinate-designation')){
        $childs = childDesignation($user->Profile->designation_id,1);
        if($self)
            array_push($childs, $user->Profile->designation_id);
        return $childs;
    } else
        return ($self) ? \App\Designation::whereId($user->Profile->designation_id)->pluck('id')->all() : [];
}

function getAccessibleUser($user_id = null,$self = 0){
    if(!$user_id)
        $user_id = \Auth::user()->id;

    $user = \App\User::find($user_id);

    $query = \App\User::with('profile')->whereHas('profile',function($qry) use($user,$self){
        $qry->whereIn('designation_id',getDesignation($user,$self));
    });

    return $query;
}

function getAccessibleUserList($user_id = null, $self = 0){
    $query = getAccessibleUser($user_id,$self);
    return $query->get()->pluck('id')->all();
}

function createLineTreeView($array, $currentParent = 1, $currLevel = 0, $prevLevel = -1) {
    foreach ($array as $categoryId => $category) {
    if ($currentParent == $category['parent_id']) {                       
        if ($currLevel > $prevLevel) echo " <ul class='tree'> "; 
        if ($currLevel == $prevLevel) echo " </li> ";
        
            echo '<li>'.$category['name'];

        if ($currLevel > $prevLevel) { $prevLevel = $currLevel; }
        $currLevel++; 
        createLineTreeView ($array, $categoryId, $currLevel, $prevLevel);
        $currLevel--;               
        }   
    }
    if ($currLevel == $prevLevel) echo " </li>  </ul> ";
}

function getChilds($array, $currentParent = 1, $id = 0, $currLevel = 0, $prevLevel = -1) {
    STATIC $child = array();
    foreach ($array as $categoryId => $category) {
    if ($currentParent == $category['parent_id']) {  
        if ($currLevel > $prevLevel){} 
        if ($currLevel == $prevLevel){}
        if($id == 0)
            $child[$categoryId] = $category['name'];
        else
            $child[] = $categoryId;
        if ($currLevel > $prevLevel) { $prevLevel = $currLevel; }
        $currLevel++; 
        getChilds($array, $categoryId, $id, $currLevel, $prevLevel);
        $currLevel--;               
        }   
    }
    if ($currLevel == $prevLevel){}
    return $child;
}

function childDesignation($designation_id = '', $id = 0){
    if($designation_id == '')
        $designation_id = Auth::user()->Profile->designation_id;

    if(!config('config.subordinate_level')){
        return ($id) ? \App\Designation::whereTopDesignationId($designation_id)->get()->pluck('id')->all() :
        \App\Designation::whereTopDesignationId($designation_id)->get()->pluck('designation_with_department','id')->all();
    }

    $tree = array();
    $designations = \App\Designation::whereNotNull('top_designation_id')->get();
    foreach($designations as $designation){
        $tree[$designation->id] = array(
            'parent_id' => $designation->top_designation_id,
            'name' => $designation->designation_with_department
        );
    }
    return getChilds($tree,$designation_id,$id);
}

function getParent($designation_id){
    $designations = \App\Designation::all()->pluck('top_designation_id','id')->all();
    return getParentDesignation($designation_id,$designations);
}

function getParentDesignation($designation_id, $data, $parents=array()) {
    $parent_id = isset($data[$designation_id]) ? $data[$designation_id] : null;
    if ($parent_id != null) {
        $parents[] = $parent_id;
        return getParentDesignation($parent_id, $data, $parents);
    }
    return $parents;
}

function isChild($child_designation_id,$parent_designation_id = ''){
    if($parent_designation_id == '')
        $parent_designation_id = Auth::user()->Profile->designation_id;

    $childs = childDesignation($parent_designation_id, 1);
    if(in_array($child_designation_id,$childs))
        return true;
    else
        return false;
}

function progressColor($progress){
    if($progress <= 20)
        return 'danger';
    elseif($progress>20  && $progress <=50)
        return 'warning';
    elseif($progress>50  && $progress <=75)
        return 'info';
    else
        return 'success';
}

function setupGuide(){

    $url = \Request::path();
    $con = is_numeric(strpos($url, 'configuration'));

    $setup = \App\Setup::orderBy('id','asc')->get();
    $setup_total = 0;
    $setup_completed = 0;
    foreach($setup as $value){
        $setup_total += config('setup.'.$value->module.'.weightage');
        if($value->completed)
            $setup_completed += config('setup.'.$value->module.'.weightage');
    }
    $setup_percentage = ($setup_total) ? round(($setup_completed/$setup_total) * 100) : 0;

    return view('global.setup_guide',compact('setup_percentage','setup','con'))->render();
}

function getCompanyLogo(){
    if(File::exists(config('constant.upload_path.company_logo').config('config.company_logo')) && config('config.company_logo'))
        return '<img src="'.url('/'.config('constant.upload_path.company_logo').config('config.company_logo')).'">';
    else
        return;
}

function menuAvailable($menus,$menu){
    $menu_item = $menus->where('name',$menu)->first();
    return $menu_item->visible;
}

function menuAttr($menus,$menu){
    $menu_item = $menus->where('name',$menu)->first();

    if($menu_item)
        return 'data-position="'.(($menu_item->order == null) ? $menu_item->id : $menu_item->order).'" data-visible="'.$menu_item->visible.'"';
    else
        return '';
}

function setEncryptionKey(){
    if(!env('APP_KEY') || strlen(env('APP_KEY')) != 32)
        envu(['APP_KEY' => randomString(32)]);
}

function backupDatabase(){
    \Storage::makeDirectory('backup');
    try {
        $db_export = \App\Helper\Shuttle_Dumper::create(array(
            'host' => config('database.connections.primary.host'),
            'username' => config('database.connections.primary.username'),
            'password' => config('database.connections.primary.password'),
            'db_name' => config('database.connections.primary.database'),
        ));
        $filename = 'backup_'.date('Y_m_d_H_i_s').'.sql.gz';
        $full_path = storage_path().config('constant.storage_root').'backup/'.$filename;
        $db_export->dump($full_path);
        return ['status' => 'success','filename' => $filename];
    } catch(\App\Helper\Shuttle_Exception $e) {
        $message = $e->getMessage(); 
        return ['status' => 'error'];
    }
}

function getColor(){
    $color = ['warning','danger','success','info','primary'];
    $index=array_rand($color);
    return $color[$index];
}

function showDateTime($time = ''){
    if($time == '')
        return;

    $format = config('config.date_format') ? : 'd-m-Y';
    if(config('config.time_format'))
        return date($format.',h:i a',strtotime($time));
    else
        return date($format.',H:i',strtotime($time));
}

function showDate($date = ''){
    if($date == '' || $date == null)
        return;

    $format = config('config.date_format') ? : 'd-m-Y';
    return date($format,strtotime($date));
}

function ipRange($network, $ip) {
    $network=trim($network);
    $orig_network = $network;
    $ip = trim($ip);
    if ($ip == $network) {
        return TRUE;
    }
    $network = str_replace(' ', '', $network);
    if (strpos($network, '*') !== FALSE) {
        if (strpos($network, '/') !== FALSE) {
            $asParts = explode('/', $network);
            $network = @ $asParts[0];
        }
        $nCount = substr_count($network, '*');
        $network = str_replace('*', '0', $network);
        if ($nCount == 1) {
            $network .= '/24';
        } else if ($nCount == 2) {
            $network .= '/16';
        } else if ($nCount == 3) {
            $network .= '/8';
        } else if ($nCount > 3) {
            return TRUE;
        }
    }

    $d = strpos($network, '-');
    if ($d === FALSE) {
        $ip_arr = explode('/', $network);
        if (!preg_match("@\d*\.\d*\.\d*\.\d*@", $ip_arr[0], $matches)){
            $ip_arr[0].=".0"; 
        }
        $network_long = ip2long($ip_arr[0]);
        $x = ip2long($ip_arr[1]);
        $mask = long2ip($x) == $ip_arr[1] ? $x : (0xffffffff << (32 - $ip_arr[1]));
        $ip_long = ip2long($ip);
        return ($ip_long & $mask) == ($network_long & $mask);
    } else {
        $from = trim(ip2long(substr($network, 0, $d)));
        $to = trim(ip2long(substr($network, $d+1)));
        $ip = ip2long($ip);
        return ($ip>=$from and $ip<=$to);
    }
}

function randomString($length,$type = 'token'){
    if($type == 'password')
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    elseif($type == 'username')
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
    else
         $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $token = substr( str_shuffle( $chars ), 0, $length );
    return $token;
}

function checkDBConnection(){
    $link = @mysqli_connect(config('database.connections.primary.host'), 
        config('database.connections.primary.username'), 
        config('database.connections.primary.password'));

    if($link)
        return mysqli_select_db($link,config('database.connections.primary.database'));
    else
        return false;
}

function setConfig($config_vars){

    foreach($config_vars as $config_var){
        config(['config.'.$config_var->name => (isset($config_var->value) && $config_var->value != '' && $config_var->value != null) ? $config_var->value : config('config.'.$config_var->name)]);
    }

    config([
    'mail.driver' => ($config_vars->where('name','driver')->first()) ? $config_vars->where('name','driver')->first()->value : env('MAIL_DRIVER'),
    'mail.from.address' => ($config_vars->where('name','from_address')->first()) ? $config_vars->where('name','from_address')->first()->value : env('MAIL_FROM_ADDRESS'),
    'mail.from.name' => ($config_vars->where('name','from_name')->first()) ? $config_vars->where('name','from_name')->first()->value : env('MAIL_FROM_NAME'),
    'mail.encryption' => ($config_vars->where('name','encryption')->first()) ? $config_vars->where('name','encryption')->first()->value : null
    ]);

    if(config('mail.driver') == 'smtp'){
        config([
        'mail.host' => ($config_vars->where('name','host')->first()) ? $config_vars->where('name','host')->first()->value : '',
        'mail.port' => ($config_vars->where('name','port')->first()) ? $config_vars->where('name','port')->first()->value : '',
        'mail.username' => ($config_vars->where('name','username')->first()) ? $config_vars->where('name','username')->first()->value : '',
        'mail.password' => ($config_vars->where('name','password')->first()) ? $config_vars->where('name','password')->first()->value : ''
        ]);
    }

    if(config('mail.driver') == 'mailgun'){
        config([
        'mail.host' => ($config_vars->where('name','mailgun_host')->first()) ? $config_vars->where('name','mailgun_host')->first()->value : '',
        'mail.port' => ($config_vars->where('name','mailgun_port')->first()) ? $config_vars->where('name','mailgun_port')->first()->value : '',
        'mail.username' => ($config_vars->where('name','mailgun_username')->first()) ? $config_vars->where('name','mailgun_username')->first()->value : '',
        'mail.password' => ($config_vars->where('name','mailgun_password')->first()) ? $config_vars->where('name','mailgun_password')->first()->value : '',
        'services.mailgun.domain' => ($config_vars->where('name','mailgun_domain')->first()) ? $config_vars->where('name','mailgun_domain')->first()->value : '',
        'services.mailgun.secret' => ($config_vars->where('name','mailgun_secret')->first()) ? $config_vars->where('name','mailgun_secret')->first()->value : '',
        ]);
    }

    if(config('mail.driver') == 'mandrill'){
        config([
            'services.mandrill.secret' => ($config_vars->where('name','mandrill_secret')->first()) ? $config_vars->where('name','mandrill_secret')->first()->value : ''
        ]);
    }  
      
    config([
        'paypal.client_id' => config('config.paypal_client_id'),
        'paypal.secret' => config('config.paypal_secret'),
        'paypal.settings.mode' => config('config.paypal_mode') ? 'live' : 'sandbox'
    ]);     
}

function createSlug($string){
   if(checkUnicode($string))
        $slug = str_replace(' ', '-', $string);
   else
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($string));
   return $slug;
}

function checkUnicode($string)
{
    if(strlen($string) != strlen(utf8_decode($string)))
    return true;
    else
    return false;
}

function toWord($word){
    $word = str_replace('_', ' ', $word);
    $word = str_replace('-', ' ', $word);
    $word = ucwords($word);
    return $word;
}

function getCustomFields($form, $custom_field_values = array()){
    
    $custom_fields = \App\CustomField::whereForm($form)->get();

    echo '<div class="row">';
    foreach($custom_fields as $custom_field){
      
      $c_values = (array_key_exists($custom_field->name, $custom_field_values)) ? $custom_field_values[$custom_field->name] : '';
      $options = explode(',',$custom_field->options);

      $required = '';
      
      echo '<div class="col-md-6"><div class="form-group">';
      echo '<label for="'.$custom_field->name.'">'.$custom_field->title.'</label>';
      
      if($custom_field->type == 'select'){
        echo '<select class="form-control show-tick" placeholder="'.trans('messages.select_one').'" id="'.$custom_field->name.'" name="'.$custom_field->name.'"'.$required.'>
        <option value="">'.trans('messages.select_one').'</option>';
        foreach($options as $option){
            if($option == $c_values)
                echo '<option value="'.$option.'" selected>'.ucfirst($option).'</option>';
            else
                echo '<option value="'.$option.'">'.ucfirst($option).'</option>';
        }
        echo '</select>';
      }
      elseif($custom_field->type == 'radio'){
        echo '<div>
            <div class="radio">';
            foreach($options as $option){
                if($option == $c_values)
                    $checked = "checked";
                else
                    $checked = "";
                echo '<label><input type="radio" name="'.$custom_field->name.'" id="'.$custom_field->name.'" value="'.$option.'" '.$required.' '.$checked.' class="icheck"> '.ucfirst($option).'</label> ';
            }
        echo '</div>
        </div>';
      }
      elseif($custom_field->type == 'checkbox'){
        echo '<div>
            <div class="checkbox">';
            foreach($options as $option){
                if(in_array($option,explode(',',$c_values)))
                    $checked = "checked";
                else
                    $checked = "";
                echo '<label><input type="checkbox" name="'.$custom_field->name.'[]" id="'.$custom_field->name.'" value="'.$option.'" '.$checked.' '.$required.' class="icheck"> '.ucfirst($option).'</label> ';
            }
        echo '</div>
        </div>';
      }
      elseif($custom_field->type == 'textarea')
       echo '<textarea class="form-control" data-limit="'.config('config.textarea_limit').'" placeholder="'.$custom_field->title.'" name="'.$custom_field->name.'" cols="30" rows="3" id="'.$custom_field->name.'"'.$required.' data-show-counter=1 data-autoresize=1>'.$c_values.'</textarea><span class="countdown"></span>';
      else
        echo '<input class="form-control '.(($custom_field->type == 'date') ? 'datepicker' : '').'" value="'.$c_values.'" placeholder="'.$custom_field->title.'" name="'.$custom_field->name.'" type="text" value="" id="'.$custom_field->name.'"'.$required.' '.(($custom_field->type == 'date') ? 'readonly' : '').'>';
      echo '</div></div>';
    }
    echo '</div>';
}

function putCustomHeads($form, $col_heads){
    $custom_fields = \App\CustomField::whereForm($form)->get();
    foreach($custom_fields as $custom_field)
        array_push($col_heads, $custom_field->title);
    return $col_heads;
}

function validateCustomField($form,$request){
    $custom_validation = array();
    $custom_fields = \App\CustomField::whereForm($form)->get();
    $friendly_names = array();
    foreach($custom_fields as $custom_field){
        if($custom_field->is_required){
            $custom_validation[$custom_field->name] = 'required'.(($custom_field->type == 'date') ? '|date' : '').(($custom_field->type == 'number') ? '|numeric' : '').(($custom_field->type == 'email') ? '|email' : '').(($custom_field->type == 'url') ? '|url' : '');
            $friendly_names[$custom_field->name] = $custom_field->title;
        }
   }

   $validation = \Validator::make($request->all(),$custom_validation);
   $validation->setAttributeNames($friendly_names);
   return $validation;
}

function fetchCustomValues($form){
    $rows = \DB::table('custom_fields')
    ->join('custom_field_values','custom_field_values.custom_field_id','=','custom_fields.id')
    ->where('form','=',$form)
    ->select(\DB::raw('unique_id,custom_field_id,value,type'))
    ->get();
    $values = array();
    foreach($rows as $row){
        $field_values = [];
        $value = '';
        if($row->type == 'checkbox'){
            $field_values = explode(',',$row->value);
            $value .= '<ol>';
            foreach($field_values as $fv)
                $value .= '<li>'.toWord($fv).'</li>';
            $value .= '</ol>';
        } else
        $value = toWord($row->value);

        $values[$row->unique_id][$row->custom_field_id] = $value;
    }
    return $values;
}

function getCustomFieldValues($form,$id){
    return \DB::table('custom_fields')
    ->join('custom_field_values','custom_field_values.custom_field_id','=','custom_fields.id')
    ->where('form','=',$form)
    ->where('unique_id','=',$id)
    ->pluck('value','name')->all();
}

function getCustomColId($form){
    return \App\CustomField::whereForm($form)->pluck('id')->all();
}

function storeCustomField($form, $id, $request){
    $custom_fields = \App\CustomField::whereForm($form)->get();
    foreach($custom_fields as $custom_field){
        $custom_field_value = new \App\CustomFieldValue;
        $value = $request[$custom_field->name];
        if(is_array($value))
            $value = implode(',',$value);
        $custom_field_value->value = $value;
        $custom_field_value->custom_field_id = $custom_field->id;
        $custom_field_value->unique_id = $id;
        $custom_field_value->save();
    }
}

function updateCustomField($form, $id, $request){
    $custom_fields = \App\CustomField::whereForm($form)->get();
    foreach($custom_fields as $custom_field){
        $value = array_key_exists($custom_field->name, $request) ? $request[$custom_field->name] : '';

        if(is_array($value))
            $value = implode(',',$value);

        $custom = \DB::table('custom_fields')
            ->join('custom_field_values','custom_field_values.custom_field_id','=','custom_fields.id')
            ->where('form','=',$form)
            ->where('name','=',$custom_field->name)
            ->where('unique_id','=',$id)
            ->select(\DB::raw('custom_field_values.id'))
            ->first();

        if($custom)
            $custom_field_value = \App\CustomFieldValue::find($custom->id);
        else
            $custom_field_value = new \App\CustomFieldValue;
        $custom_field_value->value = $value;
        $custom_field_value->custom_field_id = $custom_field->id;
        $custom_field_value->unique_id = $id;
        $custom_field_value->save();
    }
}

function deleteCustomField($form, $id){
    $data = \DB::table('custom_field_values')
        ->join('custom_fields','custom_fields.id','=','custom_field_values.custom_field_id')
        ->where('form','=',$form)
        ->where('unique_id','=',$id)
        ->delete();
}

function defaultRole(){
    if(\Entrust::hasRole(DEFAULT_ROLE))
        return 1;
    else
        return 0;
}

function passwordRule(){
    $str = 'regex:/^.*(?=.{2,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/';
    return $str;
}

function usernameRule(){
    $str = 'regex:/^[a-zA-Z0-9_\.\-]*$/';
    return $str;
}

function timeAgo($time_ago){
    $time_ago = strtotime($time_ago);
    $cur_time = strtotime(date('Y-m-d H:i:s'));
    $time_elapsed   = $cur_time - $time_ago;
    $seconds    = $time_elapsed ;
    $minutes    = round($time_elapsed / 60 );
    $hours      = round($time_elapsed / 3600);
    $days       = round($time_elapsed / 86400 );
    $weeks      = round($time_elapsed / 604800);
    $months     = round($time_elapsed / 2600640 );
    $years      = round($time_elapsed / 31207680 );
    if($seconds <= 60){
        echo "$seconds seconds ago";
    }
    else if($minutes <=60){
        if($minutes==1){
            echo "one minute ago";
        }
        else{
            echo "$minutes minutes ago";
        }
    }
    else if($hours <=24){
        if($hours==1){
            echo "an hour ago";
        }else{
            echo "$hours hours ago";
        }
    }
    else if($days <= 7){
        if($days==1){
            echo "yesterday";
        }else{
            echo "$days days ago";
        }
    }
    else if($weeks <= 4.3){
        if($weeks==1){
            echo "a week ago";
        }else{
            echo "$weeks weeks ago";
        }
    }
    else if($months <=12){
        if($months==1){
            echo "a month ago";
        }else{
            echo "$months months ago";
        }
    }
    else{
        if($years==1){
            echo "one year ago";
        }else{
            echo "$years years ago";
        }
    }
}

function getDateDiff($date){
    $difference = date('z',strtotime($date)) - date('z');
    if($difference == 0)
        return trans('messages.today');
    elseif($difference == 1)
        return trans('messages.tomorrow');
    elseif($difference == -1)
        return trans('messages.yesterday');
    else
        return 0;
}

function daySuffix($num){
    $num = $num % 100;
    if($num < 11 || $num > 13){
         switch($num % 10){
            case 1: return 'st';
            case 2: return 'nd';
            case 3: return 'rd';
        }
    }
    return 'th';
}

function isSecure(){
    if(!getMode())
        return 1;
    
    $url = \Request::url();
    $result = strpos($url, 'wmlab');
    if($result === FALSE)
        return 0;
    else
        return 1;
}

function verifyPurchase($purchase_code = ''){
    $purchase_code = ($purchase_code != '') ? $purchase_code : env('PURCHASE_CODE');
    $url = config('constant.path.verifier')."verifier";
    $postData = array(
        'purchase_code' => $purchase_code,
        'install_url' => \Request::url()
    );
    return postCurl($url,$postData);
}

function is_connected()
{
    $connected = @fsockopen("www.google.com", 80); 
    if ($connected){
        $is_conn = true;
        fclose($connected);
    }else{
        $is_conn = false;
    }
    return $is_conn;
}

function installPurchase($purchase_code,$envato_username,$email = ''){
    $url = config('constant.path.verifier')."installer";
    $postData = array(
        'envato_username' => $envato_username,
        'purchase_code' => $purchase_code,
        'product_code' => config('constant.item_code'),
        'email' => $email,
        'api_version' => '2',
        'install_url' => \Request::url()
    );
    return postCurl($url,$postData);
}

function complete($purchase_code){
    $url = config('constant.path.verifier')."activate";
    $postData = array(
        'purchase_code' => $purchase_code,
        'install_url' => \Request::url()
    );
    return postCurl($url,$postData);
}

function releaseLicense(){
    $purchase_code = env('PURCHASE_CODE');
    $url = config('constant.path.verifier')."license-release";
    $postData = array(
        'purchase_code' => $purchase_code,
        'install_url' => \Request::url()
    );
    return postCurl($url,$postData);
}

function getUpdate(){
    $url = config('constant.path.verifier')."update";
    $postData = array(
        'purchase_code' => env('PURCHASE_CODE'),
        'build' => env('BUILD'),
        'install_url' => \Request::url()
    );
    return postCurl($url,$postData);
}

function envu($data = array()){
    if(count($data) > 0){
        $env = file_get_contents(base_path() . '/.env');
        $env = preg_split('/\s+/', $env);;
        foreach((array)$data as $key => $value){
            foreach($env as $env_key => $env_value){
                $entry = explode("=", $env_value, 2);
                if($entry[0] == $key)
                    $env[$env_key] = $key . "=" . $value;
                else
                    $env[$env_key] = $env_value;
            }
        }
        $env = implode("\n", $env);
        file_put_contents(base_path() . '/.env', $env);
        return true;
    } else {
        return false;
    }
}

function write2Config($data,$file){
    $filename = base_path().'/config/'.$file.'.php';
    File::put($filename,var_export($data, true));
    File::prepend($filename,'<?php return ');
    File::append($filename, ';');
}

function translateList($lists){
    $translated_list = array();
    foreach($lists as $key => $list)
        $translated_list[$key] = trans('messages.'.$key);

    return $translated_list;
}

function translateListValue($lists){
    $translated_list = array();
    foreach($lists as $key => $list)
        $translated_list[$key] = trans('messages.'.$list);

    return $translated_list;
}

function validateIp(){

    $ip = \Request::getClientIp();

    $wl_ips = \App\IpFilter::all();
    $allowedIps = array();
    foreach($wl_ips as $wl_ip){
        if($wl_ip->end)
            $allowedIps[] = $wl_ip->start.'-'.$wl_ip->end;
        else
            $allowedIps[] = $wl_ip->start;
    }

    foreach ($allowedIps as $allowedIp) 
    {
        if (strpos($allowedIp, '*')) 
        {
            $range = [ 
                str_replace('*', '0', $allowedIp),
                str_replace('*', '255', $allowedIp)
            ];
            if(ipExistsInRange($range, $ip)) return true;
        } 
        else if(strpos($allowedIp, '-'))
        {
            $range = explode('-', str_replace(' ', '', $allowedIp));
            if(ipExistsInRange($range, $ip)) return true;
        }
        else 
        {
            if (ip2long($allowedIp) === ip2long($ip)) return true;
        }
    }
    return false;
}

function ipExistsInRange(array $range, $ip)
{
    if (ip2long($ip) >= ip2long($range[0]) && ip2long($ip) <= ip2long($range[1])) 
        return true;
    return false;
}

function postCurl($url,$postData){
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
    ));
    $data = curl_exec($ch);
    $gresponse = json_decode($data,true);
    return $gresponse;
}

function getAvatar($id, $size = 60){
    $user = \App\User::find($id);
    $profile = $user->Profile;
    $name = $user->full_name;
    $tooltip = $name;
    if(isset($profile->avatar))
        return '<img src="/'.config('constant.upload_path.avatar').$profile->avatar.'" class="img-circle" style="width:'.$size.'px";" alt="User avatar" data-toggle="tooltip" title="'.$tooltip.'">';
    else 
        return '<p class="textAvatar" data-toggle="tooltip" title="'.$tooltip.'" data-image-size="'.$size.'">'.$name.'</p>';
}

function getMode(){
    return env('MODE');
}

function inWords($number){
    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );
    
    if (!is_numeric($number)) {
        return false;
    }
    
    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . inWords(abs($number));
    }
    
    $string = $fraction = null;
    
    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }
    
    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . inWords($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = inWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= inWords($remainder);
            }
            break;
    }
    
    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    
    return ucwords($string);
}

function getEnvironment(){

    if(!env('MODE'))
        return 0;

    return (config('app.env') == 'local') ? 0 : 1;
}

function convertPHPSizeToBytes($sSize)  
{  
    if ( is_numeric( $sSize) ) {
       return $sSize;
    }
    $sSuffix = substr($sSize, -1);  
    $iValue = substr($sSize, 0, -1);  
    switch(strtoupper($sSuffix)){  
    case 'P':  
        $iValue *= 1024;  
    case 'T':  
        $iValue *= 1024;  
    case 'G':  
        $iValue *= 1024;  
    case 'M':  
        $iValue *= 1024;  
    case 'K':  
        $iValue *= 1024;  
        break;  
    }  
    return $iValue;  
}  

function getMaxFileUploadSize()  
{  
    return min(convertPHPSizeToBytes(ini_get('post_max_size')), convertPHPSizeToBytes(ini_get('upload_max_filesize')));  
}  

function formatMemorySizeUnits($bytes)
{
    if ($bytes >= 1073741824)
        $bytes = round($bytes / 1073741824, 2) . ' GB';
    elseif ($bytes >= 1048576)
        $bytes = round($bytes / 1048576, 2) . ' MB';
    elseif ($bytes >= 1024)
        $bytes = round($bytes / 1024, 2) . ' kB';
    elseif ($bytes > 1)
        $bytes = $bytes . ' bytes';
    elseif ($bytes == 1)
        $bytes = $bytes . ' byte';
    else
        $bytes = '0 bytes';
    return $bytes;
}
?>