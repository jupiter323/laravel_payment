	<?php if(count($transactions)): ?>
		<?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($transaction->token); ?></td>
			<td><?php echo e(currency($transaction->amount,1,$transaction->currency_id)); ?></td>
			<td><?php echo e(($transaction->source) ? : ($transaction->PaymentMethod ? $transaction->PaymentMethod->name : '-')); ?></td>
			<td><?php echo e(showDate($transaction->created_at)); ?></td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/transaction/<?php echo e($transaction->token); ?>" class="btn btn-xs btn-default" data-target="#myModal" data-toggle="modal"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="<?php echo e(trans('messages.view')); ?>"></i></a>
				</div>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php else: ?>
		<tr><td colspan="7"><?php echo e(trans('messages.no_data_found')); ?></td></tr>
	<?php endif; ?>