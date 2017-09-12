

	<?php $__env->startSection('breadcrumb'); ?>
		<ul class="breadcrumb">
		    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
		    <li><a href="/invoice"><?php echo trans('messages.invoice'); ?></a></li>
		    <li class="active"><?php echo $invoice->Customer->full_name; ?></li>
		</ul>
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row" id="invoice-page">
			<div class="col-md-12">
			<?php echo Form::model($invoice,['method' => 'PATCH','route' => ['invoice.update',$invoice->id] ,'class' => 'invoice-edit-form','id' => 'invoice-edit-form','data-file-upload' => '.file-uploader']); ?>

			<div class="box-info">
				<h2><strong><?php echo e(trans('messages.edit')); ?></strong> <?php echo e(trans('messages.invoice')); ?>

				</h2>
				<div class="additional-btn">
					<a href="/invoice/<?php echo e($invoice->uuid); ?>" class="btn btn-danger btn-sm"><i class="fa fa-times icon"></i> <?php echo e(trans('messages.cancel').' '.trans('messages.edit')); ?></a> 
					<?php echo Form::submit(trans('messages.update'),['class' => 'btn btn-primary btn-sm']); ?>

				</div>
				<?php echo $__env->make('invoice._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				<?php echo e(getCustomFields('invoice-form',$custom_field_values)); ?>


				<div class="pull-right">
					<a href="/invoice/<?php echo e($invoice->uuid); ?>" class="btn btn-danger"><i class="fa fa-times icon"></i> <?php echo e(trans('messages.cancel').' '.trans('messages.edit')); ?></a> 
					<?php echo Form::submit(trans('messages.update'),['class' => 'btn btn-primary']); ?>

				</div>
			</div>
			<?php echo Form::close(); ?>

			</div>
		</div>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>