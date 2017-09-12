	<?php $__env->startSection('breadcrumb'); ?>
        <ul class="breadcrumb">
		    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
		    <li><a href="/invoice"><?php echo trans('messages.invoice'); ?></a></li>
		    <li class="active"><?php echo trans('messages.add_new'); ?></li>
		</ul>
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row" id="invoice-page">
			<div class="col-md-12">
				<div class="box-info">
					<?php echo Form::open(['route' => 'invoice.store','role' => 'form', 'class'=>'invoice-form','id' => 'invoice-form','data-disable-enter-submission' => '1','data-file-upload' => '.file-uploader']); ?>

					<h2><strong><?php echo e(trans('messages.add_new')); ?></strong> <?php echo e(trans('messages.invoice')); ?></h2>
					<div class="additional-btn">
						<?php if(!isset($invoice)): ?>
							<a href="/invoice" class="btn btn-danger btn-sm"><i class="fa fa-times icon"></i> <?php echo e(trans('messages.invoice_discard')); ?></a> 
						<?php endif; ?>
						<?php echo Form::submit(isset($buttonText) ? $buttonText : (trans('messages.send')),['name' => 'send_invoice','class' => 'btn btn-success btn-sm post-button','data-button-value' => 'send']); ?>

						<?php echo Form::submit(isset($buttonText) ? $buttonText : (trans('messages.save').' '.trans('messages.invoice_draft')),['name' => 'draft_invoice','class' => 'btn btn-primary btn-sm post-button','data-button-value' => 'draft']); ?>


<?php echo Form::submit(isset($buttonText) ? $buttonText : (trans('messages.preview')),['name' => 'view_invoice','class' => 'btn btn-success btn-sm post-button','data-button-value' => 'view']); ?>

					</div>
						<?php echo $__env->make('invoice._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						
					<?php echo e(getCustomFields('invoice-form',$custom_field_values)); ?>


					<div class="pull-right">
						<?php if(!isset($invoice)): ?>
							<a href="/invoice" class="btn btn-danger btn-sm"><i class="fa fa-times icon"></i> <?php echo e(trans('messages.invoice_discard')); ?></a> 
						<?php endif; ?>
						<?php echo Form::submit(isset($buttonText) ? $buttonText : (trans('messages.send')),['name' => 'send_invoice','class' => 'btn btn-success btn-sm post-button','data-button-value' => 'send']); ?>

						<?php echo Form::submit(isset($buttonText) ? $buttonText : (trans('messages.save').' '.trans('messages.invoice_draft')),['name' => 'draft_invoice','class' => 'btn btn-primary btn-sm post-button','data-button-value' => 'draft']); ?>

					</div>
					<input type="hidden" name="form_action" id="form-action" value="" readonly>
					<?php echo Form::close(); ?>

				</div>
			</div>
		</div>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>