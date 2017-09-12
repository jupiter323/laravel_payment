
    <?php $__env->startSection('content'); ?>
		<div class="full-content-center animated bounceIn">
    		
    		<?php echo getCompanyLogo(); ?>

    		
			<h2><?php echo e(trans('messages.error')); ?></h2>
			<p><?php echo e(trans('messages.page_not_found')); ?></p>
			<p><?php echo e(trans('messages.back_to')); ?> <a href="/home"><?php echo e(trans('messages.home')); ?></a></p>
		</div>
		<?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>