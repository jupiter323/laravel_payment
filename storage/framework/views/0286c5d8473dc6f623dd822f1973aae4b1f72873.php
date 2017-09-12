				<div class="row">
					<div class="col-md-6">
<div class="form-group">
<?php echo Form::label('customer_id',trans('messages.company'),[]); ?>

<div class="table-responsive" id="company_table">
<table class="table table-bordered table-condensed">
  <thead>
    <tr>
      <th>Company Name</th>
      <th>Email</th>
      <th>Website</th>
      <th>Phone</th>
      <th>Address</th>    
      <th>Country</th>
      <th>State</th>
      <th>City</th>
      <th>Zipcode</th>
      <th>Ext Num</th>
      <th>Int Num</th>
      <th>Neighbourhood</th>
    </tr>
  </thead>
  <tbody id="tBody">
<tr>
<?php $__currentLoopData = $companys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<td><?php echo e($company['name']); ?></td>
<td><?php echo e($company['email']); ?></td>
<td><?php echo e($company['website']); ?></td>
<td><?php echo e($company['phone']); ?></td>
<td><?php echo e($company['address_line_1']); ?></td>
<td><?php echo e($company['country_id']); ?></td>
<td><?php echo e($company['state']); ?></td>
<td><?php echo e($company['city']); ?></td>
<td><?php echo e($company['zipcode']); ?></td>
<td><?php echo e($company['ext_num']); ?></td>
<td><?php echo e($company['int_num']); ?></td>
<td><?php echo e($company['neighboorhood']); ?></td>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tr>
</tbody>
</table>
</div></div>

<div class="row">
						<div class="form-group">
							<div class="col-sm-12" ><?php echo Form::label('customer_id',trans('messages.customer'),[]); ?></div>
<div class="col-sm-12" >					
<div class="btn-group col-sm-12" role="group" aria-label="Button group with nested dropdown" style="padding-left:0px;padding-right:0px;">
<div class="btn-group col-sm-10" style="padding-left:0px;padding-right:0px;">
<?php echo Form::select('customer_id',$customers,isset($invoice) ? $invoice->customer_id : '',['class'=>'form-control show-tick','id'=>'customer','title'=>trans('messages.customer')]); ?></div>
<a class="btn btn-success btn-md col-sm-2" id="add-invoice-tax" data-toggle="modal" data-target="#myModal" data-href="/user/create" ><i class="fa fa-plus" aria-hidden="true"></i>
</a></div>
</div></div></div>
<div class="form-group">
</div>


<div class="form-group" >
<div class="table-responsive" id="cust_table" style="display:none;">
<table class="table table-bordered table-condensed">
  <thead>
    <tr>
      <th>Customer Name</th>
      <th>Business Type</th>
      <th>Customer Tax-Id</th>
      <th>Address</th>    
      <th>Country</th>
      <th>State</th>
      <th>City</th>
      <th>Zipcode</th>
      <th>Ext Num</th>
      <th>Int Num</th>
      <th>Neighbourhood</th>
    </tr>
  </thead>
  <tbody id="tBody">
<tr>
<td id="cust_name"></td>
<td id="business_type"></td>
<td id="cust_tax_id"></td>
<td id="address"></td>
<td id="cust_country"></td>
<td id="cust_state"></td>
<td id="cust_city"></td>
<td id="cust_zip"></td>
<td id="cust_ext"></td>
<td id="cust_int"></td>
<td id="cust_neighbourhood"></td>

</tr>
</tbody>
</table>
</div>
</div>


<div class="row">
<div class="form-group">
<div class="col-sm-12"><?php echo Form::label('shipment_address',trans('messages.shipment').' '.trans('messages.address'),[]); ?></div>
<div class="col-sm-12" >					
<div class="btn-group col-sm-12" role="group" aria-label="Button group with nested dropdown" style="padding-left:0px;padding-right:0px;">
<div class="btn-group col-sm-10" style="padding-left:0px;padding-right:0px;">
<?php echo Form::select('shipment_address',$shipment_address,isset($invoice) ? $invoice->shipment_address : '',['class'=>'form-control show-tick','id'=>'shipment_address','title'=>trans('messages.shipment').' '.trans('messages.address')]); ?></div>
<a class="btn btn-success btn-md col-sm-2" id="add-invoice-tax" data-toggle="modal" data-target="#myModal" data-href="/shipment/create"><i class="fa fa-plus" aria-hidden="true"></i>
</a></div></div></div></div>

