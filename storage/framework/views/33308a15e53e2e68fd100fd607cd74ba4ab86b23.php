  <li <?php echo (in_array('home',$menu)) || (in_array('income',$menu)) ? 'class="active"' : ''; ?> <?php echo menuAttr($menus,'home'); ?>><a href="" class="menu-side"><i class="fa fa-angle-double-down i-right"></i> <?php echo trans('messages.general'); ?></a>
			<ul <?php echo (
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
			) ? 'class="visible"' : ''; ?> >


<li class="no-sort <?php echo (in_array('home',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'home'); ?>><a href="/home"><i class="fa fa-home icon"></i> <?php echo trans('messages.home'); ?></a></li>



	<?php if(Entrust::can('list-account')): ?>
		<li class="no-sort <?php echo (in_array('account',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'account'); ?>><a href="/cfdis"><i class="fa fa-file-text icon"></i> <?php echo trans('messages.cfdis'); ?></a></li>
	<?php endif; ?>

	<?php if(Entrust::can('list-account')): ?>
		<li class="no-sort <?php echo (in_array('account',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'account'); ?>><a href="/account"><i class="fa fa-briefcase icon"></i> <?php echo trans('messages.accountability'); ?></a></li>
	<?php endif; ?>

	<?php if(Entrust::can('list-income') || Entrust::can('list-expense') || Entrust::can('list-account-transfer')): ?>
		<li class="no-sort <?php echo (in_array('transaction',$menu)) ? 'class="active"' : ''; ?> <?php echo menuAttr($menus,'transaction'); ?>><a href=""><i class="fa fa-random icon"></i><i class="fa fa-angle-double-down i-right"></i> <?php echo trans('messages.transaction'); ?></a>
			<ul <?php echo (
						in_array('income',$menu) ||
						in_array('expense',$menu) ||
						in_array('account_transfer',$menu)
			) ? 'class="visible"' : ''; ?>>
				<?php if(Entrust::can('list-income')): ?>
					<li class="no-sort <?php echo (in_array('income',$menu)) ? 'active' : ''; ?>"><a href="/income"><i class="fa fa-angle-right"></i> <?php echo trans('messages.income'); ?> </a></li>
				<?php endif; ?>
				<?php if(Entrust::can('list-expense')): ?>
					<li class="no-sort <?php echo (in_array('expense',$menu)) ? 'active' : ''; ?>"><a href="/expense"><i class="fa fa-angle-right"></i> <?php echo trans('messages.expense'); ?> </a></li>
				<?php endif; ?>
				<?php if(Entrust::can('list-account-transfer')): ?>
					<li class="no-sort <?php echo (in_array('account_transfer',$menu)) ? 'active' : ''; ?>"><a href="/account-transfer"><i class="fa fa-angle-right"></i> <?php echo trans('messages.account').' '.trans('messages.transfer'); ?> </a></li>
				<?php endif; ?>
			</ul>
		</li>
	<?php endif; ?>

<?php if(Entrust::can('list-customer')): ?>
		<li class="no-sort <?php echo (in_array('customer',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'customer'); ?>><a href="/user/customer"><i class="fa fa-users icon"></i><i class="fa fa-angle-double-down i-right"></i> <?php echo trans('messages.customer'); ?></a>


<ul <?php echo (
						in_array('customer_add',$menu) ||
						in_array('customer',$menu)
						
			) ? 'class="visible"' : ''; ?> >

<?php if(Entrust::can('list-customer')): ?>
					<li class="no-sort <?php echo (in_array('customer',$menu)) ? 'active' : ''; ?>"><a href="/user/customer"><i class="fa fa-angle-right"></i> <?php echo trans('messages.list_all'); ?> </a></li>
				<?php endif; ?>
				
				<?php if(Entrust::can('create-customer')): ?>
					<li class="no-sort <?php echo (in_array('customer_add',$menu)) ? 'active' : ''; ?>"><a href="/customer/create"><i class="fa fa-angle-right"></i> <?php echo trans('messages.add_new'); ?> </a></li>
				<?php endif; ?>

			</ul>











