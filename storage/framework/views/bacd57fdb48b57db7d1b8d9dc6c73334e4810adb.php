
						    	<div class="row">
									<div class="col-md-12">
										<div class="box-info">
											<?php echo Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'form-horizontal invoice-config-form','id' => 'invoice-config-form','data-no-form-clear' => 1]); ?>

												<div class="col-md-6">
													<div class="form-group">
														<?php echo Form::label('default_invoice_partial_payment',trans('messages.enable').' '.trans('messages.partial').' '.trans('messages.payment'),['class' => ' control-label']); ?>

														<div class="checkbox">
										                	<input name="default_invoice_partial_payment" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" <?php echo e((config('config.default_invoice_partial_payment') == 1) ? 'checked' : ''); ?> data-off-value="0">
										                </div>
													</div>
													<div class="form-group">
														<?php echo Form::label('default_line_item_discount',trans('messages.default').' '.trans('messages.line_item_discount'),['class' => ' control-label']); ?>

														<div class="checkbox">
										                	<input name="default_line_item_discount" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" <?php echo e((config('config.default_line_item_discount') == 1) ? 'checked' : ''); ?> data-off-value="0">
										                </div>
													</div>
													<div class="form-group">
														<?php echo Form::label('default_line_item_tax',trans('messages.default').' '.trans('messages.line_item_tax'),['class' => ' control-label']); ?>

														<div class="checkbox">
										                	<input name="default_line_item_tax" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" <?php echo e((config('config.default_line_item_tax') == 1) ? 'checked' : ''); ?> data-off-value="0">
										                </div>
													</div>
													<div class="form-group">
														<?php echo Form::label('default_line_item_description',trans('messages.default').' '.trans('messages.line_item_description'),['class' => ' control-label']); ?>

														<div class="checkbox">
										                	<input name="default_line_item_description" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" <?php echo e((config('config.default_line_item_description') == 1) ? 'checked' : ''); ?> data-off-value="0">
										                </div>
													</div>
													<div class="form-group">
														<?php echo Form::label('default_subtotal_discount',trans('messages.default').' '.trans('messages.subtotal_discount'),['class' => ' control-label']); ?>

														<div class="checkbox">
										                	<input name="default_subtotal_discount" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" <?php echo e((config('config.default_subtotal_discount') == 1) ? 'checked' : ''); ?> data-off-value="0">
										                </div>
													</div>
													<div class="form-group">
														<?php echo Form::label('default_subtotal_tax',trans('messages.default').' '.trans('messages.subtotal_tax'),['class' => ' control-label']); ?>

														<div class="checkbox">
										                	<input name="default_subtotal_tax" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" <?php echo e((config('config.default_subtotal_tax') == 1) ? 'checked' : ''); ?> data-off-value="0">
										                </div>
													</div>
													<div class="form-group">
														<?php echo Form::label('default_subtotal_shipping_and_handling',trans('messages.default').' '.trans('messages.subtotal_shipping_and_handling'),['class' => ' control-label']); ?>

														<div class="checkbox">
										                	<input name="default_subtotal_shipping_and_handling" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" <?php echo e((config('config.default_subtotal_shipping_and_handling') == 1) ? 'checked' : ''); ?> data-off-value="0">
										                </div>
													</div>
													<div class="form-group">
														<?php echo Form::label('random_invoice_reference_number',trans('messages.random').' '.trans('messages.reference').' '.trans('messages.number'),['class' => ' control-label']); ?>

														<div class="checkbox">
										                	<input name="random_invoice_reference_number" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" <?php echo e((config('config.random_invoice_reference_number') == 1) ? 'checked' : ''); ?> data-off-value="0">
										                </div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<?php echo Form::label('invoice_prefix',trans('messages.invoice').' '.trans('messages.prefix'),[]); ?>

														<?php echo Form::input('text','invoice_prefix',(config('config.invoice_prefix')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.invoice'),' '.trans('messages.prefix')]); ?>

													</div>
													<div class="form-group">
														<?php echo Form::label('invoice_number_digit',trans('messages.invoice').' '.trans('messages.number').' '.trans('messages.digit'),[]); ?>

														<?php echo Form::input('number','invoice_number_digit',(config('config.invoice_number_digit')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.invoice').' '.trans('messages.number').' '.trans('messages.digit')]); ?>

													</div>
													<div class="form-group">
														<?php echo Form::label('invoice_start_number',trans('messages.invoice').' '.trans('messages.start').' '.trans('messages.number'),[]); ?>

														<?php echo Form::input('number','invoice_start_number',(config('config.invoice_start_number')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.invoice').' '.trans('messages.start').' '.trans('messages.number')]); ?>

													</div>
													<div class="form-group">
														<?php echo Form::label('item_quantity_decimal_place',trans('messages.item_quantity_decimal_place'),[]); ?>

														<?php echo Form::input('number','item_quantity_decimal_place',(config('config.item_quantity_decimal_place')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.item_quantity_decimal_place')]); ?>

													</div>
													<div class="form-group">
														<?php echo Form::label('item_tax_decimal_place',trans('messages.item_tax_decimal_place'),[]); ?>

														<?php echo Form::input('number','item_tax_decimal_place',(config('config.item_tax_decimal_place')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.item_tax_decimal_place')]); ?>

													</div>
													<div class="form-group">
														<?php echo Form::label('item_discount_decimal_place',trans('messages.item_discount_decimal_place'),[]); ?>

														<?php echo Form::input('number','item_discount_decimal_place',(config('config.item_discount_decimal_place')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.item_discount_decimal_place')]); ?>

													</div>
													<div class="form-group">
														<?php echo Form::label('shipping_and_handling_decimal_place',trans('messages.shipping_and_handling_decimal_place'),[]); ?>

														<?php echo Form::input('number','shipping_and_handling_decimal_place',(config('config.shipping_and_handling_decimal_place')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.shipping_and_handling_decimal_place')]); ?>

													</div>
													<input type="hidden" name="config_type" readonly value="invoice">
												  	<?php echo Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

												</div>
											<?php echo Form::close(); ?>

										</div>
									</div>
								</div>