<div class="form-group">
</div>

<div class="form-group" >
<div class="table-responsive" id="ship_addr_table" style="display:none;">
<table class="table table-bordered table-condensed">
  <thead>
    <tr>
      <th>Id</th>
      <th>Address</th> 
      <th>Country</th>
      <th>State</th>
      <th>City</th>
      <th>Zipcode</th>
      <th>Ext Num</th>
      <th>Int Num</th>
      <th>Neighbourhood</th>
    </tr>
  </thead>
  <tbody id="tBody">
<tr>
<td id="ship_id"></td>
<td id="ship_address"></td>
<td id="ship_country"></td>
<td id="ship_state"></td>
<td id="ship_city"></td>
<td id="ship_zip"></td>
<td id="ship_ext"></td>
<td id="ship_int"></td>
<td id="ship_neighbourhood"></td>

</tr>
</tbody>
</table>
</div>
</div>


						<div class="row">
							<!--<div class="col-sm-12">
								<div class="form-group">
									<?php echo Form::label('item_type',trans('messages.item').' '.trans('messages.type'),[]); ?>

									<?php echo Form::select('item_type',$item_type_lists,isset($invoice) ? $invoice->item_type : '',['class'=>'form-control show-tick']); ?>

								</div>
							</div>-->
								<div class="form-group">
									
									<div class="col-sm-12"><?php echo Form::label('currency_id',trans('messages.currency'),[]); ?></div>

<div class="col-sm-12" >					
<div class="btn-group col-sm-12" role="group" aria-label="Button group with nested dropdown" style="padding-left:0px;padding-right:0px;">
<div class="btn-group col-sm-10" style="padding-left:0px;padding-right:0px;"><?php echo Form::select('currency_id',$currencies,isset($invoice) ? $invoice->currency_id : (isset($default_currency) ? $default_currency->id : ''),['class'=>'form-control show-tick','title'=>trans('messages.currency'),'id' => 'currency_id']); ?></div>
<a class="btn btn-success btn-md col-sm-2" id="add-invoice-tax" data-toggle="modal" data-target="#myModal" data-href="/currency/create" ><i class="fa fa-plus" aria-hidden="true"></i>
</a></div></div>
								</div>
							
						</div>
<div class="clear" style="height:20px;"></div>
<div class="form-group">
						<div class="dropdown">
						  <button class="btn btn-primary btn-xs dropdown-toggle" type="button" data-toggle="dropdown" id="invoice-dropdown"  aria-haspopup="true" aria-expanded="true">
						    <?php echo e(trans('messages.option')); ?>

						    <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" role="menu" aria-labelledby="invoice-dropdown">
						  	<li class="dropdown-header"><?php echo e(trans('messages.add_to_line_item')); ?></li>
						    <li><div class="checkbox"><label><?php echo Form::checkbox('line_item_tax', 1,(isset($invoice) && $invoice->line_item_tax) ? 'checked' : ((!isset($invoice) && config('config.default_line_item_tax')) ? 'checked' : ''),['id' => 'line_item_tax','class' => 'icheck']); ?> <?php echo e(trans('messages.tax')); ?></label></div></li>
						    <li><div class="checkbox"><label><?php echo Form::checkbox('line_item_discount',1,(isset($invoice) && $invoice->line_item_discount) ? 'checked' : ((!isset($invoice) && config('config.default_line_item_discount')) ? 'checked' : ''),['id' => 'line_item_discount','class' => 'icheck']); ?> <?php echo e(trans('messages.discount')); ?></label></div></li>
						    <li><div class="checkbox"><label><?php echo Form::checkbox('line_item_description', 1,(isset($invoice) && $invoice->line_item_description) ? 'checked' : ((!isset($invoice) && config('config.default_line_item_description')) ? 'checked' : ''),['id' => 'line_item_description','class' => 'icheck']); ?> <?php echo e(trans('messages.description')); ?></label></div></li>

