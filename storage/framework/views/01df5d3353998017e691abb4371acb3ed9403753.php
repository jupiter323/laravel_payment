	<?php if(count($invoices)): ?>
		<?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<td><?php echo e($invoice->invoice_prefix.getInvoiceNumber($invoice)); ?></td>
			<td><?php echo e($invoice->Customer->full_name); ?></td>
			<td><?php echo e(currency($invoice->total,1,$invoice->currency_id)); ?></td>
			<td><?php echo e(showDate($invoice->date)); ?></td>
			<td><?php echo e(showDate($invoice->due_date_detail)); ?></td>
			<td>
				<?php echo $__env->make('invoice.status',compact('invoice','size'), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			</td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="/invoice/<?php echo e($invoice->uuid); ?>" class="btn btn-xs btn-default"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="<?php echo e(trans('messages.view')); ?>"></i></a>
				</div>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	<?php else: ?>
		<tr><td colspan="7"><?php echo e(trans('messages.no_data_found')); ?></td></tr>
	<?php endif; ?>