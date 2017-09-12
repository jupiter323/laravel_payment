        <?php if($invoice->is_cancelled): ?>
            <span class="label lb-<?php echo e($size); ?> label-danger"><?php echo e(trans('messages.invoice_cancelled')); ?></span>
        <?php elseif($invoice->status == 'draft'): ?>
            <span class="label lb-<?php echo e($size); ?> label-primary"><?php echo e(trans('messages.invoice_draft')); ?></span>
        <?php elseif($invoice->status == 'sent'): ?>
        	<?php if($invoice->payment_status == 'unpaid' || $invoice->payment_status == null): ?>
        		<span class="label lb-<?php echo e($size); ?> label-danger"><?php echo e(trans('messages.unpaid')); ?></span>
        	<?php elseif($invoice->payment_status == 'partially_paid'): ?>
        		<span class="label lb-<?php echo e($size); ?> label-warning"><?php echo e(trans('messages.partially_paid')); ?></span>
        	<?php elseif($invoice->payment_status == 'paid'): ?>
        		<span class="label lb-<?php echo e($size); ?> label-success"><?php echo e(trans('messages.paid')); ?></span>
            <?php endif; ?>

        	<?php if($invoice->payment_status != 'paid' && $invoice->due_date != 'no_due_date' && $invoice->due_date_detail < date('Y-m-d')): ?>
        		<span class="label lb-<?php echo e($size); ?> label-danger"><?php echo e(trans('messages.overdue')); ?></span>
            <?php endif; ?>
        <?php endif; ?>