<li><div class="checkbox"><label><?php echo Form::checkbox('subtotal1',1,(isset($invoice) && $invoice->subtotal1) ? 'checked' : ((!isset($invoice) && config('config.subtotal1')) ? 'checked' : ''),['id' => 'subtotal1','class' => 'icheck']); ?> <?php echo e(trans('messages.subtotal').' '.trans('messages.one')); ?></label></div></li>

<li><div class="checkbox"><label><?php echo Form::checkbox('subtotal2', 1,(isset($invoice) && $invoice->subtotal2) ? 'checked' : ((!isset($invoice) && config('config.subtotal2')) ? 'checked' : ''),['id' => 'subtotal2','class' => 'icheck']); ?> <?php echo e(trans('messages.subtotal').' '.trans('messages.two')); ?></label></div></li>

<li><div class="checkbox"><label><?php echo Form::checkbox('subtotal3', 1,(isset($invoice) && $invoice->subtotal3) ? 'checked' : ((!isset($invoice) && config('config.subtotal3')) ? 'checked' : ''),['id' => 'subtotal3','class' => 'icheck']); ?> <?php echo e(trans('messages.subtotal').' '.trans('messages.three')); ?></label></div></li>


						    <li role="separator" class="divider"></li>
						  	<li class="dropdown-header"><?php echo e(trans('messages.add_to_subtotal')); ?></li>
						    <li><div class="checkbox"><label><?php echo Form::checkbox('subtotal_tax', 1,(isset($invoice) && $invoice->subtotal_tax) ? 'checked' : ((!isset($invoice) && config('config.default_subtotal_tax')) ? 'checked' : ''),['id' => 'subtotal_tax','class' => 'icheck']); ?> <?php echo e(trans('messages.tax')); ?></label></div></li>
						    <li><div class="checkbox"><label><?php echo Form::checkbox('subtotal_discount', 1,(isset($invoice) && $invoice->subtotal_discount) ? 'checked' : ((!isset($invoice) && config('config.default_subtotal_discount')) ? 'checked' : ''),['id' => 'subtotal_discount','class' => 'icheck']); ?> <?php echo e(trans('messages.discount')); ?></label></div></li>
						    <li><div class="checkbox"><label><?php echo Form::checkbox('subtotal_shipping_and_handling', 1,(isset($invoice) && $invoice->subtotal_shipping_and_handling) ? 'checked' : ((!isset($invoice) && config('config.default_subtotal_shipping_and_handling')) ? 'checked' : ''),['id' => 'subtotal_shipping_and_handling','class' => 'icheck']); ?> <?php echo e(trans('messages.shipping_and_handling')); ?></label></div></li>

  
						  </ul>
						</div></div>
						<?php if(Entrust::can('create-item')): ?>
							<a class="btn btn-primary btn-xs" id="add-invoice-item" data-toggle="modal" data-target="#myModal" data-href="/item/create" style="margin-top:10px;">
							<?php echo e(trans('messages.add_new').' '.trans('messages.item')); ?></a> 
						<?php endif; ?>

                                          
							
						
						<?php if(Entrust::can('manage-configuration')): ?>
<a class="btn btn-primary btn-xs" id="add-invoice-item" data-toggle="modal" data-target="#myModal" data-href="/column/create" style="margin-top:10px;">
							<?php echo e(trans('messages.add_new').' '.trans('messages.column')); ?></a> 
							<!--<a class="btn btn-primary btn-xs" id="add-invoice-tax" data-toggle="modal" data-target="#myModal" data-href="/taxation/create" style="margin-top:10px;"><?php echo e(trans('messages.add_new').' '.trans('messages.tax')); ?></a> 
							<a class="btn btn-primary btn-xs" id="add-invoice-tax" data-toggle="modal" data-target="#myModal" data-href="/currency/create" style="margin-top:10px;"><?php echo e(trans('messages.add_new').' '.trans('messages.currency')); ?></a>-->
						<?php endif; ?>
					</div>
					<div class="col-md-6 form-horizontal">
