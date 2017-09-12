		<tr class="item-row" data-unique-id=<?php echo e($unique_id); ?>>
			<td><a href="#" class="delete-invoice-row"><i class="fa fa-times-circle fa-lg" style="color:red;"></i></a><a href="#" class="add-invoice-row"><i class="fa fa-plus-circle fa-lg" style="color:#337AB7;"></i></a></td>
			<td class="item-name"><?php echo Form::select('item_name['.$unique_id.']',['custom_item' => 'Custom Item'] + $items,'',['class'=>'form-control show-tick invoice-input','title'=>trans('messages.item'),'data-unique-id' => $unique_id,'id' => 'item_name_'.$unique_id,'data-type' => 'item-name'] ); ?></td>
			<td class="item-quantity"><input type="number" class="form-control invoice-input all-item-quantity" placeholder="<?php echo e(trans('messages.item').' '.trans('messages.quantity')); ?>" name="item_quantity[<?php echo e($unique_id); ?>]" id="item_quantity_<?php echo e($unique_id); ?>" step="<?php echo e(decimalValue(config('config.item_quantity_decimal_place'))); ?>"></td>


<td class="item-unit"><input type="text" class="form-control invoice-input all-item-unit" placeholder="<?php echo e(trans('messages.item').' '.trans('messages.unit')); ?>" name="unit[<?php echo e($unique_id); ?>]" id="item_unit_<?php echo e($unique_id); ?>" step="">
</td>

			<td class="item-price"><input type="number" class="form-control invoice-input all-item-price" placeholder="<?php echo e(trans('messages.item').' '.trans('messages.price')); ?>" name="item_price[<?php echo e($unique_id); ?>]" id="item_price_<?php echo e($unique_id); ?>" step=""></td>
   
<td class="item-subtotal1"></td>






		<td class="item-subtotal1"></td>


			<td class="item-discount"><input type="number" class="form-control invoice-input all-item-discount" placeholder="<?php echo e(trans('messages.item').' '.trans('messages.discount')); ?>" name="item_discount[<?php echo e($unique_id); ?>]" id="item_discount_<?php echo e($unique_id); ?>" step="<?php echo e(decimalValue(config('config.item_discount_decimal_place'))); ?>"><input type="checkbox" name="item_discount_type[<?php echo e($unique_id); ?>]" id="item_discount_type_<?php echo e($unique_id); ?>" class="all-item-discount-type icheck" data-unique-id="<?php echo e($unique_id); ?>" > <label id="item_discount_type_label_<?php echo e($unique_id); ?>" class="item_discount_type_label">(%)</label></td>

<td class="item-subtotal2"></td>


			<td class="item-tax"><input type="number" class="form-control invoice-input all-item-tax" placeholder="<?php echo e(trans('messages.item').' '.trans('messages.tax')); ?>" name="item_tax[<?php echo e($unique_id); ?>]" id="item_tax_<?php echo e($unique_id); ?>" step="<?php echo e(decimalValue(config('config.item_tax_decimal_place'))); ?>"></td>


<td class="item-subtotal3"></td>

			<td id="item_amount_<?php echo e($unique_id); ?>" class="all-item-amount" style="vertical-align:middle;"></td>


		</tr>
		<tr class="item-description item-description-row" data-unique-id=<?php echo e($unique_id); ?>>
			<td colspan="10"><input type="text" class="form-control invoice-input" placeholder="<?php echo e(trans('messages.item').' '.trans('messages.description')); ?>" name="item_description[<?php echo e($unique_id); ?>]" id="item_description_<?php echo e($unique_id); ?>">
			</td>
		</tr>

