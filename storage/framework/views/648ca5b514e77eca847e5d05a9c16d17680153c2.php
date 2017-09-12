<!DOCTYPE html>
<html>
<head>
	<title><?php echo config('config.application_name') ? : config('constants.default_title'); ?></title>
	<meta charset="utf-8" /> 
	<?php if(isset($action_type) && $action_type == 'print'): ?>
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<?php endif; ?>
	<style>
	<?php if(isset($action_type) && $action_type == 'print'): ?>
		*{font-family:'Open Sans','Verdana'}
	<?php else: ?>
		*{font-family:'Helvetica';}
	<?php endif; ?>
	body{width:auto; max-width:800px;margin:0 auto;,font-size:12px;}
	h2{font-size: 16px;font-weight: bold;}
	table.table-head th{font-size: 14px; font-weight: bold;text-align: right;}
	table.table-head td{font-size: 12px;text-align: right;}

	table.fancy-detail {  font-size:12px; border-collapse: collapse;  width:100%;  margin:0 auto;}
	table.fancy-detail th{  background:#E3E3E3; border: 1px #2e2e2e solid;  padding: 0.5em;  padding-left:10px; vertical-align:top;text-align: left;}
	table.fancy-detail th, table.fancy-detail td  {  padding: 0.5em;  padding-left:10px; border:1px solid #2e2e2e;text-align: left;}
	table.fancy-detail caption {  margin-left: inherit;  margin-right: inherit;}
	table.fancy-detail tr:hover{}

	</style>
</head>
<body>
	<div style="background-color: #F5F5F5; padding:5px;">
		<div style="padding:10px;background: #ffffff;">
			<table border="0" style="width:100%;margin-top: 20px;">
			<tr>
				<td style="width:40%;vertical-align: top;">
					<?php echo getCompanyLogo(); ?>

				</td>
				<td style="width:60%;vertical-align: top;">
					<table align="right" class="table-head">
						<?php if($invoice->reference_number): ?>
						<tr>
							<th><?php echo e(trans('messages.reference').' '.trans('messages.number')); ?></th><td><?php echo e($invoice->reference_number); ?></td>
						</tr>
						<?php endif; ?>
						<tr>
							<th><?php echo e(trans('messages.invoice').' '.trans('messages.number')); ?></th><td><?php echo e($invoice->invoice_prefix.getInvoiceNumber($invoice)); ?></td>
						</tr>
						<tr>
							<th><?php echo e(trans('messages.invoice').' '.trans('messages.date')); ?></th><td><?php echo e(showDate($invoice->date)); ?></td>
						</tr>
						<?php if($invoice->due_date != 'no_due_date'): ?>
						<tr>
							<th><?php echo e(trans('messages.due').' '.trans('messages.date')); ?></th><td><?php echo e(showDate($invoice->due_date_detail)); ?></td>
						</tr>
						<?php endif; ?>
					</table>
				</td>
			</tr>
			</table>
			<table border="0" style="width:100%;">
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr>
					<td style="width:40%;">
			            <p style="font-size:14px;"><span style="font-size:16px; font-weight: bold;"><?php echo e(config('config.company_name')); ?></span><br />
			            <?php echo (config('config.company_email')) ? (trans('messages.email').' : '.config('config.company_email').' <br />') : ''; ?>

			            <?php echo (config('config.company_phone')) ? (trans('messages.phone').' : '.config('config.company_phone').' <br />') : ''; ?>

			            <?php echo config('config.company_address_line_1') ? (config('config.company_address_line_1').' <br />') : ''; ?>

		            	<?php echo config('config.company_address_line_2') ? (config('config.company_address_line_2').' <br />') : ''; ?>

		            	<?php echo config('config.company_city') ? (config('config.company_city').' <br />') : ''; ?>

		            	<?php echo config('config.company_state') ? (config('config.company_state').' <br />') : ''; ?>

		            	<?php echo config('config.company_zipcode') ? (config('config.company_zipcode').' <br />') : ''; ?>

		            	<?php echo config('config.company_country_id') ? config('country.'.config('config.company_country_id')) : ''; ?>

			            </p>
			            <span style="font-size:18px; font-weight:bold; padding:5px; border:4px solid <?php echo e($invoice_color); ?>;color:<?php echo e($invoice_color); ?>;"><?php echo e(trans('messages.'.$invoice->payment_status)); ?></span>
					</td>
					<td style="text-align:right;width:60%;">
						<p style="font-size:14px;"><span style="font-size:16px; font-weight: bold;"><?php echo e($invoice->Customer->full_name); ?></span><br />
			            <?php echo trans('messages.email').' : '.$invoice->Customer->email.' <br />'; ?>

			            <?php echo ($invoice->Customer->Profile->phone) ? (trans('messages.phone').' : '.$invoice->Customer->Profile->phone.' <br />') : ''; ?>

			            <?php echo ($invoice->Customer->Profile->address_line_1) ? ($invoice->Customer->Profile->address_line_1.' <br />') : ''; ?>

			            <?php echo ($invoice->Customer->Profile->address_line_2) ? ($invoice->Customer->Profile->address_line_2.' <br />') : ''; ?>

			            <?php echo ($invoice->Customer->Profile->city) ? ($invoice->Customer->Profile->city.' <br />') : ''; ?>

			            <?php echo ($invoice->Customer->Profile->state) ? ($invoice->Customer->Profile->state.' <br />') : ''; ?>

			            <?php echo ($invoice->Customer->Profile->zipcode) ? ($invoice->Customer->Profile->zipcode.' <br />') : ''; ?>

			            <?php echo ($invoice->Customer->Profile->country_id) ? config('country.'.$invoice->Customer->Profile->country_id) : ''; ?>

			            </p>
					</td>
				</tr>
			</table>
			<div style="margin:5px 0px;">&nbsp;</div>
		    <table class="fancy-detail">
		        <thead>
		            <tr>
		                <th> # </th>
		                <th> <?php echo e(trans('messages.item')); ?> </th>
		                <th> <?php echo e(trans('messages.description')); ?> </th>
		                <?php if($invoice->item_type != 'amount_only'): ?>
		                <th style="text-align: right;"> <?php echo e(trans('messages.quantity')); ?> </th>
		                <?php endif; ?>
		                <th style="text-align: right;"> <?php echo e(trans('messages.unit').' '.trans('messages.price')); ?> </th>
		                <?php if($invoice->line_item_discount): ?>
		                <th style="text-align: right;"> <?php echo e(trans('messages.discount')); ?> </th>
		                <?php endif; ?>
		                <?php if($invoice->line_item_tax): ?>
		                <th style="text-align: right;"> <?php echo e(trans('messages.tax')); ?> </th>
		                <?php endif; ?>
		                <th style="width:150px;text-align: right;"> <?php echo e(trans('messages.amount')); ?> </th>
		            </tr>
		        </thead>
		        <tbody>
		        	<?php $i = 1; ?>
		        	<?php $__currentLoopData = $invoice->InvoiceItem; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		            <tr>
		                <td> <?php echo e($i); ?> </td>
		                <td> <?php echo e($invoice_item->item_name); ?> </td>
		                <td> <?php echo e($invoice_item->item_description); ?> </td>
		                <?php if($invoice->item_type != 'amount_only'): ?>
		                	<td style="text-align: right;"> <?php echo e(round($invoice_item->item_quantity,config('config.item_quantity_decimal_place'))); ?> </td>
		                <?php endif; ?>
		                <td style="text-align: right;"> <?php echo e(currency($invoice_item->unit_price,1,$invoice->Currency->id)); ?> </td>
		                <?php if($invoice->line_item_discount): ?>
		                	<td style="text-align: right;"> <?php echo e(($invoice_item->item_discount_type) ? currency($invoice_item->item_discount,1,$invoice->Currency->id) : (round($invoice_item->item_discount,config('config.item_discount_decimal_place')).' %')); ?> </td>
		                <?php endif; ?>
		                <?php if($invoice->line_item_tax): ?>
		                	<td style="text-align: right;"> <?php echo e(round($invoice_item->item_tax,config('config.item_tax_decimal_place')).' %'); ?> </td>
		                <?php endif; ?>
		                <td style="text-align: right;"> <?php echo e(currency($invoice_item->item_amount,1,$invoice->Currency->id)); ?> </td>
		            </tr>
		            <?php $i++; ?>
		            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		        </tbody>
		    </table>
		    <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
		    	<tr>
		    		<td style="width:60%;vertical-align: top;">
		    			<?php if($invoice->tnc): ?>
							<h2><?php echo e(trans('messages.tnc')); ?></h2>
							<p style="font-size: 13px;"><?php echo e($invoice->tnc); ?></p>
						<?php endif; ?>
		    			<?php if($invoice->customer_note): ?>
							<h2><?php echo e(trans('messages.customer').' '.trans('messages.note')); ?></h2>
							<p style="font-size: 13px;"><?php echo e($invoice->customer_note); ?></p>
						<?php endif; ?>
		    		</td>
		    		<td style="width:40%;vertical-align: top;">
		    			<table class="fancy-detail" style="width:100%;">
							<?php if($invoice->subtotal_discount && $invoice->subtotal_discount_amount > 0): ?>
							<tr>
								<td><?php echo e(trans('messages.discount')); ?></td>
								<td style="width:150px; text-align: right;"><?php echo e(currency($invoice->subtotal_discount_amount,1,$invoice->Currency->id)); ?></td>
							</tr>
							<?php endif; ?>
							<?php if($invoice->subtotal_tax && $invoice->subtotal_tax_amount > 0): ?>
							<tr>
								<td><?php echo e(trans('messages.tax')); ?></td>
								<td style="width:150px; text-align: right;"><?php echo e(currency($invoice->subtotal_tax_amount,1,$invoice->Currency->id)); ?></td>
							</tr>
							<?php endif; ?>
							<?php if($invoice->subtotal_shipping_and_handling && $invoice->subtotal_shipping_and_handling_amount > 0): ?>
							<tr>
								<td><?php echo e(trans('messages.shipping_and_handling')); ?></td>
								<td style="width:150px; text-align: right;"><?php echo e(currency($invoice->subtotal_shipping_and_handling_amount,1,$invoice->Currency->id)); ?></td>
							</tr>
							<?php endif; ?>
							<tr>
								<td style="font-size:16px; font-weight: bold;"><?php echo e(trans('messages.grand').' '.trans('messages.total')); ?></td>
								<td style="width:150px; text-align: right;font-size:16px; font-weight: bold;"><?php echo e(currency($invoice->total,1,$invoice->Currency->id)); ?></td>
							</tr>
							<tr>
								<td colspan="2" style="font-weight:bold; text-align: right;font-size:16px;"><?php echo e(inWords(round($invoice->total,$invoice->Currency->decimal_place)).' '.$invoice->Currency->name); ?></td>
							</tr>
						</table>
		    		</td>
		    	</tr>
		    </table>
	    </div>
	</div>
</body>
</html>

