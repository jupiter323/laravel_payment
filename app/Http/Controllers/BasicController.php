<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Entrust;

trait BasicController {

    public function recaptchaResponse($request){
        // $url = "https://www.google.com/recaptcha/api/siteverify";
        // $postData = array(
        //     'secret' => config('config.recaptcha_secret'),
        //     'response' => $request->input('g-recaptcha-response'),
        //     'remoteip' => $request->getClientIp()
        // );
        
        // return postCurl($url,$postData);

        if($request->has('g-recaptcha-response'))
            return ['success' => true];
        else
            return ['success' => false];
    }

    public function logActivity($data) {

        if(session()->has('parent_login')){
            $data['login_as_user_id'] = isset($data['user_id']) ? $data['user_id'] : ((\Auth::check()) ? \Auth::user()->id : null);
            $data['user_id'] = session('parent_login');
        } else 
            $data['user_id'] = isset($data['user_id']) ? $data['user_id'] : ((\Auth::check()) ? \Auth::user()->id : null);

        $data['ip'] = \Request::getClientIp();
        $data['module'] = isset($data['module']) ? $data['module'] : null;
        $data['module_id'] = isset($data['module_id']) ? $data['module_id'] : null;
        $data['sub_module'] = isset($data['sub_module']) ? $data['sub_module'] : null;
        $data['sub_module_id'] = isset($data['sub_module_id']) ? $data['sub_module_id'] : null;
        $data['user_agent'] = \Request::header('User-Agent');
        if(config('config.enable_activity_log'))
        $activity = \App\Activity::create($data);
    }
    
    public function logEmail($data){
        $data['to_address'] = $data['to'];
        unset($data['to']);
        $data['from_address'] = config('mail.from.address');
        $data['module'] = isset($data['module']) ? $data['module'] : null;
        $data['module_id'] = isset($data['module_id']) ? $data['module_id'] : null;
        if(config('config.enable_email_log'))
        \App\Email::create($data);
    }

    public function getSetupGuide($response, $menu = null){
        if($menu && \App\Setup::whereModule($menu)->whereCompleted(0)->first())
            \App\Setup::whereModule($menu)->whereCompleted(0)->update(['completed' => 1]);

        if(config('config.setup_guide') && defaultRole()){
            $setup_guide = setupGuide();
            $response['setup_guide'] = $setup_guide;
        }
        return $response;
    }

    public function designationAccessible($designation){
        if(Entrust::can('manage-all-designation') || (Entrust::can('manage-subordinate-designation') && isChild($designation->id)))
            return 1;
        else
            return 0;
    }

    public function AnnouncementAccessible($announcement){
        if(Entrust::can('manage-all-designation') || (Entrust::can('manage-subordinate-designation') && (isChild($announcement->User->Profile->designation_id) || $announcement->user_id == \Auth::user()->id)))
            return 1;
        else
            return 0;
    }

    public function TransactionAccessible($transaction){
        if(Entrust::can('manage-all-designation') || (Entrust::can('manage-subordinate-designation') && (isChild($transaction->User->Profile->designation_id) || $transaction->user_id == \Auth::user()->id)))
            return 1;
        else
            return 0;
    }

    public function InvoiceAccessible($transaction){
        if(Entrust::can('manage-all-designation') || (Entrust::can('manage-subordinate-designation') && (isChild($invoice->User->Profile->designation_id) || $invoice->user_id == \Auth::user()->id)))
            return 1;
        else
            return 0;
    }

    public function QuotationAccessible($transaction){
        if(Entrust::can('manage-all-designation') || (Entrust::can('manage-subordinate-designation') && (isChild($quotation->User->Profile->designation_id) || $quotation->user_id == \Auth::user()->id)))
            return 1;
        else
            return 0;
    }

    public function userAccessible($user_id){
        if(in_array($user_id, getAccessibleUserList()))
            return 1;
        else
            return 0;
    }

