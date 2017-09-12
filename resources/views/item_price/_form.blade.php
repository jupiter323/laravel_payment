	<div class="row">	
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('item_id',trans('messages.item'),['class' => 'control-label'])!!}
				{!! Form::select('item_id', $items, isset($item_price) ? $item_price->item_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('currency_id',trans('messages.currency'),['class' => 'control-label'])!!}
				{!! Form::select('currency_id', $currencies, isset($item_price) ? $item_price->currency_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				{!! Form::label('unit_price',trans('messages.unit').' '.trans('messages.price'),['class' => 'control-label'])!!}
				{!! Form::input('text','unit_price',isset($item_price) ? round($item_price->unit_price,2) : '',['class'=>'form-control','placeholder'=>trans('messages.unit').' '.trans('messages.price')])!!}
			</div>
		</div>
	</div>
	{{ getCustomFields('item-price-form',$custom_field_values) }}
	<div class="form-group">
		{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
	</div>