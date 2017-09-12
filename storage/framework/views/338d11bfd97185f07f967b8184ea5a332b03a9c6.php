	<?php if(count($invoice_transactions)): ?>
		<?php $__currentLoopData = $invoice_transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<?php if(!Entrust::hasRole(config('constant.default_customer_role'))): ?>
				<td><?php echo e(($transaction->account_id) ? $transaction->Account->name : '-'); ?></td>
			<?php endif; ?>
			<td><?php echo e(showDate($transaction->date)); ?></td>
			<td><?php echo e(currency(getAmountWithoutDiscount($transaction->amount,$transaction->coupont_discount),1,$transaction->Currency->id)); ?></td>
			<td><?php echo e(($transaction->payment_method_id) ? $transaction->PaymentMethod->name : (($transaction->source) ? toWord($transaction->source) : '')); ?></td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/invoice-transaction/<?php echo e($transaction->id); ?>/show" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="<?php echo e(trans('messages.view')); ?>"></i></a>

					<?php if(!Entrust::hasRole(config('constant.default_customer_role')) && $transaction->source == null): ?>
						<a href="#" data-href="/invoice-transaction/<?php echo e($transaction->id); ?>/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="<?php echo e(trans('messages.edit')); ?>"></i></a>
						<?php echo delete_form(['transaction.destroy',$transaction->id],['table-refresh' => 'invoice-payment-table','refresh-content' => 'load-invoice-status']); ?>

					<?php endif; ?>

					<?php if(!Entrust::hasRole(config('constant.default_customer_role')) && $transaction->source != null): ?>
						<a href="#" data-href="/invoice-transaction/<?php echo e($transaction->id); ?>/withdraw" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-download" data-toggle="tooltip" title="<?php echo e(trans('messages.withdraw').' '.trans('messages.payment')); ?>"></i></a>
					<?php endif; ?>
				</div>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<tr>
			<th><?php echo e(trans('messages.total').' '.trans('messages.paid')); ?></th>
			<th colspan="4"><?php echo e(currency($total_paid,1,$transaction->Currency->id)); ?></th>
		</tr>
		<tr>
			<th><?php echo e(trans('messages.balance')); ?></th>
			<th colspan="4"><?php echo e(currency(($invoice->total-$total_paid),1,$transaction->Currency->id)); ?></th>
		</tr>
	<?php else: ?>
		<tr><td colspan="5"><?php echo e(trans('messages.no_data_found')); ?></td></tr>
	<?php endif; ?>