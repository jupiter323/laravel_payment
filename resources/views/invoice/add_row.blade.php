		<tr class="item-row" data-unique-id={{$unique_id}}>
			<td><a href="#" class="delete-invoice-row"><i class="fa fa-times-circle fa-lg" style="color:red;"></i></a><a href="#" class="add-invoice-row"><i class="fa fa-plus-circle fa-lg" style="color:#337AB7;"></i></a></td>
			<td class="item-name">{!! Form::select('item_name['.$unique_id.']',['custom_item' => 'Custom Item'] + $items,'',['class'=>'form-control show-tick invoice-input','title'=>trans('messages.item'),'data-unique-id' => $unique_id,'id' => 'item_name_'.$unique_id,'data-type' => 'item-name'] )!!}</td>
			<td class="item-quantity"><input type="number" class="form-control invoice-input all-item-quantity" placeholder="{{ trans('messages.item').' '.trans('messages.quantity')}}" name="item_quantity[{{$unique_id}}]" id="item_quantity_{{$unique_id}}" step="{{decimalValue(config('config.item_quantity_decimal_place'))}}"></td>


<td class="item-unit"><input type="text" class="form-control invoice-input all-item-unit" placeholder="{{ trans('messages.item').' '.trans('messages.unit') }}" name="unit[{{$unique_id}}]" id="item_unit_{{$unique_id}}" step="">
</td>

			<td class="item-price"><input type="number" class="form-control invoice-input all-item-price" placeholder="{{ trans('messages.item').' '.trans('messages.price') }}" name="item_price[{{$unique_id}}]" id="item_price_{{$unique_id}}" step=""></td>
   
<td class="item-subtotal1"></td>






		<td class="item-subtotal1"></td>


			<td class="item-discount"><input type="number" class="form-control invoice-input all-item-discount" placeholder="{{ trans('messages.item').' '.trans('messages.discount') }}" name="item_discount[{{$unique_id}}]" id="item_discount_{{$unique_id}}" step="{{decimalValue(config('config.item_discount_decimal_place'))}}"><input type="checkbox" name="item_discount_type[{{$unique_id}}]" id="item_discount_type_{{$unique_id}}" class="all-item-discount-type icheck" data-unique-id="{{$unique_id}}" > <label id="item_discount_type_label_{{$unique_id}}" class="item_discount_type_label">(%)</label></td>

<td class="item-subtotal2"></td>


			<td class="item-tax"><input type="number" class="form-control invoice-input all-item-tax" placeholder="{{trans('messages.item').' '.trans('messages.tax')}}" name="item_tax[{{$unique_id}}]" id="item_tax_{{$unique_id}}" step="{{decimalValue(config('config.item_tax_decimal_place'))}}"></td>


<td class="item-subtotal3"></td>

			<td id="item_amount_{{$unique_id}}" class="all-item-amount" style="vertical-align:middle;"></td>


		</tr>
		<tr class="item-description item-description-row" data-unique-id={{$unique_id}}>
			<td colspan="10"><input type="text" class="form-control invoice-input" placeholder="{{ trans('messages.item').' '.trans('messages.description') }}" name="item_description[{{$unique_id}}]" id="item_description_{{$unique_id}}">
			</td>
		</tr>

