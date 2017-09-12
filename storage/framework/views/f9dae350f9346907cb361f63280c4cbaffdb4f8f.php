	<?php if(count($payment_methods)): ?>
		<?php $__currentLoopData = $payment_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment_method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($payment_method->name); ?></td>
			<td><?php echo e(toWord($payment_method->type)); ?></td>
			<td><?php echo e($payment_method->description); ?></td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/payment-method/<?php echo e($payment_method->id); ?>/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="<?php echo e(trans('messages.edit')); ?>"></i></a>
					<?php echo delete_form(['payment-method.destroy',$payment_method->id],['table-refresh' => 'payment-method-table']); ?>

				</div>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php else: ?>
		<tr><td colspan="5"><?php echo e(trans('messages.no_data_found')); ?></td></tr>
	<?php endif; ?>