<?php
namespace App\Http\Controllers;
use Session;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentRequest;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Entrust;
use Validator;
use Stripe\Error\Card;
use Stripe\Error\Api;
use Stripe\Error\InvalidRequest;
use Stripe\Error\RateLimit;
use Stripe\Error\ApiConnection;
use Stripe\Error\Authentication;

Class PaymentController extends Controller{
    use BasicController;

    public function paypalConfig(){
        $paypal_conf = config('paypal');
        $api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $api_context->setConfig($paypal_conf['settings']);
        return $api_context;
    }

    public function validatePayment($invoice,$request){

    	if($invoice)
	        $total_paid = $this->getInvoiceTransaction($invoice,'sum');

		if(!$invoice)
			$response = ['message' => trans('messages.invalid_link'), 'status' => 'error']; 
		elseif($request->input('amount') > ($invoice->total - $total_paid))
        	$response = ['message' => trans('messages.payment_amount_greater_than_balance'), 'status' => 'error']; 
        elseif(!$invoice->enable_partial_payment && $request->input('amount') != ($invoice->total - $total_paid))
        	$response = ['status' => 'error','message' => trans('messages.partial').' '.trans('messages.payment').' '.trans('messages.disabled')]; 
        else
        	$response = ['status' => 'success'];

        return $response;
    }

    public function sendMail($mail_data,$transaction){
        if(count($mail_data)){
            $mail = array();
            $mail['email'] = $transaction->Invoice->Customer->email;
            $mail['subject'] = $mail_data['subject'];
            $body = $mail_data['body'];
            \Mail::send('emails.email', compact('body'), function ($message) use($mail) {
                $message->to($mail['email'])->subject($mail['subject']);
            });
            $this->logEmail(array('to' => $mail['email'],'subject' => $mail['subject'],'body' => $body,'module' => 'invoice','module_id' =>$transaction->invoice_id));
        }
    }

    public function startPayment($gateway,$invoice,$data,$request){
        $transaction = new \App\Transaction;
        $transaction->source = $gateway;
        $transaction->user_id = \Auth::user()->id;
        $transaction->invoice_id = $invoice->id;
        $transaction->currency_id = $invoice->currency_id;
        $transaction->customer_id = \Auth::user()->id;
        $transaction->amount = $data['amount'];
        $transaction->head = 'income';
        $transaction->coupon = $data['coupon'];
        $transaction->coupon_discount = $data['discount'];
        $transaction->date = date('Y-m-d');
        $transaction->token = strtoupper(randomString(25));
        $transaction->address_line_1 = $request->input('address_line_1');
        $transaction->address_line_2 = $request->input('address_line_2');
        $transaction->city = $request->input('city');
        $transaction->state = $request->input('state');
        $transaction->zipcode = $request->input('zipcode');
        $transaction->country_id = $request->input('country_id');
        $transaction->phone = $request->input('phone');
        $transaction->save();
        return $transaction;
    }

	public function paypal(PaymentRequest $request,$invoice_id){
		$invoice = \App\Invoice::find($invoice_id);

		$response = $this->validatePayment($invoice,$request);

		if($response['status'] == 'error')
            return redirect()->back()->withErrors($response['message']);

		$data = validateCoupon($request->input('amount'),$invoice->Currency,$request->input('coupon'));

        $my_transaction = $this->startPayment('paypal',$invoice,$data,$request);
        $invoice_number = $invoice->invoice_prefix.getInvoiceNumber($invoice);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();
        $item_1->setName($invoice_number)
        ->setCurrency($invoice->Currency->name)
        ->setQuantity(1)
        ->setPrice($data['amount']);

        $total = $data['amount'];
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        
        $amount = new Amount();
        $amount->setCurrency($invoice->Currency->name)
        ->setTotal($total);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
        ->setItemList($item_list)
        ->setDescription('Invoice Payment');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(url('paypal-response'))
        ->setCancelUrl(url('paypal-response'));

        $payment = new Payment();
        $payment->setIntent('order')
        ->setPayer($payer)
        ->setRedirectUrls($redirect_urls)
        ->setTransactions(array($transaction));

        try {
            $payment->create($this->paypalConfig());
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if(config('app.debug')) {
                echo "Exception: " . $ex->getMessage() . PHP_EOL;
                $err_data = json_decode($ex->getData(), true);
                exit;
            } else
                return redirect('/home')->withErrors(trans('messages.something_wrong'));
        } catch (Exception $e) {
            if(config('app.debug'))
                return $e->getMessage();
            else
                return redirect('/home')->withErrors(trans('messages.something_wrong'));
        }
        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        $my_transaction->gateway_token = $payment->getId();
        $my_transaction->save();

        Session::put('paypal_payment_id', $payment->getId());
        if(isset($redirect_url)) {
            return redirect($redirect_url);
        }
        return redirect('/home')->withErrors('Unknown error occurred');
	}

    public function paypalResponse(Request $request){
        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');
        if (empty($request->input('PayerID')) || empty($request->input('token')))
            return redirect('/home')->withErrors(trans('messages.payment').' '.trans('messages.failed'));

        $payment = Payment::get($payment_id, $this->paypalConfig());
        $transaction = \App\Transaction::where('gateway_token','=',$payment_id)->first();

        if(!$transaction)
            return redirect('/home')->withErrors(trans('messages.payment').' '.trans('messages.failed'));

        $execution = new PaymentExecution();
        $execution->setPayerId($request->input('PayerID'));

        $result = $payment->execute($execution, $this->paypalConfig());
        if ($result->getState() == 'approved') { 
            $transaction->gateway_status = 'success';
            $transaction->save();

            if($transaction->coupon)
                \App\Coupon::whereCode($transaction->coupon)->increment('use_count');

            $this->updateInvoicePaymentStatus($transaction->Invoice);
            $mail_data = $this->templateContent(['slug' => 'invoice-payment-success','transaction' => $transaction]);
            $this->sendMail($mail_data,$transaction);
            $this->logActivity(['module' => 'invoice','module_id' => $transaction->invoice_id,'activity' => 'paid']);
            return redirect('/invoice/'.$transaction->Invoice->uuid)->withSuccess(trans('messages.payment').' '.trans('messages.added'));
        } else {
            $transaction->gateway_status = 'error';
            $transaction->save();
            $this->logActivity(['module' => 'invoice','module_id' => $transaction->invoice_id,'activity' => 'payment_failed']);
            $mail_data = $this->templateContent(['slug' => 'invoice-payment-failure','transaction' => $transaction]);
            $this->sendMail($mail_data,$transaction);
        }
        return redirect('/home')->withErrors(trans('messages.payment').' '.trans('messages.failed'));
    }

	public function stripe(PaymentRequest $request,$invoice_id){
		$invoice = \App\Invoice::find($invoice_id);

		$response = $this->validatePayment($invoice,$request);

		if($response['status'] == 'error')
            return redirect()->back()->withErrors($response['message']);

		$data = validateCoupon($request->input('amount'),$invoice->Currency,$request->input('coupon'));

        $amount = $data['amount']*100;

        $transaction = $this->startPayment('stripe',$invoice,$data,$request);
        $payment_response = ['status' => 'success'];

		$token = $request->input('stripeToken');
        \Stripe\Stripe::setApiKey(config('config.stripe_private_key'));
        try {
            $charge = \Stripe\Charge::create([
                'amount' => $amount,
                'currency' => $invoice->Currency->name,
                'source' => $token
                ]);
        } catch (Card $e) {
        	$payment_response = ['status' => 'error', 'message' => $e->getMessage()];
        }
        catch (Api $e) {
        	$payment_response = ['status' => 'error', 'message' => $e->getMessage()];
        }
        catch (InvalidRequest $e) {
        	$payment_response = ['status' => 'error', 'message' => $e->getMessage()];
        }
        catch (RateLimit $e) {
        	$payment_response = ['status' => 'error', 'message' => $e->getMessage()];
        }
        catch (ApiConnection $e) {
        	$payment_response = ['status' => 'error', 'message' => $e->getMessage()];
        }
        catch (Authentication $e) {
        	$payment_response = ['status' => 'error', 'message' => $e->getMessage()];
        }

        if($payment_response['status'] == 'error'){
        	$transaction->gateway_response = $payment_response['message'];
        	$transaction->gateway_status = 'error';
        	$transaction->save();
            $this->logActivity(['module' => 'invoice','module_id' => $transaction->invoice_id,'activity' => 'payment_failed']);

            $mail_data = $this->templateContent(['slug' => 'invoice-payment-failure','transaction' => $transaction]);
            $this->sendMail($mail_data,$transaction);
        	return redirect()->back()->withErrors(trans('messages.payment').' '.trans('messages.failed'));
        } else {
        	$transaction->gateway_status = 'success';
        	$transaction->save();

            if($transaction->coupon)
                \App\Coupon::whereCode($transaction->coupon)->increment('use_count');

            $this->updateInvoicePaymentStatus($invoice);
            $this->logActivity(['module' => 'invoice','module_id' => $transaction->invoice_id,'activity' => 'paid']);
            $mail_data = $this->templateContent(['slug' => 'invoice-payment-success','transaction' => $transaction]);
            $this->sendMail($mail_data,$transaction);
        	return redirect()->back()->withSuccess(trans('messages.payment').' '.trans('messages.added'));
        }
	}

	public function tco(PaymentRequest $request, $invoice_id){
		$invoice = \App\Invoice::find($invoice_id);

		$response = $this->validatePayment($invoice,$request);

		if($response['status'] == 'error')
            return redirect()->back()->withErrors($response['message']);

		$data = validateCoupon($request->input('amount'),$invoice->Currency,$request->input('coupon'));

        $this->startPayment('stripe',$invoice,$data,$request);
        $payment_response = ['status' => 'success'];

	    File::requireOnce('../app/Classes/Twocheckout.php');

	    $mode = (config('config.tco_mode')) ? false : true;
	    \Twocheckout::privateKey(config('config.tco_private_key')); 
	    \Twocheckout::sellerId(config('config.tco_seller_id')); 
	    \Twocheckout::sandbox($mode);
	    \Twocheckout::verifySSL(true);

	    try {
	    $charge = \Twocheckout_Charge::auth(array(
	        "merchantOrderId" => $invoice->id,
	        "token"      => $request->input('token'),
	        "currency"   => $invoice->Currency->name,
	        "total"      => $data['amount'],
	        "billingAddr" => array(
	            "name" => $invoice->Customer->full_name,
	            "addrLine1" => $request->input('address_line_1'),
	            "city" => $request->input('city'),
	            "state" => $request->input('state'),
	            "zipCode" => $request->input('zipcode'),
	            "country" => $request->input('country'),
	            "email" => \Auth::user()->email,
	            "phoneNumber" => $request->input('phone'),
	        )
	    ));
	        if ($charge['response']['responseCode'] == 'APPROVED') {
	            $transaction->gateway_status = 'success';
	            $transaction->save();

                if($transaction->coupon)
                    \App\Coupon::whereCode($transaction->coupon)->increment('use_count');

                $this->updateInvoicePaymentStatus($invoice);
                $this->logActivity(['module' => 'invoice','module_id' => $transaction->invoice_id,'activity' => 'paid']);
                $mail_data = $this->templateContent(['slug' => 'invoice-payment-success','transaction' => $transaction]);
                $this->sendMail($mail_data,$transaction);
	            return redirect()->back()->withSuccess(trans('messages.payment').' '.trans('messages.added'));
	        }
	    } catch (\Twocheckout_Error $e){
	        $transaction->gateway_response = $e->getMessage();
	        $transaction->gateway_status = 'error';
	        $transaction->save();
            $this->logActivity(['module' => 'invoice','module_id' => $transaction->invoice_id,'activity' => 'payment_failed']);
	        
            $mail_data = $this->templateContent(['slug' => 'invoice-payment-failure','transaction' => $transaction]);
            $this->sendMail($mail_data,$transaction);
	        return redirect()->back()->withErrors(trans('messages.payment').' '.trans('messages.failed'));
	    }
	}

	public function payumoney(PaymentRequest $request, $invoice_id){
		$invoice = \App\Invoice::find($invoice_id);

        if($invoice->Currency->name != 'INR')
            return redirect()->back()->withErrors('This method is only available for Indian Ruppee.');

		$response = $this->validatePayment($invoice,$request);

		if($response['status'] == 'error')
            return redirect()->back()->withErrors($response['message']);

		$data = validateCoupon($request->input('amount'),$invoice->Currency,$request->input('coupon'));

        $transaction = $this->startPayment('payumoney',$invoice,$data,$request);

        $amount = $data['amount'];

        $posted = $request->all();
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
        $posted['txnid'] = $txnid;
        $key = config('config.payumoney_key');
        $salt = config('config.payumoney_salt');
        $url = 'https://'.((!config('config.payumoney_mode')) ? 'test' : 'secure').'.payu.in';
        $posted['key'] = $key;

        $posted['amount'] = $amount;
        $posted['firstname'] = $invoice->Customer->full_name;
        $posted['email'] = $invoice->Customer->email;
        $posted['phone'] = $request->input('phone');
        $posted['address1'] = $request->input('address_line_1');
        $posted['city'] = $request->input('city');
        $posted['state'] = $request->input('state');
        $posted['country'] = $request->input('country_id');
        $posted['zipcode'] = $request->input('zipcode');
        $posted['productinfo'] = $invoice->invoice_prefix.getInvoiceNumber($invoice);
        $posted['surl'] = url('payumoney-response');
        $posted['furl'] = url('payumoney-response');
        $posted['udf1'] = $transaction->id;

        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
        $hashVarsSeq = explode('|', $hashSequence);
        $hash_string = '';  
        foreach($hashVarsSeq as $hash_var) {
          $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
          $hash_string .= '|';
        }
        $hash_string .= $salt;
        $hash = strtolower(hash('sha512', $hash_string));
        $posted['hash'] = $hash;
        $action = $url . '/_payment';

        return view('invoice.payumoney_process',compact('action','posted','hash'));
	}

    public function payumoneyResponse(Request $request){

        $transaction_id = $request->input('udf1');
        $transaction = \App\Transaction::find($transaction_id);

        if(!$transaction)
            return redirect('/home')->withErrors(trans('messages.payment').' '.trans('messages.failed'));

        if($request->input('status') == 'success'){
            $transaction->gateway_status = 'success';
            $transaction->gateway_token = $request->input('txnid');
            $transaction->save();

            if($transaction->coupon)
                \App\Coupon::whereCode($transaction->coupon)->increment('use_count');
            
            $this->updateInvoicePaymentStatus($transaction->Invoice);
            $this->logActivity(['module' => 'invoice','module_id' => $transaction->invoice_id,'activity' => 'paid']);
            $mail_data = $this->templateContent(['slug' => 'invoice-payment-success','transaction' => $transaction]);
            $this->sendMail($mail_data,$transaction);
            return redirect('/invoice/'.$transaction->Invoice->uuid)->withSuccess(trans('messages.payment').' '.trans('messages.added'));
        } else {
            $transaction->gateway_response = $request->input('unmappedstatus');
            $transaction->gateway_status = 'error';
            $transaction->save();
            $this->logActivity(['module' => 'invoice','module_id' => $transaction->invoice_id,'activity' => 'payment_failed']);
            
            $mail_data = $this->templateContent(['slug' => 'invoice-payment-failure','transaction' => $transaction]);
            $this->sendMail($mail_data,$transaction);
            return redirect()->back()->withErrors(trans('messages.payment').' '.trans('messages.failed'));
        }
    }
}