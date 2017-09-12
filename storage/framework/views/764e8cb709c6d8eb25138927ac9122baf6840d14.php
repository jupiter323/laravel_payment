	<?php if(count($currencies)): ?>
		<?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($currency->name); ?></td>
			<td><?php echo e($currency->symbol); ?></td>
			<td><?php echo e($currency->position); ?></td>
			<td><?php echo e($currency->decimal_place); ?></td>
			<td><?php echo ($currency->is_default) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?></td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/currency/<?php echo e($currency->id); ?>/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="<?php echo e(trans('messages.edit')); ?>"></i></a>
					<?php echo delete_form(['currency.destroy',$currency->id],['table-refresh' => 'currency-table']); ?>

				</div>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php else: ?>
		<tr><td colspan="5"><?php echo e(trans('messages.no_data_found')); ?></td></tr>
	<?php endif; ?>