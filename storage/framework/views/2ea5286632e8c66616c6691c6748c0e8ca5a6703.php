	<?php if(count($data)): ?>
		<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($value['name']); ?></td>
			<td><?php echo e($value['type']); ?></td>
			<td><?php echo e($value['last_transaction_date']); ?></td>
			<td><?php echo e($value['balance']); ?></td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php else: ?>
		<tr><td colspan="4"><?php echo e(trans('messages.no_data_found')); ?></td></tr>
	<?php endif; ?>