</li>
	<?php endif; ?>

	
	<?php if(Entrust::can('list-invoice')): ?>
		<li class="no-sort <?php echo (in_array('invoice',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'invoice'); ?>><a href="/invoice"><i class="fa fa-list-alt icon"></i> <?php echo trans('messages.invoice'); ?></a></li>
	<?php endif; ?>

	<?php if(Entrust::can('list-quotation')): ?>
		<li class="no-sort <?php echo (in_array('quotation',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'quotation'); ?>><a href="/quotation"><i class="fa fa-folder icon"></i> <?php echo trans('messages.quotation'); ?></a></li>
	<?php endif; ?>

    <?php if(Entrust::can('list-announcement')): ?>
		<li class="no-sort <?php echo (in_array('announcement',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'announcement'); ?>><a href="/announcement"><i class="fa fa-bullhorn icon"></i> <?php echo trans('messages.announcement'); ?></a></li>
	<?php endif; ?>

	<?php if(Entrust::can('list-staff')): ?>
		<li class="no-sort <?php echo (in_array('staff',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/user/staff"><i class="fa fa-user icon"></i> <?php echo trans('messages.staff'); ?></a></li>
    <?php endif; ?>

<?php if(Entrust::can('list-item')): ?>
		<li class="no-sort <?php echo (in_array('item',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'item'); ?>><a href="/item"><i class="fa fa-th-large icon"></i> <?php echo trans('messages.item'); ?></a></li>
	<?php endif; ?>

	<?php if(Entrust::can('manage-item-price')): ?>
		<li class="no-sort <?php echo (in_array('item_price',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'item_price'); ?>><a href="/item-price"><i class="fa fa-money icon"></i> <?php echo trans('messages.item').' '.trans('messages.price'); ?></a></li>
	</ul>
</li>

<?php endif; ?>
	



