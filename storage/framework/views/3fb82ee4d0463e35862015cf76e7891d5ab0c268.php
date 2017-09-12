	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title"><?php echo trans('messages.add_new').' '.trans('messages.payment').' '.trans('messages.method'); ?></h4>
	</div>
	<div class="modal-body">
		<?php echo Form::open(['route' => 'payment-method.store','class'=>'payment_method-form','id' => 'payment_method-form','data-table-refresh' => 'payment_method-table']); ?>

			<?php echo $__env->make('payment_method._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo Form::close(); ?>

		<div class="clear"></div>
	</div>
