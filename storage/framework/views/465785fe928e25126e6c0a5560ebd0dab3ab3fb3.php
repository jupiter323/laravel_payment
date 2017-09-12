	<?php if(count($expense_categories)): ?>
		<?php $__currentLoopData = $expense_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($expense_category->name); ?></td>
			<td><?php echo e($expense_category->description); ?></td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/expense-category/<?php echo e($expense_category->id); ?>/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="<?php echo e(trans('messages.edit')); ?>"></i></a>
					<?php echo delete_form(['expense-category.destroy',$expense_category->id],['table-refresh' => 'expense-category-table']); ?>

				</div>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php else: ?>
		<tr><td colspan="5"><?php echo e(trans('messages.no_data_found')); ?></td></tr>
	<?php endif; ?>