  <li {!! (in_array('home',$menu)) || (in_array('income',$menu)) ? 'class="active"' : '' !!} {!! menuAttr($menus,'home') !!}><a href="" class="menu-side"><i class="fa fa-angle-double-down i-right"></i> {!! trans('messages.general') !!}</a>
			<ul {!! (
						in_array('home',$menu) ||
						in_array('customer',$menu) ||
                                                in_array('customer_add',$menu) ||
                                                in_array('account',$menu) ||
                                                in_array('transaction',$menu) ||
                                                in_array('invoice',$menu) ||
                                                in_array('quotation',$menu) ||
                                                in_array('announcement',$menu) ||
                                                in_array('staff',$menu) ||
                                                in_array('item',$menu) ||
                                                in_array('item_price',$menu) 
			) ? 'class="visible"' : '' !!} >


<li class="no-sort {!! (in_array('home',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'home') !!}><a href="/home"><i class="fa fa-home icon"></i> {!! trans('messages.home') !!}</a></li>



	@if(Entrust::can('list-account'))
		<li class="no-sort {!! (in_array('account',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'account') !!}><a href="/cfdis"><i class="fa fa-file-text icon"></i> {!! trans('messages.cfdis') !!}</a></li>
	@endif

	@if(Entrust::can('list-account'))
		<li class="no-sort {!! (in_array('account',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'account') !!}><a href="/account"><i class="fa fa-briefcase icon"></i> {!! trans('messages.accountability') !!}</a></li>
	@endif

	@if(Entrust::can('list-income') || Entrust::can('list-expense') || Entrust::can('list-account-transfer'))
		<li class="no-sort {!! (in_array('transaction',$menu)) ? 'class="active"' : '' !!} {!! menuAttr($menus,'transaction') !!}><a href=""><i class="fa fa-random icon"></i><i class="fa fa-angle-double-down i-right"></i> {!! trans('messages.transaction') !!}</a>
			<ul {!! (
						in_array('income',$menu) ||
						in_array('expense',$menu) ||
						in_array('account_transfer',$menu)
			) ? 'class="visible"' : '' !!}>
				@if(Entrust::can('list-income'))
					<li class="no-sort {!! (in_array('income',$menu)) ? 'active' : '' !!}"><a href="/income"><i class="fa fa-angle-right"></i> {!! trans('messages.income') !!} </a></li>
				@endif
				@if(Entrust::can('list-expense'))
					<li class="no-sort {!! (in_array('expense',$menu)) ? 'active' : '' !!}"><a href="/expense"><i class="fa fa-angle-right"></i> {!! trans('messages.expense') !!} </a></li>
				@endif
				@if(Entrust::can('list-account-transfer'))
					<li class="no-sort {!! (in_array('account_transfer',$menu)) ? 'active' : '' !!}"><a href="/account-transfer"><i class="fa fa-angle-right"></i> {!! trans('messages.account').' '.trans('messages.transfer') !!} </a></li>
				@endif
			</ul>
		</li>
	@endif

@if(Entrust::can('list-customer'))
		<li class="no-sort {!! (in_array('customer',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'customer') !!}><a href="/user/customer"><i class="fa fa-users icon"></i><i class="fa fa-angle-double-down i-right"></i> {!! trans('messages.customer') !!}</a>


<ul {!! (
						in_array('customer_add',$menu) ||
						in_array('customer',$menu)
						
			) ? 'class="visible"' : '' !!} >

@if(Entrust::can('list-customer'))
					<li class="no-sort {!! (in_array('customer',$menu)) ? 'active' : '' !!}"><a href="/user/customer"><i class="fa fa-angle-right"></i> {!! trans('messages.list_all') !!} </a></li>
				@endif
				
				@if(Entrust::can('create-customer'))
					<li class="no-sort {!! (in_array('customer_add',$menu)) ? 'active' : '' !!}"><a href="/customer/create"><i class="fa fa-angle-right"></i> {!! trans('messages.add_new') !!} </a></li>
				@endif

			</ul>











