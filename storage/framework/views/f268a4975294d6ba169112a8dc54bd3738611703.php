	<?php if(count($income_categories)): ?>
		<?php $__currentLoopData = $income_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $income_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($income_category->name); ?></td>
			<td><?php echo e($income_category->description); ?></td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/income-category/<?php echo e($income_category->id); ?>/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="<?php echo e(trans('messages.edit')); ?>"></i></a>
					<?php echo delete_form(['income-category.destroy',$income_category->id],['table-refresh' => 'income-category-table']); ?>

				</div>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php else: ?>
		<tr><td colspan="5"><?php echo e(trans('messages.no_data_found')); ?></td></tr>
	<?php endif; ?>