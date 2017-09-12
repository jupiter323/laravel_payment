<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title"><?php echo trans('messages.add_new').' '.trans('messages.column'); ?></h4>
	</div>
	<div class="modal-body">
					<?php echo Form::open(['route' => 'column.store','role' => 'form', 'class'=>'custom-field-form','id' => 'custom-field-form','data-disable-enter-submission' => '1']); ?>

                                        	<?php echo $__env->make('column._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
 					 
				        <?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

	
					<?php echo Form::close(); ?>

				<div class="clear"></div>
	</div>