</li>
	@endif

	
	@if(Entrust::can('list-invoice'))
		<li class="no-sort {!! (in_array('invoice',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'invoice') !!}><a href="/invoice"><i class="fa fa-list-alt icon"></i> {!! trans('messages.invoice') !!}</a></li>
	@endif

	@if(Entrust::can('list-quotation'))
		<li class="no-sort {!! (in_array('quotation',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'quotation') !!}><a href="/quotation"><i class="fa fa-folder icon"></i> {!! trans('messages.quotation') !!}</a></li>
	@endif

    @if(Entrust::can('list-announcement'))
		<li class="no-sort {!! (in_array('announcement',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'announcement') !!}><a href="/announcement"><i class="fa fa-bullhorn icon"></i> {!! trans('messages.announcement') !!}</a></li>
	@endif

	@if(Entrust::can('list-staff'))
		<li class="no-sort {!! (in_array('staff',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/user/staff"><i class="fa fa-user icon"></i> {!! trans('messages.staff') !!}</a></li>
    @endif

@if(Entrust::can('list-item'))
		<li class="no-sort {!! (in_array('item',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'item') !!}><a href="/item"><i class="fa fa-th-large icon"></i> {!! trans('messages.item') !!}</a></li>
	@endif

	@if(Entrust::can('manage-item-price'))
		<li class="no-sort {!! (in_array('item_price',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'item_price') !!}><a href="/item-price"><i class="fa fa-money icon"></i> {!! trans('messages.item').' '.trans('messages.price') !!}</a></li>
	</ul>
</li>

@endif
	