<div class="form-group">
							<?php echo Form::label('date',trans('messages.invoice').' '.trans('messages.date'),['class' => 'col-sm-4 control-label']); ?>

							<div class="col-sm-8">
								<?php echo Form::input('text','date',isset($invoice) ? $invoice->date : date('Y-m-d'),['class'=>'form-control datepicker','placeholder'=>trans('messages.invoice').' '.trans('messages.date'),'readonly' => 'true']); ?>

							</div>
						</div>
                                             <div class="form-group">
							<?php echo Form::label('date',trans('messages.doc_type'),['class' => 'col-sm-4 control-label']); ?>

							<div class="col-sm-8">													
<div class="btn-group col-sm-12" role="group" aria-label="Button group with nested dropdown" style="padding-left:0px;padding-right:0px;">
<div class="btn-group col-sm-10" style="padding-left:0px;padding-right:0px;"><?php echo Form::select('doc_type',$documents ,isset($invoice) ? $invoice->doc_type: '',['class'=>'form-control show-tick']); ?></div>
<a class="btn btn-success btn-md col-sm-2" id="add-invoice-tax" data-toggle="modal" data-target="#myModal" data-href="/document/create"><i class="fa fa-plus" aria-hidden="true"></i>
</a></div></div>
							
						</div>

						<div class="form-group">
							<?php echo Form::label('number',trans('messages.doc').' '.trans('messages.id'),['class' => 'col-sm-4 control-label']); ?>

							<div class="col-sm-8">
								<div class="row">
									<div class="col-md-3">
										<?php echo Form::input('text','invoice_prefix',config('config.invoice_prefix'),['class'=>'form-control','placeholder'=>trans('messages.invoice').' '.trans('messages.prefix')]); ?>

									</div>
									<div class="col-md-9">
										<?php echo Form::input('text','invoice_number',isset($invoice) ? getInvoiceNumber($invoice) : getInvoiceNumber(),['class'=>'form-control','placeholder'=>trans('messages.invoice').' '.trans('messages.number')]); ?>

									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<?php echo Form::label('reference_number',trans('messages.purchase').' '.trans('messages.order'),['class' => 'col-sm-4 control-label']); ?>

							<div class="col-sm-8">
								<?php echo Form::input('text','reference_number',isset($invoice) ? $invoice->reference_number : (config('config.random_invoice_reference_number') ? strtoupper(randomString(8)) : '' ),['class'=>'form-control','placeholder'=>trans('messages.purchase').' '.trans('messages.order')]); ?>

							</div>
						</div>
						
						<div class="form-group">
							<?php echo Form::label('due_date',trans('messages.due').' '.trans('messages.date'),['class' => 'col-sm-4 control-label']); ?>

							<div class="col-sm-8">
								<?php echo Form::select('due_date', $invoice_due_date_lists,isset($invoice) ? $invoice->due_date : '',['class'=>'form-control show-tick']); ?>

							</div>
						</div>
						<div class="form-group" id="due_date_detail">
							<?php echo Form::label('due_date_detail',trans('messages.due').' '.trans('messages.date'),['class' => 'col-sm-4 control-label']); ?>

							<div class="col-sm-8">
								<?php echo Form::input('text','due_date_detail',(isset($invoice) && $invoice->due_date == 'due_on_date') ? $invoice->due_date_detail : '',['class'=>'form-control datepicker','placeholder'=>trans('messages.date'),'readonly' => 'true']); ?>

							</div>
						</div>

                                        <div class="form-group">
							<?php echo Form::label('payment_method',trans('messages.payment').' '.trans('messages.method'),['class' => 'col-sm-4 control-label']); ?>

							<div class="col-sm-8">
								<div class="btn-group col-sm-12" role="group" aria-label="Button group with nested dropdown" style="padding-left:0px;padding-right:0px;">
<div class="btn-group col-sm-10" style="padding-left:0px;padding-right:0px;"><?php echo Form::select('payment_method',$payment_methods ,isset($invoice) ? $invoice->payment_method: '',['class'=>'form-control show-tick']); ?></div>
<a class="btn btn-success btn-md col-sm-2" id="add-invoice-tax" data-toggle="modal" data-target="#myModal" data-href="/payment-method/create"><i class="fa fa-plus" aria-hidden="true"></i>
</a></div>
							</div>
						</div>


