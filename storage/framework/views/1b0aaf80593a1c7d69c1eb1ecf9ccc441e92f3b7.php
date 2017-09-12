

	<?php $__env->startSection('breadcrumb'); ?>
        <ul class="breadcrumb">
		    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
		    <li><a href="/quotation"><?php echo trans('messages.quotation'); ?></a></li>
		    <li class="active"><?php echo trans('messages.add_new'); ?></li>
		</ul>
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row" id="invoice-page">
			<div class="col-md-12">
				<div class="box-info">
					<?php echo Form::open(['route' => 'quotation.store','role' => 'form', 'class'=>'quotation-form','id' => 'quotation-form','data-file-upload' => '.file-uploader']); ?>

					<h2><strong><?php echo e(trans('messages.add_new')); ?></strong> <?php echo e(trans('messages.quotation')); ?></h2>
					<div class="additional-btn">
						<?php if(!isset($quotation)): ?>
							<a href="/quotation" class="btn btn-danger btn-sm"><i class="fa fa-times icon"></i> <?php echo e(trans('messages.invoice_discard')); ?></a> 
						<?php endif; ?>
						<?php echo Form::submit(isset($buttonText) ? $buttonText : (trans('messages.send')),['name' => 'send_quotation','class' => 'btn btn-success btn-sm post-button','data-button-value' => 'send']); ?>

						<?php echo Form::submit(isset($buttonText) ? $buttonText : (trans('messages.save').' '.trans('messages.invoice_draft')),['name' => 'draft_quotation','class' => 'btn btn-primary btn-sm post-button','data-button-value' => 'draft']); ?>

					</div>
						<?php echo $__env->make('quotation._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						<?php echo e(getCustomFields('quotation-form',$custom_field_values)); ?>


						<div class="pull-right">
							<?php if(!isset($quotation)): ?>
								<a href="/quotation" class="btn btn-danger btn-sm"><i class="fa fa-times icon"></i> <?php echo e(trans('messages.invoice_discard')); ?></a> 
							<?php endif; ?>
							<?php echo Form::submit(isset($buttonText) ? $buttonText : (trans('messages.send')),['name' => 'send_quotation','class' => 'btn btn-success btn-sm post-button','data-button-value' => 'send']); ?>

							<?php echo Form::submit(isset($buttonText) ? $buttonText : (trans('messages.save').' '.trans('messages.invoice_draft')),['name' => 'draft_quotation','class' => 'btn btn-primary btn-sm post-button','data-button-value' => 'draft']); ?>

						</div>
						<input type="hidden" name="form_action" id="form-action" value="" readonly>
					<?php echo Form::close(); ?>

				</div>
			</div>
		</div>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>