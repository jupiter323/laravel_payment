<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Asistente facturacion

Route::get('/billing-wizard/customer/taxid/{rfc}','BillingWizardController@getCustomerByTaxid');
Route::get('/billing-wizard/process','BillingWizardController@process');
Route::get('/billing-wizard/update','BillingWizardController@update');
Route::get('/billing-wizard/{companyalias}','BillingWizardController@index');

Route::get('/','Auth\LoginController@showLoginForm');
Route::get('/under-maintenance','MiscController@maintenance');
Route::get('/terms-and-conditions','MiscController@tnc');
Route::get('/whats-new',function(){
	return view('whats_new');
});
Auth::routes();
Route::get('/invoice/{uuid}/preview','InvoiceController@previewInvoice');
Route::get('/quotation/{uuid}/preview','QuotationController@previewQuotation');

Route::group(['middleware' => ['guest']], function () {
	Route::get('/resend-activation','Auth\ActivateController@resendActivation');
	Route::post('/resend-activation',array('as' => 'user.resend-activation','uses' => 'Auth\ActivateController@postResendActivation'));
	Route::get('/activate-account/{token}','Auth\ActivateController@activateAccount');

	Route::get('/auth/{provider}', 'SocialLoginController@providerRedirect');
    Route::get('/auth/{provider}/callback', 'SocialLoginController@providerRedirectCallback');

	Route::get('/verify-purchase', 'AccController@verifyPurchase');
	Route::post('/verify-purchase', 'AccController@postVerifyPurchase');
	//Route::resource('/install', 'AccController',['only' => ['index', 'store']]);
	Route::get('/install', 'AccController@index');
	Route::post('/install', 'AccController@store')->name('install.store');
	Route::get('/update','AccController@updateApp');
	Route::post('/update',array('as' => 'update-app','uses' => 'AccController@postUpdateApp'));
});

Route::group(['middleware' => ['auth','web','account']],function(){
	Route::get('/verify-security','Auth\TwoFactorController@verifySecurity');
	Route::post('/verify-security',array('as' => 'verify-security','uses' => 'Auth\TwoFactorController@postVerifySecurity'));
});