<div class="form-group">
							<?php echo Form::label('number',trans('messages.payment').' '.trans('messages.splits'),['class' => 'col-sm-4 control-label']); ?>

							<div class="col-sm-8">
								<div class="row">
									<div class="col-md-6">
										<?php echo Form::input('text','payment_split',isset($invoice) ? $invoice->payment_split: '',['class'=>'form-control','placeholder'=>trans('messages.splits').' '.trans('messages.hash')]); ?>

									</div>
									<div class="col-md-6">
										<?php echo Form::input('text','payment_split',isset($invoice) ? 
$invoice->payment_split: '' ,['class'=>'form-control','placeholder'=>trans('messages.paym').' '.trans('messages.hash')]); ?>									</div>
								</div>
							</div>
						</div>

</div>



				</div>
				<div class="row" id="invoice-items" style="margin:10px 0;">
					<div class="table-responsive">
						<table class="table table-bordered table-condensed" id="table-invoice-item" data-invoice-id="<?php echo e(isset($invoice) ? $invoice->id : ''); ?>">
							<thead>
								<tr>
									<th style="width:20px;"></th>
									<th style="min-width:160px;"><?php echo e(trans('messages.invoice')); ?></th>
									<th class="item-quantity item-quantity-header"><?php echo e(trans('messages.quantity')); ?></th>
<th class="item-unit item-unit-header"><?php echo e(trans('messages.unit')); ?></th>
									<th class="item-price item-price-header"><?php echo e(trans('messages.price')); ?></th>
                                                                 <th class="item-subtotal1"><?php echo e(trans('messages.subtotal')); ?> 
 <?php echo e(trans('messages.one')); ?></th>
 
 
									<th class="item-discount"><?php echo e(trans('messages.discount')); ?></th>
<th class="item-subtotal2"><?php echo e(trans('messages.subtotal')); ?> 
 <?php echo e(trans('messages.two')); ?></th>
									<th class="item-tax"><?php echo e(trans('messages.tax')); ?> (%)</th>

<th class="item-subtotal3"><?php echo e(trans('messages.subtotal')); ?> 
 <?php echo e(trans('messages.three')); ?></th>
									<th style="width:150px;"><?php echo e(trans('messages.amount')); ?></th>
                                                                      
								</tr>
							</thead>
							<tbody>
								<?php if(isset($invoice_items)): ?>
									<?php $__currentLoopData = $invoice_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<tr class="item-row" data-unique-id="<?php echo e($invoice_item->item_key); ?>">
											<td><a href="#" class="delete-invoice-row"><i class="fa fa-times-circle fa-lg" style="color:red;"></i></a><a href="#" class="add-invoice-row"><i class="fa fa-plus-circle fa-lg" style="color:#337AB7;"></i></a></td>
											<td class="item-name">
											<?php if(isset($invoice_item->item_id)): ?>
												<?php echo Form::select('item_name['.$invoice_item->item_key.']',[''=>'','custom_item' => trans('messages.custom').' '.trans('messages.item')] + $items,$invoice_item->item_id,['class'=>'form-control input-xlarge select2me','placeholder'=>trans('messages.item'),'data-unique-id' => $invoice_item->item_key,'id' => 'item_name_'.$invoice_item->item_key,'data-type' => 'item-name'] ); ?>

											<?php else: ?>
												<input type="text" class="form-control invoice-input" placeholder="Item Name" name="item_name[<?php echo e($invoice_item->item_key); ?>]" value="<?php echo e($invoice_item->item_name); ?>"><input type="hidden" readonly name="item_name_detail[<?php echo e($invoice_item->item_key); ?>] value="1">
											<?php endif; ?>
											</td>
