
		<div class="row">
			<div class="col-xs-12">
				<div class="box-info">
					<div class="invoice">
			            <div class="row invoice-logo">
			                <div class="col-xs-6 invoice-logo-space">
							    <?php echo getCompanyLogo(); ?>

			                </div>
			                <div class="col-xs-6">
			                    <p class="pull-right text-right" style="font-size:14px;"> 
			                    	<?php echo ($invoice->reference_number) ? (trans('messages.reference').' '.trans('messages.number').' : <strong>'.$invoice->reference_number.'</strong>') : ''; ?> <br /> 
			                    	<?php echo trans('messages.invoice').' '.trans('messages.date').' : <strong>'.showDate($invoice->date); ?></strong> <br />
			                        <span class="muted"> <?php echo e(trans('messages.invoice').' '.trans('messages.number')); ?> : <strong> <?php echo e($invoice->invoice_prefix.getInvoiceNumber($invoice)); ?></strong></span>
			                        <?php if($invoice->due_date != 'no_due_date'): ?>
			                        <br />
			                        <span class="muted"><?php echo e(trans('messages.due').' '.trans('messages.date')); ?> : <strong><?php echo e(showDate($invoice->due_date_detail)); ?></strong></span>
			                        <?php endif; ?>			                        
			                    </p>
			                </div>
			            </div>
			            <hr/>
			            <div class="row">
			            	<div class="col-xs-12">
			                	<div class="pull-right" id="load-invoice-status" data-extra="&invoice_id=<?php echo e($invoice->id); ?>" data-source="/invoice-status"></div>
			                </div>

			                <div class="col-xs-4">
			                    <h3><?php echo e(trans('messages.company').' '.trans('messages.detail')); ?></h3>
			                    <ul class="list-unstyled">
			                        <li style="font-size:16px; font-weight:bold;"> <?php echo e(config('config.company_name')); ?> </li>
			                        <li><?php echo e(trans('messages.email').' : '.config('config.company_email')); ?></li>
			                        <li><?php echo e(trans('messages.phone').' : '.config('config.company_phone')); ?></li>
			                        <?php echo config('config.company_address_line_1') ? ('<li>'.config('config.company_address_line_1').'</li>') : ''; ?>

			                        <?php echo config('config.company_address_line_2') ? ('<li>'.config('config.company_address_line_2').'</li>') : ''; ?>

			                        <?php echo config('config.company_city') ? ('<li>'.config('config.company_city').'</li>') : ''; ?>

			                        <?php echo config('config.company_state') ? ('<li>'.config('config.company_state').'</li>') : ''; ?>

			                        <?php echo config('config.company_zipcode') ? ('<li>'.config('config.company_zipcode').'</li>') : ''; ?>

			                        <?php echo config('config.company_country_id') ? ('<li>'.config('country.'.config('config.company_country_id')).'</li>') : ''; ?>

			                    </ul>
			                </div>
			                <div class="col-xs-4 invoice-payment">
			                </div>
			                <div class="col-xs-4">
			                    <h3 class="text-right"><?php echo e(trans('messages.customer')); ?></h3>
			                    <ul class="list-unstyled pull-right text-right">
			                        <li style="font-size:16px; font-weight:bold;"> <?php echo e($invoice->Customer->full_name); ?> </li>
			                        <li><?php echo e(trans('messages.email').' : '.$invoice->Customer->email); ?></li>
			                        <?php if($invoice->Customer->Profile->phone): ?>
			                        	<li><?php echo e(trans('messages.phone').' : '.$invoice->Customer->Profile->phone); ?></li>
			                        <?php endif; ?>
			                        <li> <?php echo e($invoice->Customer->Profile->address_line_1); ?>

			                        <?php echo e(isset($invoice->Customer->Profile->address_line_2) ? ($invoice->Customer->Profile->address_line_2) : ''); ?></li>
			                        <?php echo isset($invoice->Customer->Profile->city) ? ('<li>'.$invoice->Customer->Profile->city.'</li>') : ''; ?>

			                        <?php echo isset($invoice->Customer->Profile->state) ? ('<li>'.$invoice->Customer->Profile->state.'</li>') : ''; ?>

			                        <?php echo isset($invoice->Customer->Profile->zipcode) ? ('<li>'.$invoice->Customer->Profile->zipcode.'</li>') : ''; ?>

			                        <?php echo isset($invoice->Customer->Profile->country_id) ? ('<li>'.config('country.'.$invoice->Customer->Profile->country_id).'</li>') : ''; ?>

			                    </ul>
			                </div>
			            </div>
			            <div class="row">
			                <div class="col-xs-12">
			                	<div class="table-responsive">
			                    <table class="table table-striped table-hover table-bordered">
			                        <thead>
			                            <tr>
			                                <th> # </th>
			                                <th> <?php echo e(trans('messages.item')); ?> </th>
			                                <th> <?php echo e(trans('messages.description')); ?> </th>
			                                <?php if($invoice->item_type != 'amount_only'): ?>
			                                <th> <?php echo e(trans('messages.quantity')); ?> </th>
			                                <?php endif; ?>
			                                <th> <?php echo e(trans('messages.unit').' '.trans('messages.price')); ?> </th>
			                                <?php if($invoice->line_item_discount): ?>
			                                <th> <?php echo e(trans('messages.discount')); ?> </th>
			                                <?php endif; ?>
			                                <?php if($invoice->line_item_tax): ?>
			                                <th> <?php echo e(trans('messages.tax')); ?> </th>
			                                <?php endif; ?>
			                                <th style="width:150px;" class="text-right"> <?php echo e(trans('messages.amount')); ?> </th>
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
			                                	<td> <?php echo e(round($invoice_item->item_quantity,config('config.item_quantity_decimal_place'))); ?> </td>
			                                <?php endif; ?>
			                                <td> <?php echo e(currency($invoice_item->unit_price,1,$invoice->Currency->id)); ?> </td>
			                                <?php if($invoice->line_item_discount): ?>
			                                	<td> <?php echo e(($invoice_item->item_discount_type) ? currency($invoice_item->item_discount,1,$invoice->Currency->id) : (round($invoice_item->item_discount,config('config.item_discount_decimal_place')).' %')); ?> </td>
			                                <?php endif; ?>
			                                <?php if($invoice->line_item_tax): ?>
			                                	<td> <?php echo e(round($invoice_item->item_tax,config('config.item_tax_decimal_place')).' %'); ?> </td>
			                                <?php endif; ?>
			                                <td class="text-right"> <?php echo e(currency($invoice_item->item_amount,1,$invoice->Currency->id)); ?> </td>
			                            </tr>
			                            <?php $i++; ?>
			                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			                        </tbody>
			                    </table>
			                    </div>
			                </div>
			            </div>
			            <div class="row">
			                <div class="col-xs-6">
			                	
			                	<?php if($invoice->tnc): ?>
			                    <div class="well" style="margin-top: 10px;">
			                        <address>
			                            <strong><?php echo e(trans('messages.tnc')); ?></strong>
			                            <p><?php echo e($invoice->tnc); ?></p>
			                        </address>
			                    </div>
			                    <?php endif; ?>
			                	<?php if($invoice->customer_note): ?>
			                    <div class="well">
			                        <address>
			                            <strong><?php echo e(trans('messages.customer').' '.trans('messages.note')); ?></strong>
			                            <p><?php echo e($invoice->customer_note); ?></p>
			                        </address>
			                    </div>
			                    <?php endif; ?>
			                	<?php if($invoice->memo && !Entrust::hasRole(config('constant.default_customer_role'))): ?>
			                    <div class="well">
			                        <address>
			                            <strong><?php echo e(trans('messages.memo')); ?></strong>
			                            <p><?php echo e($invoice->memo); ?></p>
			                        </address>
			                    </div>
			                    <?php endif; ?>

			                	<?php if(!isset($no_payment) && Auth::check() && Entrust::hasRole(config('constant.default_customer_role'))): ?>
			                		<h2><strong><?php echo e(trans('messages.payment')); ?></strong></h2>
			                		<div class="table-responsive" style="margin-top: 10px;">
										<table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="invoice-payment-table" data-source="/invoice/payment/lists" data-extra="&invoice_id=<?php echo e($invoice->id); ?>">
											<thead>
												<tr>
													<th><?php echo trans('messages.date'); ?></th>
													<th><?php echo trans('messages.amount'); ?></th>
													<th><?php echo trans('messages.method'); ?></th>
													<th data-sortable="false" style="width:150px;"><?php echo trans('messages.option'); ?></th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								<?php endif; ?>
			                </div>
			                <div class="col-xs-2">
			                </div>
			                <div class="col-xs-4">
			                	<div class="table-responsive">
				                	<table class="table table-striped table-hover table-bordered">
				                		<tbody>
				                			<?php if($invoice->subtotal_discount && $invoice->subtotal_discount_amount > 0): ?>
				                			<tr>
				                				<td><?php echo e(trans('messages.discount')); ?></td>
				                				<td style="width:150px;" class="text-right"><?php echo e(($invoice->subtotal_discount_type) ? currency($invoice->subtotal_discount_amount,1,$invoice->Currency->id) : (round($invoice->subtotal_discount_amount,5).' %')); ?></td>
				                			</tr>
				                			<?php endif; ?>
				                			<?php if($invoice->subtotal_tax && $invoice->subtotal_tax_amount > 0): ?>
				                			<tr>
				                				<td><?php echo e(trans('messages.tax')); ?></td>
				                				<td style="width:150px;" class="text-right"><?php echo e(round($invoice->subtotal_tax_amount,5)); ?> %</td>
				                			</tr>
				                			<?php endif; ?>
				                			<?php if($invoice->subtotal_shipping_and_handling && $invoice->subtotal_shipping_and_handling_amount > 0): ?>
				                			<tr>
				                				<td><?php echo e(trans('messages.shipping_and_handling')); ?></td>
				                				<td style="width:150px;" class="text-right"><?php echo e(currency($invoice->subtotal_shipping_and_handling_amount,1,$invoice->Currency->id)); ?></td>
				                			</tr>
				                			<?php endif; ?>
				                			<tr style="font-size:16px; font-weight: bold;">
				                				<td><?php echo e(trans('messages.grand').' '.trans('messages.total')); ?></td>
				                				<td style="width:150px;" class="text-right"><?php echo e(currency($invoice->total,1,$invoice->Currency->id)); ?></td>
				                			</tr>
				                			<tfoot>
				                			<tr>
				                				<td colspan="2" style="font-weight:bold;" class="text-right"><strong><?php echo e(inWords(round($invoice->total,$invoice->Currency->decimal_place)).' '.$invoice->Currency->name); ?></strong></td>
				                			</tr>
				                			</tfoot>
				                		</tbody>
				                	</table>
			                	</div>
			                </div>
			            </div>
			        </div>
			    </div>
        	</div>
        </div>
        <div class="row no-print">
          <div class="col-xs-12">
          	<div class="pull-right" style="margin-bottom: 20px;">
	            <a href="/invoice/<?php echo e($invoice->uuid); ?>/print" class="btn btn-primary"><i class="fa fa-print"></i> <?php echo e(trans('messages.print')); ?></a> 
	            <a href="/invoice/<?php echo e($invoice->uuid); ?>/pdf" class="btn btn-success"><i class="fa fa-file-pdf-o"></i> <?php echo e(trans('messages.download').' '.trans('messages.pdf')); ?></a> 
	        </div>
          </div>
        </div>