<li <?php echo (in_array('paymentgetway',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'configuration'); ?>><a href="" class="menu-side"><i class="fa fa-angle-double-down i-right"></i> <?php echo trans('messages.configuration'); ?></a>
			<ul <?php echo (
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

			) ? 'class="visible"' : ''; ?>>

      <?php if(Entrust::can('manage-configuration')): ?>
<!--<li class="no-sort <?php echo (in_array('configuration',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/configuration"><i class="fa fa-user icon"></i> <?php echo trans('messages.configuration'); ?></a></li>-->
                         <?php endif; ?>
  


<li class="no-sort <?php echo (in_array('paymentgetway',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/configuration/payment-gateway
"><i class="fa fa-user icon"></i> <?php echo trans('messages.payment').' '.trans('messages.gateway'); ?></a></li>
                         
	
<li class="no-sort <?php echo (in_array('theme',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'theme'); ?>><a href="/configuration/theme
"><i class="fa fa-user icon"></i> <?php echo trans('messages.theme'); ?></a></li>
                         
	
<li class="no-sort <?php echo (in_array('system_form',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'system'); ?>><a href="/configuration/system-form
"><i class="fa fa-user icon"></i> <?php echo trans('messages.system'); ?></a></li>

<li class="no-sort <?php echo (in_array('mail_form',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/configuration/mail
"><i class="fa fa-user icon"></i> <?php echo trans('messages.mail'); ?></a></li>
                         
	<li class="no-sort <?php echo (in_array('sms_form',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/configuration/sms
"><i class="fa fa-user icon"></i> <?php echo trans('messages.sms'); ?></a></li>

<li class="no-sort <?php echo (in_array('auth_form',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/configuration/auth
"><i class="fa fa-user icon"></i> <?php echo trans('messages.auth'); ?></a></li>

<li class="no-sort <?php echo (in_array('social_login_form',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/configuration/social-login
"><i class="fa fa-user icon"></i> <?php echo trans('messages.social_login'); ?></a></li>

<li class="no-sort <?php echo (in_array('menu_form',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/configuration/menu
"><i class="fa fa-user icon"></i> <?php echo trans('messages.menu'); ?></a></li>

<li class="no-sort <?php echo (in_array('currency_form',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/configuration/currency
"><i class="fa fa-user icon"></i> <?php echo trans('messages.currency'); ?></a></li>

<li class="no-sort <?php echo (in_array('taxation_form',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/configuration/taxation
"><i class="fa fa-user icon"></i> <?php echo trans('messages.taxation'); ?></a></li>

<li class="no-sort <?php echo (in_array('customers_form',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/configuration/customers
"><i class="fa fa-user icon"></i> <?php echo trans('messages.customers'); ?></a></li>

<li class="no-sort <?php echo (in_array('expense_form',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/configuration/expense
"><i class="fa fa-user icon"></i> <?php echo trans('messages.expense'); ?></a></li>

<li class="no-sort <?php echo (in_array('income_form',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/configuration/income
"><i class="fa fa-user icon"></i> <?php echo trans('messages.income'); ?></a></li>

<li class="no-sort <?php echo (in_array('items_form',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/configuration/items
"><i class="fa fa-user icon"></i> <?php echo trans('messages.items'); ?></a></li>

<li class="no-sort <?php echo (in_array('invoice_form',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/configuration/invoice
"><i class="fa fa-user icon"></i> <?php echo trans('messages.invoices'); ?></a></li>

<li class="no-sort <?php echo (in_array('quotations_form',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/configuration/quotations
"><i class="fa fa-user icon"></i> <?php echo trans('messages.quotations'); ?></a></li>

<li class="no-sort <?php echo (in_array('payments_form',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/configuration/payments
"><i class="fa fa-user icon"></i> <?php echo trans('messages.payment'); ?></a></li>

<li class="no-sort <?php echo (in_array('schedule_form',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/configuration/schedule-job
"><i class="fa fa-user icon"></i> <?php echo trans('messages.schedule'); ?></a></li>






	<?php if(config('config.enable_coupon') && Entrust::can('list-coupon')): ?>
		<li <?php echo (in_array('coupon',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'coupon'); ?>><a href="/coupon"><i class="fa fa-gift icon"></i> <?php echo trans('messages.coupon'); ?></a></li>
    <?php endif; ?>
    
    <?php if(!Entrust::hasRole(config('constant.default_customer_role')) && config('config.enable_message') && Entrust::can('manage-message')): ?>
    	<li <?php echo (in_array('message',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'message'); ?>><a href="/message"><i class="fa fa-envelope icon"></i> <?php echo trans('messages.message'); ?>

		<?php if($inbox_count): ?>
			<span class="badge badge-danger animated double pull-right"><?php echo e($inbox_count); ?></span>
		<?php endif; ?>
    	</a></li>
    <?php endif; ?>
</ul>
</li>

<li <?php echo (in_array('coupon',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'coupon'); ?>><a href="" class="menu-side"><i class="fa fa-angle-double-down i-right"></i> <?php echo trans('messages.advanced'); ?></a>
			<ul <?php echo (
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
			) ? 'class="visible"' : ''; ?>>

<?php if(Entrust::can('list-company') || Entrust::can('create-company')): ?>
		<li class="no-sort <?php echo (in_array('company',$menu))  ? 'active' : ''; ?> <?php echo menuAttr($menus,'company'); ?>><a href="/company"><i class="fa fa-building icon"></i><i class="fa fa-angle-double-down i-right"></i>  <?php echo trans('messages.company'); ?></a>


<ul <?php echo (
						in_array('company_add',$menu) ||
						in_array('company',$menu)
						
			) ? 'class="visible"' : ''; ?> >

<?php if(Entrust::can('list-company')): ?>
					<li class="no-sort <?php echo (in_array('company',$menu)) ? 'active' : ''; ?>"><a href="/company"><i class="fa fa-angle-right"></i> <?php echo trans('messages.list_all'); ?> </a></li>
				<?php endif; ?>
				
				<?php if(Entrust::can('create-company')): ?>
					<li class="no-sort <?php echo (in_array('company_add',$menu)) ? 'active' : ''; ?>"><a href="/company/add"><i class="fa fa-angle-right"></i> <?php echo trans('messages.add_new'); ?> </a></li>
				<?php endif; ?>

			</ul>
</li>
	<?php endif; ?>



<?php if(Entrust::can('list-company') || Entrust::can('create-company')): ?>
		<li class="no-sort <?php echo (in_array('branch',$menu))  ? 'active' : ''; ?> <?php echo menuAttr($menus,'company'); ?>><a href="/branch"><i class="fa fa-building icon"></i><i class="fa fa-angle-double-down i-right"></i>  <?php echo trans('messages.branch'); ?></a>


<ul <?php echo (
						in_array('branch_add',$menu) ||
						in_array('branch',$menu)
						
			) ? 'class="visible"' : ''; ?> >

<?php if(Entrust::can('list-company')): ?>
					<li class="no-sort <?php echo (in_array('branch',$menu)) ? 'active' : ''; ?>"><a href="/branch"><i class="fa fa-angle-right"></i> <?php echo trans('messages.list_all'); ?> </a></li>
				<?php endif; ?>
				
				<?php if(Entrust::can('create-company')): ?>
					<li class="no-sort <?php echo (in_array('branch_add',$menu)) ? 'active' : ''; ?>"><a href="/branch/add"><i class="fa fa-angle-right"></i> <?php echo trans('messages.add_new'); ?> </a></li>
				<?php endif; ?>

			</ul>
</li>
	<?php endif; ?>


<?php if(Entrust::can('manage-role')): ?>	
	<li class="no-sort <?php echo (in_array('role',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/role"><i class="fa fa-user icon"></i> <?php echo trans('messages.role').' '.trans('messages.configuration'); ?></a></li>
    <?php endif; ?>

<?php if(Entrust::can('manage-permission')): ?>
		<li class="no-sort <?php echo (in_array('permissions',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/permission"><i class="fa fa-th-large icon"></i> <?php echo trans('messages.permission'); ?></a></li>
	<?php endif; ?>

	<?php if(Entrust::can('list-department')): ?>
		<li class="no-sort <?php echo (in_array('department',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/department"><i class="fa fa-money icon"></i> <?php echo trans('messages.department'); ?></a></li>
	<?php endif; ?>


<?php if(Entrust::can('list-designation')): ?>
		<li class="no-sort <?php echo (in_array('designation',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/designation"><i class="fa fa-money icon"></i> <?php echo trans('messages.designation'); ?></a></li>
	<?php endif; ?>

<?php if(Entrust::can('manage-configuration')): ?>
		<li class="no-sort <?php echo (in_array('currency_conversion',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/currency-conversion"><i class="fa fa-money icon"></i> <?php echo trans('messages.currency').' '.trans('messages.conversion'); ?></a></li>
	<?php endif; ?>

<?php if(config('config.multilingual') && Entrust::can('manage-localization')): ?>
		<li class="no-sort <?php echo (in_array('localization',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/localization"><i class="fa fa-money icon"></i> <?php echo trans('messages.localization'); ?></a></li>
	<?php endif; ?>


 <?php if(config('config.enable_custom_field') && Entrust::can('manage-custom-field')): ?>	
	<li class="no-sort <?php echo (in_array('custom_field',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/custom-field"><i class="fa fa-money icon"></i> <?php echo trans('messages.custom'); ?></a></li>
	<?php endif; ?>

<?php if(config('config.enable_ip_filter') && Entrust::can('manage-ip-filter')): ?>
		<li class="no-sort <?php echo (in_array('filter',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/ip-filter"><i class="fa fa-money icon"></i> <?php echo trans('messages.filter'); ?></a></li>
	<?php endif; ?>

<?php if(Entrust::can('manage-template')): ?>
		<li class="no-sort <?php echo (in_array('template',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/template"><i class="fa fa-money icon"></i> <?php echo trans('messages.email').' '.trans('messages.template'); ?></a></li>
	<?php endif; ?>


<?php if(Entrust::can('manage-campaign')): ?>
		<li class="no-sort <?php echo (in_array('campaign',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/campaign"><i class="fa fa-money icon"></i> <?php echo trans('messages.email').' '.trans('messages.campaign'); ?></a></li>
	<?php endif; ?>
          <?php if(!Entrust::hasRole(config('constant.default_customer_role'))): ?>
		<li class="no-sort <?php echo (in_array('activity',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/activity-log"><i class="fa fa-money icon"></i> <?php echo trans('messages.activity').' '.trans('messages.log'); ?></a></li>
	<?php endif; ?>

<?php if(Entrust::can('manage-email-log')): ?>
		<li class="no-sort <?php echo (in_array('email_log',$menu)) ? 'active' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/email"><i class="fa fa-money icon"></i> <?php echo trans('messages.email').' '.trans('messages.log'); ?></a></li>
	<?php endif; ?>

<?php if(Entrust::can('manage-backup')): ?>
		<li class="no-sort <?php echo (in_array('backup',$menu)) ? 'active"' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/backup"><i class="fa fa-money icon"></i> <?php echo trans('messages.database').' '.trans('messages.backup'); ?></a></li>
	<?php endif; ?>


</ul></li>

	<?php if(Entrust::hasRole(config('constant.default_customer_role'))): ?>
		<li><a href="/profile"><i class="fa fa-user icon"></i> <?php echo trans('messages.profile'); ?></a></li>
		<li><a href="#" data-href="/change-password" data-toggle="modal" data-target="#myModal"><i class="fa fa-key icon"></i> <?php echo trans('messages.change').' '.trans('messages.password'); ?></a></li>
		<li><a href="#" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"><i class="fa fa-sign-out icon"></i> <?php echo trans('messages.logout'); ?></a></li>
	<?php endif; ?>


<script>
$("#sidebar-menu-list li a").click(function() {
  console.log("hi");
});
</script>

                        
                           

                              
                                