<td class="item-unit"><?php echo Form::select('unit['.$invoice_item->item_key.']',$units,'',['class'=>'form-control show-tick invoice-input all-item-unit','title'=>trans('messages.item').' '.trans('messages.unit'),'id' => 'item_unit_'.$invoice_item->item_key,'data-type' => 'item-unit'] ); ?>





											<td class="item-quantity"><input type="number" class="form-control invoice-input all-item-quantity" placeholder="<?php echo e(trans('messages.item').' '.trans('messages.quantity')); ?>" name="item_quantity[<?php echo e($invoice_item->item_key); ?>]" id="item_quantity_<?php echo e($invoice_item->item_key); ?>" value="<?php echo e(round($invoice_item->item_quantity,2)); ?>" step="<?php echo e(decimalValue(config('config.item_quantity_decimal_place'))); ?>"></td>
											<td class="item-price"><input type="number" class="form-control invoice-input all-item-price" placeholder="trans('messages.item').' '.trans('messages.price')}}" name="item_price[<?php echo e($invoice_item->item_key); ?>]" id="item_price_<?php echo e($invoice_item->item_key); ?>" value="<?php echo e(round($invoice_item->unit_price,$currency->decimal_place)); ?>" step=""></td>

<td class="item-subtotal1"></td>




											<td class="item-discount"><input type="number" class="form-control invoice-input all-item-discount" placeholder="<?php echo e(trans('messages.item').' '.trans('messages.discount')); ?>" name="item_discount[<?php echo e($invoice_item->item_key); ?>]" id="item_discount_<?php echo e($invoice_item->item_key); ?>" value="<?php echo e(round($invoice_item->item_discount,2)); ?>" step="<?php echo e(decimalValue(config('config.item_discount_decimal_place'))); ?>"><input type="checkbox" name="item_discount_type[<?php echo e($invoice_item->item_key); ?>]" id="item_discount_type_<?php echo e($invoice_item->item_key); ?>" class="all-item-discount-type icheck" data-unique-id="<?php echo e($invoice_item->item_key); ?>" <?php echo e(($invoice_item->item_discount_type) ? 'checked' : ''); ?>> <label id="item_discount_type_label_<?php echo e($invoice_item->item_key); ?>" class="item_discount_type_label">(%)</label></td>

<td class="item-subtotal2"></td>


											<td class="item-tax"><input type="number" class="form-control invoice-input all-item-tax" placeholder="<?php echo e(trans('messages.item').' '.trans('messages.tax')); ?>" name="item_tax[<?php echo e($invoice_item->item_key); ?>]" id="item_tax_<?php echo e($invoice_item->item_key); ?>" value="<?php echo e(round($invoice_item->item_tax,2)); ?>" step="<?php echo e(decimalValue(config('config.item_tax_decimal_place'))); ?>"></td>

