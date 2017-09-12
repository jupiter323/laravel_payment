	<?php if(count($quotations)): ?>
		<?php $__currentLoopData = $quotations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quotation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($quotation->quotation_prefix.getQuotationNumber($quotation)); ?></td>
			<td><?php echo e($quotation->Customer->full_name); ?></td>
			<td><?php echo e(currency($quotation->total,1,$quotation->currency_id)); ?></td>
			<td><?php echo e(showDate($quotation->date)); ?></td>
			<td><?php echo e(showDate($quotation->expiry_date)); ?></td>
			<td>
				<?php echo $__env->make('quotation.status',compact('quotation','size'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			</td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="/quotation/<?php echo e($quotation->uuid); ?>" class="btn btn-xs btn-default"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="<?php echo e(trans('messages.view')); ?>"></i></a>
				</div>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php else: ?>
		<tr><td colspan="7"><?php echo e(trans('messages.no_data_found')); ?></td></tr>
	<?php endif; ?>