<li {!! (in_array('paymentgetway',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'configuration') !!}><a href="" class="menu-side"><i class="fa fa-angle-double-down i-right"></i> {!! trans('messages.configuration') !!}</a>
			<ul {!! (
						in_array('paymentgetway',$menu) ||
                                                in_array('system_form',$menu) ||

in_array('theme',$menu) ||
in_array('mail_form',$menu) ||
in_array('sms_form',$menu) ||
in_array('auth_form',$menu) ||
in_array('social_login_form',$menu) ||
in_array('menu_form',$menu) ||
in_array('currency_form',$menu) ||
in_array('taxation_form',$menu) ||
in_array('customers_form',$menu) ||
in_array('expense_form',$menu) ||
in_array('income_form',$menu) ||
in_array('items_form',$menu) ||
in_array('invoice_form',$menu) ||
in_array('quotations_form',$menu) ||
in_array('payments_form',$menu) ||
in_array('schedule_form',$menu) 

			) ? 'class="visible"' : '' !!}>

      @if(Entrust::can('manage-configuration'))
<!--<li class="no-sort {!! (in_array('configuration',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/configuration"><i class="fa fa-user icon"></i> {!! trans('messages.configuration') !!}</a></li>-->
                         @endif
  


<li class="no-sort {!! (in_array('paymentgetway',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/configuration/payment-gateway
"><i class="fa fa-user icon"></i> {!! trans('messages.payment').' '.trans('messages.gateway') !!}</a></li>
                         
	
<li class="no-sort {!! (in_array('theme',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'theme') !!}><a href="/configuration/theme
"><i class="fa fa-user icon"></i> {!! trans('messages.theme') !!}</a></li>
                         
	
<li class="no-sort {!! (in_array('system_form',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'system') !!}><a href="/configuration/system-form
"><i class="fa fa-user icon"></i> {!! trans('messages.system') !!}</a></li>

<li class="no-sort {!! (in_array('mail_form',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/configuration/mail
"><i class="fa fa-user icon"></i> {!! trans('messages.mail') !!}</a></li>
                         
	<li class="no-sort {!! (in_array('sms_form',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/configuration/sms
"><i class="fa fa-user icon"></i> {!! trans('messages.sms') !!}</a></li>

<li class="no-sort {!! (in_array('auth_form',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/configuration/auth
"><i class="fa fa-user icon"></i> {!! trans('messages.auth') !!}</a></li>

<li class="no-sort {!! (in_array('social_login_form',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/configuration/social-login
"><i class="fa fa-user icon"></i> {!! trans('messages.social_login') !!}</a></li>

<li class="no-sort {!! (in_array('menu_form',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/configuration/menu
"><i class="fa fa-user icon"></i> {!! trans('messages.menu') !!}</a></li>

<li class="no-sort {!! (in_array('currency_form',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/configuration/currency
"><i class="fa fa-user icon"></i> {!! trans('messages.currency') !!}</a></li>

<li class="no-sort {!! (in_array('taxation_form',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/configuration/taxation
"><i class="fa fa-user icon"></i> {!! trans('messages.taxation') !!}</a></li>

<li class="no-sort {!! (in_array('customers_form',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/configuration/customers
"><i class="fa fa-user icon"></i> {!! trans('messages.customers') !!}</a></li>

<li class="no-sort {!! (in_array('expense_form',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/configuration/expense
"><i class="fa fa-user icon"></i> {!! trans('messages.expense') !!}</a></li>

<li class="no-sort {!! (in_array('income_form',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/configuration/income
"><i class="fa fa-user icon"></i> {!! trans('messages.income') !!}</a></li>

<li class="no-sort {!! (in_array('items_form',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/configuration/items
"><i class="fa fa-user icon"></i> {!! trans('messages.items') !!}</a></li>

<li class="no-sort {!! (in_array('invoice_form',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/configuration/invoice
"><i class="fa fa-user icon"></i> {!! trans('messages.invoices') !!}</a></li>

<li class="no-sort {!! (in_array('quotations_form',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/configuration/quotations
"><i class="fa fa-user icon"></i> {!! trans('messages.quotations') !!}</a></li>

<li class="no-sort {!! (in_array('payments_form',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/configuration/payments
"><i class="fa fa-user icon"></i> {!! trans('messages.payment') !!}</a></li>

<li class="no-sort {!! (in_array('schedule_form',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/configuration/schedule-job
"><i class="fa fa-user icon"></i> {!! trans('messages.schedule') !!}</a></li>






	@if(config('config.enable_coupon') && Entrust::can('list-coupon'))
		<li {!! (in_array('coupon',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'coupon') !!}><a href="/coupon"><i class="fa fa-gift icon"></i> {!! trans('messages.coupon') !!}</a></li>
    @endif
    
    @if(!Entrust::hasRole(config('constant.default_customer_role')) && config('config.enable_message') && Entrust::can('manage-message'))
    	<li {!! (in_array('message',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'message') !!}><a href="/message"><i class="fa fa-envelope icon"></i> {!! trans('messages.message') !!}
		@if($inbox_count)
			<span class="badge badge-danger animated double pull-right">{{$inbox_count}}</span>
		@endif
    	</a></li>
    @endif
</ul>
</li>

<li {!! (in_array('coupon',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'coupon') !!}><a href="" class="menu-side"><i class="fa fa-angle-double-down i-right"></i> {!! trans('messages.advanced') !!}</a>
			<ul {!! (
						in_array('company',$menu) ||
                                                in_array('company_add',$menu) ||
                                                in_array('branch',$menu) ||
						in_array('branch_add',$menu)  ||
                                                 in_array('role',$menu)  ||
						in_array('permissions',$menu)  ||
						in_array('department',$menu)  ||
						in_array('designation',$menu)  ||
						in_array('currency_conversion',$menu)  ||
						in_array('localization',$menu)  ||
						in_array('custom_field',$menu)  ||
						in_array('filter',$menu)  ||
						in_array('template',$menu) ||
						in_array('campaign',$menu) ||
						in_array('email',$menu) ||
						in_array('activity',$menu) ||
						in_array('email_log',$menu) ||
						in_array('backup',$menu) 
			) ? 'class="visible"' : '' !!}>

@if(Entrust::can('list-company') || Entrust::can('create-company'))
		<li class="no-sort {!! (in_array('company',$menu))  ? 'active' : '' !!} {!! menuAttr($menus,'company') !!}><a href="/company"><i class="fa fa-building icon"></i><i class="fa fa-angle-double-down i-right"></i>  {!! trans('messages.company') !!}</a>


<ul {!! (
						in_array('company_add',$menu) ||
						in_array('company',$menu)
						
			) ? 'class="visible"' : '' !!} >

@if(Entrust::can('list-company'))
					<li class="no-sort {!! (in_array('company',$menu)) ? 'active' : '' !!}"><a href="/company"><i class="fa fa-angle-right"></i> {!! trans('messages.list_all') !!} </a></li>
				@endif
				
				@if(Entrust::can('create-company'))
					<li class="no-sort {!! (in_array('company_add',$menu)) ? 'active' : '' !!}"><a href="/company/add"><i class="fa fa-angle-right"></i> {!! trans('messages.add_new') !!} </a></li>
				@endif

			</ul>
</li>
	@endif



@if(Entrust::can('list-company') || Entrust::can('create-company'))
		<li class="no-sort {!! (in_array('branch',$menu))  ? 'active' : '' !!} {!! menuAttr($menus,'company') !!}><a href="/branch"><i class="fa fa-building icon"></i><i class="fa fa-angle-double-down i-right"></i>  {!! trans('messages.branch') !!}</a>


<ul {!! (
						in_array('branch_add',$menu) ||
						in_array('branch',$menu)
						
			) ? 'class="visible"' : '' !!} >

@if(Entrust::can('list-company'))
					<li class="no-sort {!! (in_array('branch',$menu)) ? 'active' : '' !!}"><a href="/branch"><i class="fa fa-angle-right"></i> {!! trans('messages.list_all') !!} </a></li>
				@endif
				
				@if(Entrust::can('create-company'))
					<li class="no-sort {!! (in_array('branch_add',$menu)) ? 'active' : '' !!}"><a href="/branch/add"><i class="fa fa-angle-right"></i> {!! trans('messages.add_new') !!} </a></li>
				@endif

			</ul>
</li>
	@endif


@if(Entrust::can('manage-role'))	
	<li class="no-sort {!! (in_array('role',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/role"><i class="fa fa-user icon"></i> {!! trans('messages.role').' '.trans('messages.configuration') !!}</a></li>
    @endif

@if(Entrust::can('manage-permission'))
		<li class="no-sort {!! (in_array('permissions',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/permission"><i class="fa fa-th-large icon"></i> {!! trans('messages.permission') !!}</a></li>
	@endif

	@if(Entrust::can('list-department'))
		<li class="no-sort {!! (in_array('department',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/department"><i class="fa fa-money icon"></i> {!! trans('messages.department') !!}</a></li>
	@endif


@if(Entrust::can('list-designation'))
		<li class="no-sort {!! (in_array('designation',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/designation"><i class="fa fa-money icon"></i> {!! trans('messages.designation') !!}</a></li>
	@endif

@if(Entrust::can('manage-configuration'))
		<li class="no-sort {!! (in_array('currency_conversion',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/currency-conversion"><i class="fa fa-money icon"></i> {!! trans('messages.currency').' '.trans('messages.conversion') !!}</a></li>
	@endif

@if(config('config.multilingual') && Entrust::can('manage-localization'))
		<li class="no-sort {!! (in_array('localization',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/localization"><i class="fa fa-money icon"></i> {!! trans('messages.localization') !!}</a></li>
	@endif


 @if(config('config.enable_custom_field') && Entrust::can('manage-custom-field'))	
	<li class="no-sort {!! (in_array('custom_field',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/custom-field"><i class="fa fa-money icon"></i> {!! trans('messages.custom') !!}</a></li>
	@endif

@if(config('config.enable_ip_filter') && Entrust::can('manage-ip-filter'))
		<li class="no-sort {!! (in_array('filter',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/ip-filter"><i class="fa fa-money icon"></i> {!! trans('messages.filter') !!}</a></li>
	@endif

@if(Entrust::can('manage-template'))
		<li class="no-sort {!! (in_array('template',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/template"><i class="fa fa-money icon"></i> {!! trans('messages.email').' '.trans('messages.template') !!}</a></li>
	@endif


@if(Entrust::can('manage-campaign'))
		<li class="no-sort {!! (in_array('campaign',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/campaign"><i class="fa fa-money icon"></i> {!! trans('messages.email').' '.trans('messages.campaign') !!}</a></li>
	@endif
          @if(!Entrust::hasRole(config('constant.default_customer_role')))
		<li class="no-sort {!! (in_array('activity',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/activity-log"><i class="fa fa-money icon"></i> {!! trans('messages.activity').' '.trans('messages.log') !!}</a></li>
	@endif

@if(Entrust::can('manage-email-log'))
		<li class="no-sort {!! (in_array('email_log',$menu)) ? 'active' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/email"><i class="fa fa-money icon"></i> {!! trans('messages.email').' '.trans('messages.log') !!}</a></li>
	@endif

@if(Entrust::can('manage-backup'))
		<li class="no-sort {!! (in_array('backup',$menu)) ? 'active"' : '' !!} {!! menuAttr($menus,'staff') !!}><a href="/backup"><i class="fa fa-money icon"></i> {!! trans('messages.database').' '.trans('messages.backup') !!}</a></li>
	@endif


</ul></li>

	@if(Entrust::hasRole(config('constant.default_customer_role')))
		<li><a href="/profile"><i class="fa fa-user icon"></i> {!! trans('messages.profile') !!}</a></li>
		<li><a href="#" data-href="/change-password" data-toggle="modal" data-target="#myModal"><i class="fa fa-key icon"></i> {!! trans('messages.change').' '.trans('messages.password') !!}</a></li>
		<li><a href="#" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"><i class="fa fa-sign-out icon"></i> {!! trans('messages.logout') !!}</a></li>
	@endif


<script>
$("#sidebar-menu-list li a").click(function() {
  console.log("hi");
});
</script>

                        
                           

                              
                                

