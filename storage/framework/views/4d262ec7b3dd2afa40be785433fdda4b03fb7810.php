	<?php if(count($customer_groups)): ?>
		<?php $__currentLoopData = $customer_groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($customer_group->name); ?></td>
			<td><?php echo e($customer_group->description); ?></td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/customer-group/<?php echo e($customer_group->id); ?>/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="<?php echo e(trans('messages.edit')); ?>"></i></a>
					<?php echo delete_form(['customer-group.destroy',$customer_group->id],['table-refresh' => 'customer-group-table']); ?>

				</div>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php else: ?>
		<tr><td colspan="5"><?php echo e(trans('messages.no_data_found')); ?></td></tr>
	<?php endif; ?>