Route::group(['middleware' => ['auth','web','account','lock_screen']], function () {
	
	Route::get('/home', 'HomeController@index');
	Route::post('/sidebar', 'HomeController@sidebar');
	Route::get('/app', 'HomeController@app');

	Route::post('/setup-guide',array('as' => 'setup-guide','uses' => 'ConfigurationController@setupGuide'));
	Route::post('/login-as-user','UserController@loginAsUser');
	Route::post('/login-return','UserController@loginReturn');
	Route::post('/filter','HomeController@filter');
	Route::post('/calendar-events','HomeController@calendarEvents');

	Route::post('/upload','UploadController@upload');
	Route::post('/upload-list','UploadController@uploadList');
	Route::post('/upload-delete','UploadController@uploadDelete');
	Route::post('/upload-temp-delete','UploadController@uploadTempDelete');

	Route::get('/release-license','AccController@releaseLicense');
	Route::get('/check-update','AccController@checkUpdate');
	Route::get('/cust-data','UserController@customer_data');
	Route::get('/shipment-data','UserController@shipment_data');
	Route::get('/customer-company','UserController@customer_company');

	Route::group(['middleware' => ['permission:manage-configuration']], function() {
		Route::get('/configuration', 'ConfigurationController@index');
		Route::get('/configuration/payment-gateway', 'ConfigurationController@payment_gateway');
		Route::get('/configuration/theme', 'ConfigurationController@theme');
		Route::get('/configuration/system-form', 'ConfigurationController@system_form');
		Route::get('/configuration/mail', 'ConfigurationController@mail_form');
		Route::get('/configuration/sms', 'ConfigurationController@sms_form');
                Route::get('/configuration/auth', 'ConfigurationController@auth_form');
		Route::get('/configuration/social-login', 'ConfigurationController@social_login_form');
		Route::get('/configuration/menu', 'ConfigurationController@menu_form');
                Route::get('/configuration/currency', 'ConfigurationController@currency_form');
                Route::get('/configuration/taxation', 'ConfigurationController@taxation_form');
                Route::get('/configuration/customers', 'ConfigurationController@customers_form');
                Route::get('/configuration/expense', 'ConfigurationController@expense_form');
                Route::get('/configuration/income', 'ConfigurationController@income_form');
                Route::get('/configuration/items', 'ConfigurationController@items_form');
                Route::get('/configuration/invoice', 'ConfigurationController@invoice_form');
                Route::get('/configuration/quotations', 'ConfigurationController@quotations_form');
                Route::get('/configuration/payments', 'ConfigurationController@payments_form');
                Route::get('/configuration/schedule-job', 'ConfigurationController@schedule_form');
                


		Route::post('/configuration',array('as' => 'configuration.store','uses' => 'ConfigurationController@store'));
		Route::post('/configuration-logo',array('as' => 'configuration.logo','uses' => 'ConfigurationController@logo'));
		Route::post('/configuration-mail',array('as' => 'configuration.mail','uses' => 'ConfigurationController@mail'));
		Route::post('/configuration-sms',array('as' => 'configuration.sms','uses' => 'ConfigurationController@sms'));
		Route::post('/configuration-menu', array('as' => 'configuration.menu','uses' => 'ConfigurationController@menu')); 

		Route::model('currency','\App\Currency');
		Route::post('/currency/lists','CurrencyController@lists');
		Route::resource('/currency', 'CurrencyController'); 

		Route::model('expense_category','\App\ExpenseCategory');
		Route::post('/expense-category/lists','ExpenseCategoryController@lists');
		Route::resource('/expense-category', 'ExpenseCategoryController'); 

		Route::model('income_category','\App\IncomeCategory');
		Route::post('/income-category/lists','IncomeCategoryController@lists');
		Route::resource('/income-category', 'IncomeCategoryController'); 

		Route::model('customer_group','CustomerGroup');
		Route::post('/customer-group/lists','CustomerGroupController@lists');
		Route::resource('/customer-group', 'CustomerGroupController'); 

		Route::post('/fetch-currency','CurrencyConversionController@fetchCurrency');
		Route::post('/currency-conversion/lists','CurrencyConversionController@lists');
		Route::model('currency_conversion','\App\CurrencyConversion');
		Route::resource('/currency-conversion', 'CurrencyConversionController'); 
		Route::post('/currency-conversion-field','CurrencyConversionController@currencyConversionField');

		Route::model('item_category','\App\ItemCategory');
		Route::post('/item-category/lists','ItemCategoryController@lists');
		Route::resource('/item-category', 'ItemCategoryController'); 

		Route::model('taxation','\App\Taxation');
		Route::post('/taxation/lists','TaxationController@lists');
		Route::resource('/taxation', 'TaxationController'); 


                Route::model('document','\App\Document');
		Route::post('/document/lists','DocumentController@lists');
		Route::resource('/document', 'DocumentController'); 


                Route::model('shipment_address','\App\ShipmentAddress');
		Route::post('/shipment/lists','ShipmentController@lists');
		Route::resource('/shipment', 'ShipmentController'); 



		Route::model('payment_methods','\App\PaymentMethod');
		Route::post('/payment-method/lists','PaymentMethodController@lists');
		Route::resource('/payment-method', 'PaymentMethodController'); 

                Route::model('column','\App\Column');
		Route::post('/column/lists','ColumnController@lists');
		Route::resource('/column', 'ColumnController'); 

	});
	
	Route::group(['middleware' => ['permission:manage-localization']], function () {
		Route::post('/localization/lists','LocalizationController@lists');
		Route::resource('/localization', 'LocalizationController'); 
		Route::post('/localization/addWords',array('as'=>'localization.add-words','uses'=>'LocalizationController@addWords'));
		Route::patch('/localization/plugin/{locale}',array('as'=>'localization.plugin','uses'=>'LocalizationController@plugin'));
		Route::patch('/localization/updateTranslation/{id}', ['as' => 'localization.update-translation','uses' => 'LocalizationController@updateTranslation']);
	});

	Route::group(['middleware' => ['permission:manage-backup']], function() {
		Route::model('backup','\App\Backup');
		Route::post('/backup/lists','BackupController@lists');
		Route::resource('/backup', 'BackupController',['only' => ['index','show','store','destroy']]); 
		Route::get('/backup/{id}/download','BackupController@download');
	});

	Route::group(['middleware' => ['permission:manage-ip-filter']], function() {
		Route::model('ip_filter','\App\IpFilter');
		Route::post('/ip-filter/lists','IpFilterController@lists');
		Route::resource('/ip-filter', 'IpFilterController'); 
	});

	Route::group(['middleware' => ['permission:manage-todo']], function() {
		Route::model('todo','\App\Todo');
		Route::resource('/todo', 'TodoController'); 
	});

	Route::group(['middleware' => ['permission:manage-template']], function() {
		Route::model('template','\App\Template');
		Route::post('/template/lists','TemplateController@lists');
		Route::resource('/template', 'TemplateController'); 
	});
	Route::post('/template/content','TemplateController@content',['middleware' => ['permission:enable_email_template']]);
	
	Route::group(['middleware' => ['permission:manage-email-log']], function () {
		Route::model('email','\App\Email');
		Route::post('/email/lists','EmailController@lists');
		Route::resource('/email', 'EmailController',['only' => ['index','show']]); 
	});
	
	Route::group(['middleware' => ['permission:manage-campaign']], function () {
		Route::model('campaign','\App\Campaign');
		Route::post('/campaign/lists','CampaignController@lists');
		Route::resource('/campaign', 'CampaignController'); 
	});

	Route::group(['middleware' => ['permission:manage-custom-field']], function() {
		Route::model('custom_field','\App\CustomField');
		Route::post('/custom-field/lists','CustomFieldController@lists');
		Route::resource('/custom-field', 'CustomFieldController'); 
	});

       Route::group(['middleware' => ['permission:manage-column']], function() {
		
	});
	
	Route::group(['middleware' => ['permission:manage-message']], function() {
		Route::get('/message', 'MessageController@index'); 
		Route::post('/load-message','MessageController@load');
		Route::post('/message/{type}/lists','MessageController@lists');
		Route::get('/message/forward/{token}','MessageController@forward');
		Route::post('/message', ['as' => 'message.store', 'uses' => 'MessageController@store']);
		Route::post('/message-reply/{id}', ['as' => 'message.reply', 'uses' => 'MessageController@reply']);
		Route::post('/message-forward/{token}', ['as' => 'message.post-forward', 'uses' => 'MessageController@postForward']);
		Route::get('/message/{file}/download','MessageController@download');
		Route::post('/message/starred','MessageController@starred');
		Route::get('/message/{token}', array('as' => 'message.view', 'uses' => 'MessageController@view'));
		Route::delete('/message/{id}/trash', array('as' => 'message.trash', 'uses' => 'MessageController@trash'));
		Route::post('/message/restore', array('as' => 'message.restore', 'uses' => 'MessageController@restore'));
		Route::delete('/message/{id}/delete', array('as' => 'message.destroy', 'uses' => 'MessageController@destroy'));
	});

	Route::model('department','\App\Department');
	Route::post('/department/lists','DepartmentController@lists');
	Route::resource('/department', 'DepartmentController'); 
	
	Route::model('designation','\App\Designation');
	Route::post('/designation/lists','DesignationController@lists');
	Route::resource('/designation', 'DesignationController'); 
	Route::post('/designation/hierarchy','DesignationController@hierarchy');
	
	Route::model('announcement','\App\Announcement');
	Route::post('/announcement/lists','AnnouncementController@lists');
	Route::resource('/announcement', 'AnnouncementController'); 
	Route::get('/announcement/{file}/download','AnnouncementController@download');

	Route::group(['middleware' => ['permission:manage-role']], function() {
		Route::model('role','\App\Role');
		Route::post('/role/lists','RoleController@lists');
		Route::resource('/role', 'RoleController'); 
	});
		
	Route::group(['middleware' => ['permission:manage-permission']], function() {
		Route::model('permission','\App\Permission');
		Route::post('/permission/lists','PermissionController@lists');
		Route::resource('/permission', 'PermissionController'); 
		Route::get('/save-permission','PermissionController@permission');
		Route::post('/save-permission',array('as' => 'permission.save-permission','uses' => 'PermissionController@savePermission'));
	});
	
	Route::model('chat','\App\Chat');
	Route::resource('/chat', 'ChatController',['only' => 'store']); 
	Route::post('/fetch-chat','ChatController@index');

	Route::get('/lock','HomeController@lock');
	Route::post('/lock',array('as' => 'unlock','uses' => 'HomeController@unlock'));

	Route::group(['middleware' => ['feature_available:enable_activity_log']],function() {
		Route::get('/activity-log','HomeController@activityLog');
		Route::post('/activity-log/lists','HomeController@activityLogList');
	});

	Route::get('/change-localization/{locale}','LocalizationController@changeLocalization',['middleware' => ['permission:change-localization']]);

	Route::model('user','\App\User');
	Route::resource('/user', 'UserController',['except' => ['store','edit','index','show']]); 
	Route::post('/user/{type}/lists','UserController@lists');
	Route::get('/user/{type?}','UserController@index');
	Route::get('/user/{type}/{id}','UserController@show');
	Route::post('/user/profile-update/{id}',array('as' => 'user.profile-update','uses' => 'UserController@profileUpdate'));
	Route::post('/user/social-update/{id}',array('as' => 'user.social-update','uses' => 'UserController@socialUpdate'));
	Route::post('/user/custom-field-update/{id}',array('as' => 'user.custom-field-update','uses' => 'UserController@customFieldUpdate'));
	Route::post('/user/avatar/{id}',array('as' => 'user.avatar','uses' => 'UserController@avatar'));
	Route::post('/change-user-status','UserController@changeStatus');
	Route::post('/force-change-user-password/{user_id}',array('as' => 'user.force-change-password','uses' => 'UserController@forceChangePassword'));
	Route::get('/change-password', 'UserController@changePassword');
	Route::post('/change-password',array('as'=>'change-password','uses' =>'UserController@doChangePassword'));
	Route::post('/user/{id}/email',array('as' => 'user.email', 'uses' => 'UserController@email'));
	Route::get('/profile','UserController@profile');
	Route::post('/user-detail','UserController@detail');
	Route::post('/customer-upload-column',array('as' => 'user.upload-column','uses' => 'UserController@uploadColumn'));
	Route::post('/user-upload',array('as' => 'user.upload','uses' => 'UserController@upload'));
        Route::get('/customer/create', 'UserController@store_view');

      

	Route::get('/customer-upload-log','UserUploadController@index');
	Route::post('/customer-upload/lists','UserUploadController@lists');
	Route::get('/customer-upload-log/{id}/download','UserUploadController@download');
	Route::delete('/customer-upload-log/{id}',array('uses' => 'UserUploadController@destroy','as' => 'user-upload.destroy'));
	Route::get('/customer-upload-log/{id}','UserUploadController@showFails');

	Route::model('company','\App\Company');
	Route::post('/company/lists','CompanyController@lists');
        Route::get('/company/add', 'CompanyController@store_view');
	Route::resource('/company', 'CompanyController'); 




        Route::model('neighbourhood','\App\Neighbourhood');
	Route::post('/neighbourhood/lists','NeighbourhoodController@lists');
        Route::get('/neighbourhood/add', 'NeighbourhoodController@store_view');
	Route::resource('/neighbourhood', 'NeighbourhoodController'); 



        Route::model('branch','\App\Branch');
	Route::post('/branch/lists','BranchController@lists');
        Route::get('/branch/add', 'BranchController@store_view');	
	Route::resource('/branch', 'BranchController'); 


	Route::resource('/group', 'GroupController'); 



	Route::group(['middleware' => ['feature_available:enable_coupon']],function() {
		Route::model('coupon','\App\Coupon');
		Route::post('/coupon/lists','CouponController@lists');
		Route::resource('/coupon', 'CouponController'); 
	});

	Route::model('account','\App\Account');
	Route::post('/account/lists','AccountController@lists');
	Route::post('/account/summary','AccountController@summary');
	Route::resource('/account', 'AccountController'); 

	Route::post('/currency/fetch-detail','CurrencyController@fetchDetail');
	Route::post('/add-item-row','InvoiceController@addRow');

	Route::model('invoice','\App\Invoice');
	Route::post('/invoice/lists','InvoiceController@lists');
	Route::resource('/invoice', 'InvoiceController',['except' => ['update','show','edit']]); 
	Route::get('/invoice/{uuid}','InvoiceController@show');
	Route::get('/invoice/{uuid}/edit','InvoiceController@edit');
	Route::patch('/invoice/{id}',array('as' => 'invoice.update','uses' => 'InvoiceController@store'));
	Route::post('/invoice-status','InvoiceController@fetchStatus');
	Route::post('/invoice-action-button','InvoiceController@fetchActionButton');
	Route::get('/invoice/{uuid}/print','InvoiceController@printInvoice');
	Route::get('/invoice/{uuid}/pdf','InvoiceController@pdfInvoice');
	Route::post('/invoice/mark-as-sent','InvoiceController@markAsSent');
	Route::post('/invoice/cancel','InvoiceController@cancel');
	Route::post('/invoice/undo/cancel','InvoiceController@undoCancel');
	Route::post('/invoice/copy','InvoiceController@copy');
	Route::get('/invoice/{uuid}/custom-email','InvoiceController@customEmail');
	Route::post('/invoice/{uuid}/custom-email',array('as' => 'invoice.custom-email','uses' => 'InvoiceController@postCustomEmail'));
	Route::post('/invoice/email','InvoiceController@email');
	Route::post('/invoice/fetch','InvoiceController@fetch');
	Route::post('/invoice/email/lists','InvoiceController@listEmail');
	Route::post('/invoice/{file}/download','InvoiceController@download');
      
	Route::post('/invoice-transaction/{invoice_id}/payment',array('as' => 'invoice.payment','uses' => 'InvoiceController@payment'));
	Route::post('/invoice/payment/lists','InvoiceController@listPayment');
	Route::post('/invoice/recurring/lists','InvoiceController@listRecurring');
	Route::post('/invoice/{invoice_id}/recurring',array('as' => 'invoice.recurring','uses' => 'InvoiceController@recurring'));
	Route::get('/invoice-transaction/{transaction_id}/show','InvoiceController@showPayment');
	Route::get('/invoice-transaction/{transaction_id}/edit','InvoiceController@editPayment');
	Route::post('/invoice-transaction/{transaction_id}/payment-update',array('as' => 'invoice.update-payment','uses' => 'InvoiceController@updatePayment'));
	Route::get('/invoice-transaction/{transaction_id}/withdraw','InvoiceController@withdraw');
	Route::post('/invoice-transaction/{transaction_id}/withdraw',array('as' => 'invoice.withdraw','uses' => 'InvoiceController@postWithdraw'));
	Route::post('/invoice/partial-payment','InvoiceController@partialPayment');

	Route::post('/validate-coupon','InvoiceController@validateCoupon');
	Route::post('/invoice/paypal-payment/{id}',array('as' => 'paypal','uses' => 'PaymentController@paypal'));
	Route::get('/paypal-response', 'PaymentController@paypalResponse');
	Route::post('/invoice/stripe-payment/{id}',array('as' => 'stripe','uses' => 'PaymentController@stripe'));
	Route::post('/invoice/tco-payment/{id}',array('as' => 'tco','uses' => 'PaymentController@tco'));
	Route::post('/invoice/payumoney-payment/{id}',array('as' => 'payumoney','uses' => 'PaymentController@payumoney'));
	Route::get('/payumoney-response','PaymentController@payumoneyResponse');

	Route::model('quotation','\App\Quotation');
	Route::post('/quotation/lists','QuotationController@lists');
	Route::resource('/quotation', 'QuotationController',['except' => ['update','show','edit']]); 
	Route::get('/quotation/{uuid}','QuotationController@show');
	Route::get('/quotation/{uuid}/edit','QuotationController@edit');
	Route::patch('/quotation/{id}',array('as' => 'quotation.update','uses' => 'QuotationController@store'));
	Route::post('/quotation-status','QuotationController@fetchStatus');
	Route::post('/quotation-action-button','QuotationController@fetchActionButton');
	Route::get('/quotation/{uuid}/print','QuotationController@printQuotation');
	Route::get('/quotation/{uuid}/pdf','QuotationController@pdfQuotation');
	Route::post('/quotation/mark-as-sent','QuotationController@markAsSent');
	Route::post('/quotation/mark-as-dead','QuotationController@markAsDead');
	Route::post('/quotation/cancel','QuotationController@cancel');
	Route::post('/quotation/undo/cancel','QuotationController@undoCancel');
	Route::post('/quotation/copy','QuotationController@copy');
	Route::get('/quotation/{uuid}/custom-email','QuotationController@customEmail');
	Route::post('/quotation/{uuid}/custom-email',array('as' => 'quotation.custom-email','uses' => 'QuotationController@postCustomEmail'));
	Route::post('/quotation/email','QuotationController@email');
	Route::post('/quotation/fetch','QuotationController@fetch');
	Route::post('/quotation/email/lists','QuotationController@listEmail');
	Route::post('/quotation/convert','QuotationController@convert');
	Route::post('/quotation/{file}/download','QuotationController@download');
	
	Route::post('/quotation/customer-action','QuotationController@CustomerAction');
	Route::post('/quotation-discussion','QuotationController@discussion');
	Route::post('/quotation-discussion/{quotation_id}',array('as' => 'quotation.store-discussion','uses' => 'QuotationController@storeDiscussion'));
	Route::post('/quotation-discussion-reply','QuotationController@storeDiscussionReply');

	Route::post('/invoice/graph-data','InvoiceController@graphData');

	Route::model('item','\App\Item');
	Route::post('/item/lists','ItemController@lists');
	Route::resource('/item', 'ItemController'); 
	Route::post('/item/fetch-price','ItemController@fetchPrice');

	Route::model('item_price','\App\ItemPrice');
	Route::post('/item-price/lists',['uses' => 'ItemPriceController@lists']);
	Route::resource('/item-price', 'ItemPriceController',['except' => ['show']]); 

	Route::get('/income','TransactionController@income');
	Route::get('/expense','TransactionController@expense');
	Route::get('/account-transfer','TransactionController@accountTransfer');
	Route::get('/transaction/{token}','TransactionController@show');
	Route::get('/transaction/{transaction_id}/edit','TransactionController@edit');
	Route::post('/transaction/{type}/lists','TransactionController@lists');
	Route::post('/transaction/{type}/store',array('as' => 'transaction.store','uses' => 'TransactionController@store'));
	Route::get('/transaction/{file}/download','TransactionController@download');
	Route::patch('/transaction/{transaction_id}',array('as' => 'transaction.update','uses' => 'TransactionController@update'));
	Route::delete('/transaction/{id}', array('as' => 'transaction.destroy', 'uses' => 'TransactionController@destroy'));
	Route::post('/transaction/fetch','TransactionController@fetch');

	// cfdi routes
    //Route::model('account','\App\Account');
    //Route::resource('/cfdi', 'CfdiController');

//---
});
