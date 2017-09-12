
	<li <?php echo (in_array('home',$menu)) ? 'class="active"' : ''; ?> <?php echo menuAttr($menus,'home'); ?>><a href="/home"><i class="fa fa-home icon"></i> <?php echo trans('messages.home'); ?></a></li>
	
	<?php if(Entrust::can('list-customer')): ?>
		<li <?php echo (in_array('customer',$menu)) ? 'class="active"' : ''; ?> <?php echo menuAttr($menus,'customer'); ?>><a href="/user/customer"><i class="fa fa-users icon"></i> <?php echo trans('messages.customer'); ?></a></li>
	<?php endif; ?>

	<?php if(Entrust::can('list-company')): ?>
		<li <?php echo (in_array('company',$menu)) ? 'class="active"' : ''; ?> <?php echo menuAttr($menus,'company'); ?>><a href="/company"><i class="fa fa-building icon"></i> <?php echo trans('messages.company'); ?></a></li>
	<?php endif; ?>

	<?php if(Entrust::can('list-account')): ?>
		<li <?php echo (in_array('account',$menu)) ? 'class="active"' : ''; ?> <?php echo menuAttr($menus,'account'); ?>><a href="/account"><i class="fa fa-briefcase icon"></i> <?php echo trans('messages.account'); ?></a></li>
	<?php endif; ?>

	<?php if(Entrust::can('list-income') || Entrust::can('list-expense') || Entrust::can('list-account-transfer')): ?>
		<li <?php echo (in_array('transaction',$menu)) ? 'class="active"' : ''; ?> <?php echo menuAttr($menus,'transaction'); ?>><a href=""><i class="fa fa-random icon"></i><i class="fa fa-angle-double-down i-right"></i> <?php echo trans('messages.transaction'); ?></a>
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

	<?php if(Entrust::can('list-item')): ?>
		<li <?php echo (in_array('item',$menu)) ? 'class="active"' : ''; ?> <?php echo menuAttr($menus,'item'); ?>><a href="/item"><i class="fa fa-th-large icon"></i> <?php echo trans('messages.item'); ?></a></li>
	<?php endif; ?>

	<?php if(Entrust::can('manage-item-price')): ?>
		<li <?php echo (in_array('item_price',$menu)) ? 'class="active"' : ''; ?> <?php echo menuAttr($menus,'item_price'); ?>><a href="/item-price"><i class="fa fa-money icon"></i> <?php echo trans('messages.item').' '.trans('messages.price'); ?></a></li>
	<?php endif; ?>
	
	<?php if(Entrust::can('list-invoice')): ?>
		<li <?php echo (in_array('invoice',$menu)) ? 'class="active"' : ''; ?> <?php echo menuAttr($menus,'invoice'); ?>><a href="/invoice"><i class="fa fa-list-alt icon"></i> <?php echo trans('messages.invoice'); ?></a></li>
	<?php endif; ?>

	<?php if(Entrust::can('list-quotation')): ?>
		<li <?php echo (in_array('quotation',$menu)) ? 'class="active"' : ''; ?> <?php echo menuAttr($menus,'quotation'); ?>><a href="/quotation"><i class="fa fa-folder icon"></i> <?php echo trans('messages.quotation'); ?></a></li>
	<?php endif; ?>

    <?php if(Entrust::can('list-announcement')): ?>
		<li <?php echo (in_array('announcement',$menu)) ? 'class="active"' : ''; ?> <?php echo menuAttr($menus,'announcement'); ?>><a href="/announcement"><i class="fa fa-bullhorn icon"></i> <?php echo trans('messages.announcement'); ?></a></li>
	<?php endif; ?>

	<?php if(Entrust::can('list-staff')): ?>
		<li <?php echo (in_array('staff',$menu)) ? 'class="active"' : ''; ?> <?php echo menuAttr($menus,'staff'); ?>><a href="/user/staff"><i class="fa fa-user icon"></i> <?php echo trans('messages.staff'); ?></a></li>
    <?php endif; ?>

	<?php if(config('config.enable_coupon') && Entrust::can('list-coupon')): ?>
		<li <?php echo (in_array('coupon',$menu)) ? 'class="active"' : ''; ?> <?php echo menuAttr($menus,'coupon'); ?>><a href="/coupon"><i class="fa fa-gift icon"></i> <?php echo trans('messages.coupon'); ?></a></li>
    <?php endif; ?>
    
    <?php if(!Entrust::hasRole(config('constant.default_customer_role')) && config('config.enable_message') && Entrust::can('manage-message')): ?>
    	<li <?php echo (in_array('message',$menu)) ? 'class="active"' : ''; ?> <?php echo menuAttr($menus,'message'); ?>><a href="/message"><i class="fa fa-envelope icon"></i> <?php echo trans('messages.message'); ?>

		<?php if($inbox_count): ?>
			<span class="badge badge-danger animated double pull-right"><?php echo e($inbox_count); ?></span>
		<?php endif; ?>
    	</a></li>
    <?php endif; ?>

	<?php if(Entrust::hasRole(config('constant.default_customer_role'))): ?>
		<li><a href="/profile"><i class="fa fa-user icon"></i> <?php echo trans('messages.profile'); ?></a></li>
		<li><a href="#" data-href="/change-password" data-toggle="modal" data-target="#myModal"><i class="fa fa-key icon"></i> <?php echo trans('messages.change').' '.trans('messages.password'); ?></a></li>
		<li><a href="#" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"><i class="fa fa-sign-out icon"></i> <?php echo trans('messages.logout'); ?></a></li>
	<?php endif; ?>