    public function getCurrencyValue($currency_id,$date = null){
        if(!$date)
            $date = date('Y-m-d');

        $default_currency = \App\Currency::whereIsDefault(1)->first();
        $currency = \App\Currency::find($currency_id);

        if(!$currency)
            return;

        $currency_conversion = \App\CurrencyConversion::where('date','=',$date)->whereCurrencyId($currency_id)->first();

        if($currency_id == $default_currency->id)
            return 1;

        if($currency_conversion)
            return $currency_conversion->rate;

        $client = new \GuzzleHttp\Client();
        $res = $client->get('http://api.fixer.io/'.$date.'?base='.$default_currency->name);
        $conversion_string = json_decode($res->getBody(),true);
        $conversions = array_key_exists('rates', $conversion_string) ? $conversion_string['rates'] : [];
        return array_key_exists($currency->name,$conversions) ? $conversions[$currency->name] : '';
    }

    public function getInvoiceTransaction($invoice,$action = ''){
        $qry = \App\Transaction::whereInvoiceId($invoice->id)->where(function($query){
            $query->whereNull('source')->orWhere(function($query1){
                $query1->whereNotNull('source')->whereGatewayStatus('success');
            });
        });

        if($action == '')
            return $qry->get();
        elseif($action == 'sum'){
            $transactions = $qry->get();
            $total_paid = 0;
            foreach($transactions as $transaction)
                $total_paid += getAmountWithoutDiscount($transaction->amount,$transaction->coupon_discount);
            return $total_paid;
        }
        elseif($action == 'count')
            return $qry->count();
        elseif($action == 'last')
            return $qry->orderBy('date','desc')->first();
    }

    public function updateInvoicePaymentStatus($invoice){
        $total_paid = $this->getInvoiceTransaction($invoice,'sum');
        if(!$total_paid)
            $invoice->payment_status = 'unpaid';
        elseif($total_paid < $invoice->total)
            $invoice->payment_status = 'partially_paid';
        elseif($total_paid >= $invoice->total)
            $invoice->payment_status = 'paid';

        $invoice->save();
    }

    public function getCompanyAddress(){
        $company_address = config('config.company_address_line_1');
        $company_address .= (config('config.company_address_line_2')) ? (', <br >'.config('config.company_address_line_2')) : '';
        $company_address .= (config('config.company_city')) ? ', <br >'.(config('config.company_city')) : '';
        $company_address .= (config('config.company_state')) ? ', '.(config('config.company_state')) : '';
        $company_address .= (config('config.company_zipcode')) ? ', '.(config('config.company_zipcode')) : '';
        $company_address .= (config('config.company_country_id')) ? '<br >'.(config('country.'.config('config.company_country_id'))) : '';

        return $company_address;
    }

