<?php if(!getMode()): ?>
	<div class="row">
		<div class="col-md-12">
			<div class="box-info">
				<?php echo $__env->make('global.notification',['message' => 'You are free to perform all actions. The demo gets reset in every 30 minutes.' ,'type' => 'info'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				<?php echo $__env->make('global.notification',['message' => 'Version 1.1 Released with some new features on 4th Feb 2017. <a href="#" data-href="/whats-new" data-toggle="modal" data-target="#myModal">Click here to check Whats New?</a>' ,'type' => 'success'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if(config('config.setup_guide') && defaultRole()): ?>
	<div class="row" id="setup_panel">
		<div class="col-md-12">
    		<div class="box-info">
    			<h2>
					<strong><?php echo trans('messages.setup_guide'); ?></strong>
					<div class="additional-btn">
					<?php echo Form::open(['route' => 'setup-guide','role' => 'form', 'class'=>'form-inline','id' => 'setup-guide-form','data-setup-guide-complete' => 1]); ?>

					<button type="submit" class="btn btn-danger btn-sm"><?php echo e(trans('messages.hide')); ?></button>
					<?php echo Form::close(); ?>

					</div>
    			</h2>
    			<div id="setup_guide">
					<?php echo $setup_guide; ?>

				</div>
			</div>
		</div>
	</div>
<?php endif; ?>