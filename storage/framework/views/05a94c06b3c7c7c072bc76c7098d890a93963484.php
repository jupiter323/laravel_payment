	<?php if(count($emails)): ?>
		<?php $__currentLoopData = $emails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $email): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($email->to_address); ?>

			<td><?php echo e($email->subject); ?>

			<td><?php echo e(showDateTime($email->created_at)); ?></td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/email/<?php echo e($email->id); ?>" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="<?php echo e(trans('messages.view')); ?>"></i></a>
				</div>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php else: ?>
		<tr><td colspan="4"><?php echo e(trans('messages.no_data_found')); ?></td></tr>
	<?php endif; ?>