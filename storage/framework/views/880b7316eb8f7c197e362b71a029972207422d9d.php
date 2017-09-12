
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<?php echo Form::label('customer_id',trans('messages.customer'),[]); ?>

							<?php echo Form::select('customer_id',$customers,isset($quotation) ? $quotation->customer_id : '',['class'=>'form-control show-tick','title'=>trans('messages.customer')]); ?>

						</div>
						<div class="row">
							<div class="form-group">
								<div class="col-sm-6">
									<?php echo Form::label('item_type',trans('messages.item').' '.trans('messages.type'),[]); ?>

									<?php echo Form::select('item_type',$item_type_lists,isset($quotation) ? $quotation->item_type : '',['class'=>'form-control show-tick']); ?>

								</div>
								<div class="col-sm-6">
									<?php echo Form::label('currency_id',trans('messages.currency'),[]); ?>

									<?php echo Form::select('currency_id',$currencies,isset($quotation) ? $quotation->currency_id : (isset($default_currency) ? $default_currency->id : ''),['class'=>'form-control show-tick','title'=>trans('messages.currency'),'id' => 'currency_id']); ?>

								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 form-horizontal">
						<div class="form-group">
							<?php echo Form::label('number',trans('messages.quotation').' '.trans('messages.number'),['class' => 'col-sm-4 control-label']); ?>

							<div class="col-sm-8">
								<div class="row">
									<div class="col-md-3">
										<?php echo Form::input('text','quotation_prefix',config('config.quotation_prefix'),['class'=>'form-control','placeholder'=>trans('messages.quotation').' '.trans('messages.prefix')]); ?>

									</div>
									<div class="col-md-9">
										<?php echo Form::input('text','quotation_number',isset($quotation) ? getQuotationNumber($quotation) : getQuotationNumber(),['class'=>'form-control','placeholder'=>trans('messages.quotation').' '.trans('messages.number')]); ?>

									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<?php echo Form::label('reference_number',trans('messages.reference').' '.trans('messages.number'),['class' => 'col-sm-4 control-label']); ?>

							<div class="col-sm-8">
								<?php echo Form::input('text','reference_number',isset($quotation) ? $quotation->reference_number : (config('config.random_quotation_reference_number') ? strtoupper(randomString(8)) : '' ),['class'=>'form-control','placeholder'=>trans('messages.reference').' '.trans('messages.number')]); ?>

							</div>
						</div>
						<div class="form-group">
							<?php echo Form::label('date',trans('messages.quotation').' '.trans('messages.date'),['class' => 'col-sm-4 control-label']); ?>

							<div class="col-sm-8">
								<?php echo Form::input('text','date',isset($quotation) ? $quotation->date : '',['class'=>'form-control datepicker','placeholder'=>trans('messages.quotation').' '.trans('messages.date'),'readonly' => 'true']); ?>

							</div>
						</div>
						<div class="form-group">
							<?php echo Form::label('expiry_date',trans('messages.expiry'). ' '.trans('messages.due').' '.trans('messages.date'),['class' => 'col-sm-4 control-label']); ?>

							<div class="col-sm-8">
								<?php echo Form::input('text','expiry_date',isset($quotation) ? $quotation->expiry_date : '',['class'=>'form-control datepicker','placeholder'=>trans('messages.expiry').' '.trans('messages.date'),'readonly' => 'true']); ?>

							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<?php echo Form::label('subject',trans('messages.subject'),[]); ?>

				    		<?php echo Form::textarea('subject',isset($quotation) ? $quotation->subject : '',['size' => '30x1', 'class' => 'form-control', 'placeholder' => trans('messages.subject'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1]); ?>

				    		<span class="countdown"></span>
					  	</div>
					  	<div class="form-group">
							<?php echo Form::label('description',trans('messages.description'),[]); ?>

							<?php echo Form::textarea('description',isset($quotation->description) ? $quotation->description : '',['size' => '30x10', 'class' => 'form-control redactor', 'placeholder' => trans('messages.description'),'data-height' => '200']); ?>

						</div>
					</div>
				</div>
				<div class="dropdown">
				  <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown" id="invoice-dropdown"  aria-haspopup="true" aria-expanded="true">
				    <?php echo e(trans('messages.option')); ?>

				    <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu" role="menu" aria-labelledby="invoice-dropdown">
				  	<li class="dropdown-header"><?php echo e(trans('messages.add_to_line_item')); ?></li>
				    <li><div class="checkbox"><label><?php echo Form::checkbox('line_item_tax', 1,(isset($quotation) && $quotation->line_item_tax) ? 'checked' : ((!isset($quotation) && config('config.default_line_item_tax')) ? 'checked' : ''),['id' => 'line_item_tax','class' => 'icheck']); ?> <?php echo e(trans('messages.tax')); ?></label></div></li>
				    <li><div class="checkbox"><label><?php echo Form::checkbox('line_item_discount',1,(isset($quotation) && $quotation->line_item_discount) ? 'checked' : ((!isset($quotation) && config('config.default_line_item_discount')) ? 'checked' : ''),['id' => 'line_item_discount','class' => 'icheck']); ?> <?php echo e(trans('messages.discount')); ?></label></div></li>
				    <li><div class="checkbox"><label><?php echo Form::checkbox('line_item_description', 1,(isset($quotation) && $quotation->line_item_description) ? 'checked' : ((!isset($quotation) && config('config.default_line_item_description')) ? 'checked' : ''),['id' => 'line_item_description','class' => 'icheck']); ?> <?php echo e(trans('messages.description')); ?></label></div></li>
				    <li role="separator" class="divider"></li>
				  	<li class="dropdown-header"><?php echo e(trans('messages.add_to_subtotal')); ?></li>
				    <li><div class="checkbox"><label><?php echo Form::checkbox('subtotal_tax', 1,(isset($quotation) && $quotation->subtotal_tax) ? 'checked' : ((!isset($quotation) && config('config.default_subtotal_tax')) ? 'checked' : ''),['id' => 'subtotal_tax','class' => 'icheck']); ?> <?php echo e(trans('messages.tax')); ?></label></div></li>
				    <li><div class="checkbox"><label><?php echo Form::checkbox('subtotal_discount', 1,(isset($quotation) && $quotation->subtotal_discount) ? 'checked' : ((!isset($quotation) && config('config.default_subtotal_discount')) ? 'checked' : ''),['id' => 'subtotal_discount','class' => 'icheck']); ?> <?php echo e(trans('messages.discount')); ?></label></div></li>
				    <li><div class="checkbox"><label><?php echo Form::checkbox('subtotal_shipping_and_handling', 1,(isset($quotation) && $quotation->subtotal_shipping_and_handling) ? 'checked' : ((!isset($quotation) && config('config.default_subtotal_shipping_and_handling')) ? 'checked' : ''),['id' => 'subtotal_shipping_and_handling','class' => 'icheck']); ?> <?php echo e(trans('messages.shipping_and_handling')); ?></label></div></li>
				  </ul>
				</div>
				<?php if(Entrust::can('create-item')): ?>
					<a class="btn btn-primary btn-xs" id="add-invoice-item" data-toggle="modal" data-target="#myModal" data-href="/item/create" style="margin-top:10px;">
					<?php echo e(trans('messages.add_new').' '.trans('messages.item')); ?></a> 
				<?php endif; ?>
				<?php if(Entrust::can('manage-configuration')): ?>
					<a class="btn btn-primary btn-xs" id="add-invoice-tax" data-toggle="modal" data-target="#myModal" data-href="/taxation/create" style="margin-top:10px;"><?php echo e(trans('messages.add_new').' '.trans('messages.tax')); ?></a> 
					<a class="btn btn-primary btn-xs" id="add-invoice-tax" data-toggle="modal" data-target="#myModal" data-href="/currency/create" style="margin-top:10px;"><?php echo e(trans('messages.add_new').' '.trans('messages.currency')); ?></a>
				<?php endif; ?>
				<div class="row" id="invoice-items" style="margin:10px 0;">
					<div class="table-responsive">
						<table class="table table-bordered table-condensed" id="table-invoice-item" data-invoice-id="<?php echo e(isset($quotation) ? $quotation->id : ''); ?>">
							<thead>
								<tr>
									<th style="width:20px;"></th>
									<th style="min-width:160px;"><?php echo e(trans('messages.item')); ?></th>
									<th class="item-quantity item-quantity-header"><?php echo e(trans('messages.quantity')); ?></th>
									<th class="item-price item-price-header"><?php echo e(trans('messages.price')); ?></th>
									<th class="item-discount"><?php echo e(trans('messages.discount')); ?></th>
									<th class="item-tax"><?php echo e(trans('messages.tax')); ?> (%)</th>
									<th style="width:150px;"><?php echo e(trans('messages.amount')); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if(isset($quotation_items)): ?>
									<?php $__currentLoopData = $quotation_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quotation_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr class="item-row" data-unique-id="<?php echo e($quotation_item->item_key); ?>">
											<td><a href="#" class="delete-invoice-row"><i class="fa fa-times-circle fa-lg" style="color:red;"></i></a><a href="#" class="add-invoice-row"><i class="fa fa-plus-circle fa-lg" style="color:#337AB7;"></i></a></td>
											<td class="item-name">
											<?php if(isset($quotation_item->item_id)): ?>
												<?php echo Form::select('item_name['.$quotation_item->item_key.']',[''=>'','custom_item' => trans('messages.custom').' '.trans('messages.item')] + $items,$quotation_item->item_id,['class'=>'form-control input-xlarge select2me','placeholder'=>trans('messages.item'),'data-unique-id' => $quotation_item->item_key,'id' => 'item_name_'.$quotation_item->item_key,'data-type' => 'item-name'] ); ?>

											<?php else: ?>
												<input type="text" class="form-control invoice-input" placeholder="Item Name" name="item_name[<?php echo e($quotation_item->item_key); ?>]" value="<?php echo e($quotation_item->item_name); ?>"><input type="hidden" readonly name="item_name_detail[<?php echo e($quotation_item->item_key); ?>] value="1">
											<?php endif; ?>
											</td>
											<td class="item-quantity"><input type="number" class="form-control invoice-input all-item-quantity" placeholder="<?php echo e(trans('messages.item').' '.trans('messages.quantity')); ?>" name="item_quantity[<?php echo e($quotation_item->item_key); ?>]" id="item_quantity_<?php echo e($quotation_item->item_key); ?>" value="<?php echo e(round($quotation_item->item_quantity,2)); ?>" step="<?php echo e(decimalValue(config('config.item_quantity_decimal_place'))); ?>"></td>
											<td class="item-price"><input type="number" class="form-control invoice-input all-item-price" placeholder="trans('messages.item').' '.trans('messages.price')}}" name="item_price[<?php echo e($quotation_item->item_key); ?>]" id="item_price_<?php echo e($quotation_item->item_key); ?>" value="<?php echo e(round($quotation_item->unit_price,$currency->decimal_place)); ?>" step=""></td>
											<td class="item-discount"><input type="number" class="form-control invoice-input all-item-discount" placeholder="<?php echo e(trans('messages.item').' '.trans('messages.discount')); ?>" name="item_discount[<?php echo e($quotation_item->item_key); ?>]" id="item_discount_<?php echo e($quotation_item->item_key); ?>" value="<?php echo e(round($quotation_item->item_discount,2)); ?>" step="<?php echo e(decimalValue(config('config.item_discount_decimal_place'))); ?>"><input type="checkbox" name="item_discount_type[<?php echo e($quotation_item->item_key); ?>]" id="item_discount_type_<?php echo e($quotation_item->item_key); ?>" class="all-item-discount-type icheck" data-unique-id="<?php echo e($quotation_item->item_key); ?>" <?php echo e(($quotation_item->item_discount_type) ? 'checked' : ''); ?>> <label id="item_discount_type_label_<?php echo e($quotation_item->item_key); ?>" class="item_discount_type_label">(%)</label></td>
											<td class="item-tax"><input type="number" class="form-control invoice-input all-item-tax" placeholder="<?php echo e(trans('messages.item').' '.trans('messages.tax')); ?>" name="item_tax[<?php echo e($quotation_item->item_key); ?>]" id="item_tax_<?php echo e($quotation_item->item_key); ?>" value="<?php echo e(round($quotation_item->item_tax,2)); ?>" step="<?php echo e(decimalValue(config('config.item_tax_decimal_place'))); ?>"></td>
											<td id="item_amount_<?php echo e($quotation_item->item_key); ?>" class="all-item-amount" style="vertical-align:middle;"></td>
										</tr>
										<tr class="item-description item-description-row" data-unique-id="<?php echo e($quotation_item->item_key); ?>">
											<td colspan="10"><input type="text" class="form-control invoice-input" placeholder="<?php echo e(trans('messages.item').' '.trans('messages.description')); ?>" name="item_description[<?php echo e($quotation_item->item_key); ?>]" id="item_description_<?php echo e($quotation_item->item_key); ?>" value="<?php echo e($quotation_item->item_description); ?>"></td>
										</tr>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
					<div class="col-md-6">
					</div>
					<div class="pull-right">
						<div class="table-responsive">
							<table class="table table-bordered table-condensed" id="table-invoice-subtotal">
								<tbody>
									<tr>
										<th><?php echo e(trans('messages.subtotal')); ?></th><th style="width:150px;" id="sub_total_amount"></th>
									</tr>
									<tr class="subtotal-discount">
										<th style="vertical-align:middle;"><?php echo e(trans('messages.discount')); ?> <input type="checkbox" name="subtotal_discount_type" class="all-item-discount-type icheck" <?php echo e((isset($quotation) && $quotation->subtotal_discount_type) ? 'checked' : ''); ?>> <label class="subtotal_discount_type_label" value="1">(%)</label></th><td><input type="number" class="form-control invoice-input" placeholder="<?php echo e(trans('messages.discount')); ?>" name="subtotal_discount_amount" value="<?php echo e(isset($quotation->subtotal_discount_amount) ? round($quotation->subtotal_discount_amount,$currency->decimal_place) : '0'); ?>" step="<?php echo e(decimalValue(config('config.item_discount_decimal_place'))); ?>"></td>
									</tr>
									<tr class="subtotal-tax">
										<th style="vertical-align:middle;"><?php echo e(trans('messages.tax')); ?> (%)</th><td><input type="number" class="form-control invoice-input" placeholder="<?php echo e(trans('messages.tax')); ?>" name="subtotal_tax_amount" value="<?php echo e(isset($quotation->subtotal_tax_amount) ? round($quotation->subtotal_tax_amount,$currency->decimal_place) : '0'); ?>" step="<?php echo e(decimalValue(config('config.item_tax_decimal_place'))); ?>"></td>
									</tr>
									<tr class="subtotal-shipping-and-handling">
										<th style="vertical-align:middle;"><?php echo e(trans('messages.shipping_and_handling')); ?></th><td><input type="number" class="form-control invoice-input" placeholder="<?php echo e(trans('messages.shipping_and_handling')); ?>" name="subtotal_shipping_and_handling_amount" value="<?php echo e(isset($quotation->subtotal_shipping_and_handling_amount) ? round($quotation->subtotal_shipping_and_handling_amount,$currency->decimal_place) : '0'); ?>" step="<?php echo e(decimalValue(config('config.shipping_and_handling_decimal_place'))); ?>"></td>
									</tr>
									<tr>
										<th><?php echo e(trans('messages.total')); ?></th><th id="total_amount"></th>
									</tr>
								</tbody>
							</table>
						</div>
					</div> 
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<?php echo Form::label('customer_note',trans('messages.customer').' '.trans('messages.note'),[]); ?>

				    		<?php echo Form::textarea('customer_note',isset($quotation->customer_note) ? $quotation->customer_note : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.customer').' '.trans('messages.note'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1]); ?>

				    		<span class="countdown"></span>
					  	</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<?php echo Form::label('tnc',trans('messages.tnc'),[]); ?>

				    		<?php echo Form::textarea('tnc',isset($quotation->tnc) ? $quotation->tnc : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.tnc'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1]); ?>

				    		<span class="countdown"></span>
					  	</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<?php echo Form::label('memo',trans('messages.memo'),[]); ?>

				    		<?php echo Form::textarea('memo',isset($quotation->memo) ? $quotation->memo : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.memo'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1]); ?>

				    		<span class="countdown"></span>
					  	</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<?php echo $__env->make('upload.index',['module' => 'quotation','upload_button' => trans('messages.upload').' '.trans('messages.file'),'module_id' => isset($quotation) ? $quotation->id : ''], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					</div>
				</div>