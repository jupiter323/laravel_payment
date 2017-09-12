	<div class="row">	
		<div class="col-md-4">
			<div class="form-group">
				<?php echo Form::label('item_id',trans('messages.item'),['class' => 'control-label']); ?>

				<?php echo Form::select('item_id', $items, isset($item_price) ? $item_price->item_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<?php echo Form::label('currency_id',trans('messages.currency'),['class' => 'control-label']); ?>

				<?php echo Form::select('currency_id', $currencies, isset($item_price) ? $item_price->currency_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<?php echo Form::label('unit_price',trans('messages.unit').' '.trans('messages.price'),['class' => 'control-label']); ?>

				<?php echo Form::input('text','unit_price',isset($item_price) ? round($item_price->unit_price,2) : '',['class'=>'form-control','placeholder'=>trans('messages.unit').' '.trans('messages.price')]); ?>

			</div>
		</div>
	</div>
	<?php echo e(getCustomFields('item-price-form',$custom_field_values)); ?>

	<div class="form-group">
		<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

	</div>