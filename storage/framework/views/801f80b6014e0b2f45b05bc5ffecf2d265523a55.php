	<?php if(count($item_categories)): ?>
		<?php $__currentLoopData = $item_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($item_category->name); ?></td>
			<td><?php echo e(toWord($item_category->type)); ?></td>
			<td><?php echo e($item_category->description); ?></td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/item-category/<?php echo e($item_category->id); ?>/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="<?php echo e(trans('messages.edit')); ?>"></i></a>
					<?php echo delete_form(['item-category.destroy',$item_category->id],['table-refresh' => 'item-category-table']); ?>

				</div>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php else: ?>
		<tr><td colspan="5"><?php echo e(trans('messages.no_data_found')); ?></td></tr>
	<?php endif; ?>