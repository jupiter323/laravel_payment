	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title"><?php echo trans('messages.add_new').' '.trans('messages.shipment').' '.trans('messages.address'); ?></h4>
	</div>
	<div class="modal-body">
		<?php echo Form::open(['route' => 'shipment.store','class'=>'shipment_address-form','id' => 'shipment_address-form','data-table-refresh' => 'shipment_address-table']); ?>

			<?php echo $__env->make('shipment_address._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo Form::close(); ?>

		<div class="clear"></div>
	</div>
