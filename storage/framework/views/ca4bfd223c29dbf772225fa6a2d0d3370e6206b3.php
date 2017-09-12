	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title"><?php echo trans('messages.edit').' '.trans('messages.branch'); ?></h4>
	</div>
	<div class="modal-body">
		<?php echo Form::model($branch,['method' => 'PATCH','route' => ['branch.update',$branch] ,'class' => 'branch-edit-form','id' => 'branch-edit-form']); ?>

			<?php echo $__env->make('branch._form', ['buttonText' => trans('messages.update')], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo Form::close(); ?>

		<div class="clear"></div>
	</div>