	<?php if(count($taxations)): ?>
		<?php $__currentLoopData = $taxations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $taxation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($taxation->name); ?></td>
			<td><?php echo e(round($taxation->value,5)); ?></td>
			<td><?php echo e($taxation->description); ?></td>
			<td><?php echo ($taxation->is_default) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'; ?></td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/taxation/<?php echo e($taxation->id); ?>/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="<?php echo e(trans('messages.edit')); ?>"></i></a>
					<?php echo delete_form(['taxation.destroy',$taxation->id],['table-refresh' => 'taxation-table']); ?>

				</div>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php else: ?>
		<tr><td colspan="5"><?php echo e(trans('messages.no_data_found')); ?></td></tr>
	<?php endif; ?>