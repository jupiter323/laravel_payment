
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title"><?php echo trans('messages.add_new').' '.trans('messages.taxation'); ?></h4>
	</div>
	<div class="modal-body">
		<?php echo Form::open(['route' => 'taxation.store','class'=>'taxation-form','id' => 'taxation-form','data-table-refresh' => 'taxation-table']); ?>

			<?php echo $__env->make('taxation._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo Form::close(); ?>

		<div class="clear"></div>
	</div>