    public function templateContent($data){
        $template = \App\Template::whereSlug($data['slug'])->first();
        $mail_data = array();
        if(!$template)
            return $mail_data;

        $body = $template->body;
        $subject = $template->subject;

        $company_address = $this->getCompanyAddress();
    
        $company_logo = getCompanyLogo();
        $body = str_replace('[COMPANY_LOGO]',$company_logo,$body);

        $body = str_replace('[COMPANY_NAME]',config('config.company_name'),$body); 
        $subject = str_replace('[COMPANY_NAME]',config('config.company_name'),$subject); 

        $body = str_replace('[COMPANY_EMAIL]',config('config.company_email'),$body); 
        $subject = str_replace('[COMPANY_EMAIL]',config('config.company_email'),$subject); 

        $body = str_replace('[COMPANY_PHONE]',config('config.company_phone'),$body); 
        $subject = str_replace('[COMPANY_PHONE]',config('config.company_phone'),$subject); 

        $body = str_replace('[COMPANY_WEBSITE]',config('config.company_website'),$body); 
        $subject = str_replace('[COMPANY_WEBSITE]',config('config.company_website'),$subject); 

        $body = str_replace('[COMPANY_ADDRESS]',$company_address,$body); 
        $subject = str_replace('[COMPANY_ADDRESS]',$company_address,$subject); 

        $body = str_replace('[CURRENT_DATE]',showDate(date('Y-m-d')),$body); 
        $subject = str_replace('[CURRENT_DATE]',showDate(date('Y-m-d')),$subject); 

        $body = str_replace('[CURRENT_DATE_TIME]',showDateTime(date('Y-m-d H:i:s')),$body); 
        $subject = str_replace('[CURRENT_DATE_TIME]',showDateTime(date('Y-m-d H:i:s')),$subject); 

        if($template->category == 'customer' || $template->category == 'staff'){

            if(array_key_exists('user', $data)){
                $user = $data['user'];
                $password = (array_key_exists('password', $data)) ? $data['password'] : '';
                $body = str_replace('[NAME]',($user->full_name) ? : '-',$body); 
                $subject = str_replace('[NAME]',($user->full_name) ? : '-',$subject); 

                $body = str_replace('[PASSWORD]',$password,$body);
                $subject = str_replace('[PASSWORD]',$password,$subject);

                $body = str_replace('[USERNAME]',$user->username,$body);
                $subject = str_replace('[USERNAME]',$user->username,$subject);

                $body = str_replace('[EMAIL]',$user->email,$body);
                $subject = str_replace('[EMAIL]',$user->email,$subject);

                if($template->category == 'staff'){
                    $body = str_replace('[DEPARTMENT]',($user->Profile->designation_id) ? $user->Profile->Designation->Department->name : '-',$body);
                    $subject = str_replace('[DEPARTMENT]',($user->Profile->designation_id) ? $user->Profile->Designation->Department->name : '-',$subject);

                    $body = str_replace('[DESIGNATION]',($user->Profile->designation_id) ? $user->Profile->Designation->name : '-',$body);
                    $subject = str_replace('[DESIGNATION]',($user->Profile->designation_id) ? $user->Profile->Designation->name : '-',$subject);
                }

                $body = str_replace('[DATE_OF_BIRTH]',($user->Profile) ? showDate($user->Profile->date_of_birth) : '-',$body);
                $subject = str_replace('[DATE_OF_BIRTH]',($user->Profile) ? showDate($user->Profile->date_of_birth) : '-',$subject);

                $body = str_replace('[DATE_OF_ANNIVERSARY]',($user->Profile) ? showDate($user->Profile->date_of_anniversary) : '-',$body);
                $subject = str_replace('[DATE_OF_ANNIVERSARY]',($user->Profile) ? showDate($user->Profile->date_of_anniversary) : '-',$subject);
            }
        } elseif($template->category == 'invoice' || $template->category == 'invoice-payment' || $template->category == 'quotation'){
            if($template->category == 'invoice')
                $invoice = $data['invoice'];
            elseif($template->category == 'quotation'){
                $quotation = $data['quotation'];
                $customer_name = $quotation->Customer->full_name;
                $customer_email = $quotation->Customer->email;
                $customer_phone = $quotation->Customer->Profile->phone;
                $reference_number = $quotation->reference_number;
            }
            elseif($template->category == 'invoice-payment'){
                $transaction = $data['transaction'];
                $invoice = $transaction->Invoice;

                $body = str_replace('[PAYMENT_AMOUNT]',currency($transaction->amount,1,$invoice->Currency->id),$body); 
                $subject = str_replace('[PAYMENT_AMOUNT]',currency($transaction->amount,1,$invoice->Currency->id),$subject); 

                $body = str_replace('[PAYMENT_SOURCE]',strtoupper($transaction->source),$body); 
                $subject = str_replace('[PAYMENT_SOURCE]',strtoupper($transaction->source),$subject); 

                $body = str_replace('[TRANSACTION_TOKEN]',$transaction->token,$body); 
                $subject = str_replace('[TRANSACTION_TOKEN]',$transaction->token,$subject); 

                $body = str_replace('[TRANSACTION_DATE]',showDateTime($transaction->created_at),$body); 
                $subject = str_replace('[TRANSACTION_DATE]',showDateTime($transaction->created_at),$subject); 

                $body = str_replace('[TRANSACTION_FAILURE_REASON]',toWord($transaction->gateway_response),$body); 
                $subject = str_replace('[TRANSACTION_FAILURE_REASON]',toWord($transaction->gateway_response),$subject); 
            }

            if($template->category == 'invoice' || $template->category == 'invoice-payment'){
                $customer_name = $invoice->Customer->full_name;
                $customer_email = $invoice->Customer->email;
                $customer_phone = $invoice->Customer->Profile->phone;
                $reference_number = $invoice->reference_number;
            }

            $body = str_replace('[CUSTOMER_NAME]',$customer_name,$body); 
            $subject = str_replace('[CUSTOMER_NAME]',$customer_name,$subject); 

            $body = str_replace('[CUSTOMER_EMAIL]',$customer_email,$body);
            $subject = str_replace('[CUSTOMER_EMAIL]',$customer_email,$subject);

            $body = str_replace('[CUSTOMER_PHONE]',$customer_phone,$body);
            $subject = str_replace('[CUSTOMER_PHONE]',$customer_phone,$subject);

            $body = str_replace('[REFERENCE_NUMBER]',$reference_number,$body);
            $subject = str_replace('[REFERENCE_NUMBER]',$reference_number,$subject);

            if($template->category == 'invoice' || $template->category == 'invoice-payment'){
                $body = str_replace('[INVOICE_NUMBER]',$invoice->invoice_prefix.getInvoiceNumber($invoice),$body);
                $subject = str_replace('[INVOICE_NUMBER]',$invoice->invoice_prefix.getInvoiceNumber($invoice),$subject);

                $body = str_replace('[INVOICE_DATE]',($invoice->date) ? showDate($invoice->date) : '',$body);
                $subject = str_replace('[INVOICE_DATE]',($invoice->date) ? showDate($invoice->date) : '',$subject);

                $body = str_replace('[INVOICE_DUE_DATE]',validateDate($invoice->due_date_detail) ? showDate($invoice->due_date_detail) : '',$body);
                $subject = str_replace('[INVOICE_DUE_DATE]',validateDate($invoice->due_date_detail) ? showDate($invoice->due_date_detail) : '',$subject);

                $body = str_replace('[INVOICE_TOTAL]',currency($invoice->total,1,$invoice->currency_id),$body);
                $subject = str_replace('[INVOICE_TOTAL]',currency($invoice->total,1,$invoice->currency_id),$subject);

                $invoice_link = '<a href="'.url('/invoice/'.$invoice->uuid).'">here</a>';

                $body = str_replace('[INVOICE_LINK]',$invoice_link,$body);
                $subject = str_replace('[INVOICE_LINK]',$invoice_link,$subject);
            } elseif($template->category == 'quotation'){
                $body = str_replace('[QUOTATION_NUMBER]',$quotation->quotation_prefix.getQuotationNumber($quotation),$body);
                $subject = str_replace('[QUOTATION_NUMBER]',$quotation->quotation_prefix.getQuotationNumber($quotation),$subject);

                $body = str_replace('[QUOTATION_DATE]',($quotation->date) ? showDate($quotation->date) : '',$body);
                $subject = str_replace('[QUOTATION_DATE]',($quotation->date) ? showDate($quotation->date) : '',$subject);

                $body = str_replace('[QUOTATION_EXPIRY_DATE]',showDate($quotation->expiry_date),$body);
                $subject = str_replace('[QUOTATION_EXPIRY_DATE]',showDate($quotation->expiry_date),$subject);

                $body = str_replace('[QUOTATION_TOTAL]',currency($quotation->total,1,$quotation->currency_id),$body);
                $subject = str_replace('[QUOTATION_TOTAL]',currency($quotation->total,1,$quotation->currency_id),$subject);

                $quotation_link = '<a href="'.url('/quotation/'.$quotation->uuid).'">here</a>';

                $body = str_replace('[QUOTATION_LINK]',$quotation_link,$body);
                $subject = str_replace('[QUOTATION_LINK]',$quotation_link,$subject);
            }

            if($template->category == 'invoice-payment'){
                $body = str_replace('[PAYMENT_AMOUNT]',currency($transaction->amount,1,$invoice->currency_id),$body);
                $subject = str_replace('[PAYMENT_AMOUNT]',currency($transaction->amount,1,$invoice->currency_id),$subject);

                $body = str_replace('[PAYMENT_DATE]',showDate($transaction->date),$body);
                $subject = str_replace('[PAYMENT_DATE]',showDate($transaction->date),$subject);

                $body = str_replace('[TRANSACTION_TOKEN]',$transaction->token,$body);
                $subject = str_replace('[TRANSACTION_TOKEN]',$transaction->token,$subject);

                $body = str_replace('[PAYMENT_METHOD]',($transaction->payment_method_id) ? $transaction->PaymentMethod->name : '',$body);
                $subject = str_replace('[PAYMENT_METHOD]',($transaction->payment_method_id) ? $transaction->PaymentMethod->name : '',$subject);
            }
        }

        $mail_data['body'] = $body;
        $mail_data['subject'] = $subject;
        return $mail_data;
    }
}