	<div class="modal-header">
       <div class="row">
                 <div class="col-xs-2">	  <?php echo Form::label('code',trans('messages.id'),[]); ?>:-0000<?php echo $max_id; ?></div>
			
			
		<div class="col-xs-8">	<h4 class="modal-title"><?php echo trans('messages.add_new').' '.trans('messages.item'); ?></h4></div>
			<div class="col-xs-2">	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button></div>

</div>
	</div>
	<div class="modal-body">
		<?php echo Form::open(['route' => 'item.store','role' => 'form', 'class'=>'item-form','id' => 'item-form']); ?>

			<?php echo $__env->make('item._form', ['buttonText' => trans('messages.update')], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php echo Form::close(); ?>

		<div class="clear"></div>
	</div>