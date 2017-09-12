	<?php if(count($invoice->RecurringInvoice) || $invoice->next_recurring_date): ?>
		<?php $__currentLoopData = $invoice->RecurringInvoice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $recurring_invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e(showDate($recurring_invoice->date)); ?></td>
			<td><?php echo e(toWord($recurring_invoice->status)); ?></td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="/invoice/<?php echo e($recurring_invoice->uuid); ?>" class="btn btn-xs btn-default"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="<?php echo e(trans('messages.view')); ?>"></i></a>
				</div>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php if($invoice->next_recurring_date): ?>
			<tr>
			<td><?php echo e(showDate($invoice->next_recurring_date)); ?> (<?php echo e(trans('pagination.next').' '.trans('messages.recurring').' '.trans('messages.date')); ?>)</td>
			<td><span class="label label-info"><?php echo e(trans('messages.pending')); ?></span></td>
			<td>-</td>
		</tr>
		<?php endif; ?>
	<?php else: ?>
		<tr><td colspan="3"><?php echo e(trans('messages.no_data_found')); ?></td></tr>
	<?php endif; ?>