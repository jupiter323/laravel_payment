
<?php if(!Entrust::hasRole(config('constant.default_customer_role'))): ?>
	<div class="btn-group">
		<a href="/invoice/<?php echo e($invoice->uuid); ?>/edit" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> <?php echo e(trans('messages.edit')); ?></a>

		<?php if(!$invoice->is_cancelled): ?>
			<a data-toggle="collapse" data-target="#recurring-detail" class="btn btn-sm btn-danger"><i class="fa fa-repeat"></i> <?php echo e(trans('messages.recurring')); ?></a>
			<a data-toggle="collapse" data-target="#payment-detail" class="btn btn-sm btn-success"><i class="fa fa-money"></i> <?php echo e(trans('messages.payment')); ?></a>
		<?php endif; ?>
		<a href="/invoice/<?php echo e($invoice->uuid); ?>/preview" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-print"></i> <?php echo e(trans('messages.print')); ?></a>
		<a href="/invoice/<?php echo e($invoice->uuid); ?>/pdf" class="btn btn-sm btn-info"><i class="fa fa-file-pdf-o"></i> <?php echo e(trans('messages.pdf')); ?></a>
		
		<?php if($invoice->is_cancelled): ?>
			<a href="#" data-ajax="1" data-extra="&invoice_id=<?php echo e($invoice->id); ?>" data-source="/invoice/undo/cancel" data-refresh="load-invoice-action-button,load-invoice-status" class="click-alert-message btn btn-sm btn-default"><i class="fa fa-undo"></i> <?php echo e(trans('messages.undo').' '.trans('messages.cancel').' '.trans('messages.invoice')); ?></a>
		<?php endif; ?>
	</div>

	<?php if(!$invoice->is_cancelled): ?>
		<div class="btn-group">
			<div class="btn-group">
				<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-envelope"></i> <?php echo e(trans('messages.send').' '.trans('messages.email')); ?> <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#" data-ajax="1" data-extra="&invoice_id=<?php echo e($invoice->id); ?>&email=send-invoice" data-source="/invoice/email" data-refresh="load-invoice-action-button,load-invoice-status" class="click-alert-message"><?php echo e(trans('messages.send').' '.trans('messages.invoice')); ?></a></li>
					<?php if($invoice->payment_status != 'paid' && $invoice->status == 'sent'): ?>
						<li><a href="#" data-ajax="1" data-extra="&invoice_id=<?php echo e($invoice->id); ?>&email=invoice-payment-reminder" data-source="/invoice/email" data-refresh="load-invoice-action-button" class="click-alert-message"><?php echo e(trans('messages.invoice').' '.trans('messages.payment').' '.trans('messages.reminder')); ?></a></li>
						<?php if($invoice->due_date_detail): ?>
							<li><a href="#" data-ajax="1" data-extra="&invoice_id=<?php echo e($invoice->id); ?>&email=invoice-overdue" data-source="/invoice/email" data-refresh="load-invoice-action-button" class="click-alert-message"><?php echo e(trans('messages.invoice').' 
						'.trans('messages.overdue')); ?></a></li>
						<?php endif; ?>
					<?php endif; ?>
					<li class="divider"></li>
					<li><a href="#" data-href="/invoice/<?php echo e($invoice->uuid); ?>/custom-email" data-toggle="modal" data-target="#myModal"><?php echo e(trans('messages.custom').' '.trans('messages.invoice').' '.trans('messages.email')); ?></a></li>
				</ul>
			</div>
			<div class="btn-group">
				<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-toggle-right"></i> <?php echo e(trans('messages.more')); ?> <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<?php if($invoice->status == 'draft'): ?>
						<li><a href="#" data-ajax="1" data-extra="&invoice_id=<?php echo e($invoice->id); ?>" data-source="/invoice/mark-as-sent" data-refresh="load-invoice-action-button,load-invoice-status" class="click-alert-message"><i class="fa fa-send"></i> <?php echo e(trans('messages.mark').' '.trans('messages.invoice_sent')); ?></a></li>
					<?php endif; ?>
					<li><a href="#" data-ajax="1" data-extra="&invoice_id=<?php echo e($invoice->id); ?>" data-source="/invoice/cancel" data-refresh="load-invoice-action-button,load-invoice-status" class="click-alert-message">
					<i class="fa fa-times"></i> <?php echo e(trans('messages.cancel').' '.trans('messages.invoice')); ?></a></li>
					<li><a href="#" data-ajax="1" data-extra="&invoice_id=<?php echo e($invoice->id); ?>" data-source="/invoice/copy" class="click-alert-message"><i class="fa fa-copy"></i> <?php echo e(trans('messages.copy').' '.trans('messages.invoice')); ?></a></li>
					<?php if($invoice->enable_partial_payment): ?>
						<li><a href="#" data-ajax="1" data-extra="&invoice_id=<?php echo e($invoice->id); ?>&action=disable" data-source="/invoice/partial-payment" class="click-alert-message" data-refresh="load-invoice-action-button"><i class="fa fa-money"></i> <?php echo e(trans('messages.disable').' '.trans('messages.partial').' '.trans('messages.payment')); ?></a></li>
					<?php else: ?>
						<li><a href="#" data-ajax="1" data-extra="&invoice_id=<?php echo e($invoice->id); ?>&action=enable" data-source="/invoice/partial-payment" class="click-alert-message" data-refresh="load-invoice-action-button"><i class="fa fa-money"></i> <?php echo e(trans('messages.enable').' '.trans('messages.partial').' '.trans('messages.payment')); ?></a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	<?php endif; ?>


	<?php if($invoice->is_recurring): ?>
	<span class="label label-sm label-danger"><i class="fa fa-repeat"></i> <?php echo e(trans('messages.recurring')); ?></span>
	<?php endif; ?>

	<span class="pull-right">
		<a data-toggle="collapse" data-target="#email-detail" class="btn btn-sm btn-success"><i class="fa fa-envelope"></i> <?php echo e(trans('messages.email').' '.trans('messages.log')); ?></a>
		<a href="/invoice/create" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> <?php echo e(trans('messages.new').' '.trans('messages.invoice')); ?></a>
		<?php echo delete_form(['invoice.destroy',$invoice->id],['label' => trans('messages.delete'),'size' => 'sm','redirect' => '/invoice']); ?>

	</span>
<?php elseif(Entrust::hasRole(config('constant.default_customer_role')) && config('config.enable_customer_payment')): ?>
	<div class="btn-group">
		<a data-toggle="collapse" data-target="#customer-payment-detail"  class="btn btn-sm btn-primary"><i class="fa fa-money"></i> <?php echo e(trans('messages.payment')); ?> </a>
	</div>
<?php endif; ?>