<td class="item-subtotal3"></td>

											<td id="item_amount_<?php echo e($invoice_item->item_key); ?>" class="all-item-amount" style="vertical-align:middle;"></td>

										</tr>
										<tr class="item-description item-description-row" data-unique-id="<?php echo e($invoice_item->item_key); ?>">
											<td colspan="10"><input type="text" class="form-control invoice-input" placeholder="<?php echo e(trans('messages.item').' '.trans('messages.description')); ?>" name="item_description[<?php echo e($invoice_item->item_key); ?>]" id="item_description_<?php echo e($invoice_item->item_key); ?>" value="<?php echo e($invoice_item->item_description); ?>"></td>
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
										<th style="vertical-align:middle;"><?php echo e(trans('messages.discount')); ?> <input type="checkbox" name="subtotal_discount_type" class="all-item-discount-type icheck" <?php echo e((isset($invoice) && $invoice->subtotal_discount_type) ? 'checked' : ''); ?>> <label class="subtotal_discount_type_label" value="1">(%)</label></th><td><input type="number" class="form-control invoice-input" placeholder="<?php echo e(trans('messages.discount')); ?>" name="subtotal_discount_amount" value="<?php echo e(isset($invoice->subtotal_discount_amount) ? round($invoice->subtotal_discount_amount,$currency->decimal_place) : '0'); ?>" step="<?php echo e(decimalValue(config('config.item_discount_decimal_place'))); ?>"></td>
									</tr>
									<tr class="subtotal-tax">
										<th style="vertical-align:middle;"><?php echo e(trans('messages.tax')); ?> (%)</th><td><input type="number" class="form-control invoice-input" placeholder="<?php echo e(trans('messages.tax')); ?>" name="subtotal_tax_amount" value="<?php echo e(isset($invoice->subtotal_tax_amount) ? round($invoice->subtotal_tax_amount,$currency->decimal_place) : '0'); ?>" step="<?php echo e(decimalValue(config('config.item_tax_decimal_place'))); ?>"></td>
									</tr>
									<tr class="subtotal-shipping-and-handling">
										<th style="vertical-align:middle;"><?php echo e(trans('messages.shipping_and_handling')); ?></th><td><input type="number" class="form-control invoice-input" placeholder="<?php echo e(trans('messages.shipping_and_handling')); ?>" name="subtotal_shipping_and_handling_amount" value="<?php echo e(isset($invoice->subtotal_shipping_and_handling_amount) ? round($invoice->subtotal_shipping_and_handling_amount,$currency->decimal_place) : '0'); ?>" step="<?php echo e(decimalValue(config('config.shipping_and_handling_decimal_place'))); ?>"></td>
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
					<div class="col-md-12">
						<?php echo $__env->make('upload.index',['module' => 'invoice','upload_button' => trans('messages.upload').' '.trans('messages.file'),'module_id' => isset($invoice) ? $invoice->id : ''], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<?php echo Form::label('customer_note',trans('messages.customer').' '.trans('messages.note'),[]); ?>

				    		<?php echo Form::textarea('customer_note',isset($invoice->customer_note) ? $invoice->customer_note : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.customer').' '.trans('messages.note'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1]); ?>

				    		<span class="countdown"></span>
				    	</div>
				    </div>
				    <div class="col-md-6">
						<div class="form-group">
							<?php echo Form::label('tnc',trans('messages.tnc'),[]); ?>

				    		<?php echo Form::textarea('tnc',isset($invoice->tnc) ? $invoice->tnc : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.tnc'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1]); ?>

				    		<span class="countdown"></span>
					    </div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<?php echo Form::label('memo',trans('messages.memo'),[]); ?>

				    		<?php echo Form::textarea('memo',isset($invoice->memo) ? $invoice->memo : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.memo'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1]); ?>

				    		<span class="countdown"></span>
					  	</div>
					</div>
				</div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.0/jquery.js"></script>

<script>   
$('#customer').on("change",function() {
$cust_id=this.value;
console.log(this.value);
            $.ajax({
                url: '/cust-data',
                type: 'GET',
                data: { id: $cust_id },
                dataType : 'json',
                success: function(resp)
                {     
                     console.log(resp);
                   document.getElementById("cust_table").style.display = 'block';
              
                   document.getElementById("cust_name").innerHTML= resp.customername;
                   document.getElementById("address").innerHTML= resp.address;
                   document.getElementById("business_type").innerHTML= resp.business_type;
                   document.getElementById("cust_country").innerHTML= resp.country;   
                   document.getElementById("cust_state").innerHTML= resp.state;  
                   document.getElementById("cust_city").innerHTML= resp.city;  
                   document.getElementById("cust_zip").innerHTML= resp.zip; 
                   document.getElementById("cust_ext").innerHTML= resp.ext; 
                   document.getElementById("cust_int").innerHTML= resp.int;    
                   document.getElementById("cust_tax_id").innerHTML= resp.tax_id;         
                   document.getElementById("cust_neighbourhood").innerHTML= resp.neighboorhood;         


                 }
                     
                
            });
       });
   
</script>

<script>   
$('#shipment_address').on("change",function() {
$ship_id=this.value;
console.log(this.value);
            $.ajax({
                url: '/shipment-data',
                type: 'GET',
                data: { id: $ship_id},
                dataType : 'json',
                success: function(resp)
                {     
                     console.log(resp);
                   document.getElementById("ship_addr_table").style.display = 'block';              
                   document.getElementById("ship_id").innerHTML= resp.ship_id;
                   document.getElementById("ship_address").innerHTML= resp.address;    
                   document.getElementById("ship_country").innerHTML= resp.country;   
                   document.getElementById("ship_state").innerHTML= resp.state;  
                   document.getElementById("ship_city").innerHTML= resp.city;  
                   document.getElementById("ship_zip").innerHTML= resp.zip; 
                   document.getElementById("ship_ext").innerHTML= resp.ext; 
                   document.getElementById("ship_int").innerHTML= resp.int; 
                   document.getElementById("ship_neighbourhood").innerHTML= resp.neighboorhood;         
                
                 }
                     
                
            });
       });
   
</script>