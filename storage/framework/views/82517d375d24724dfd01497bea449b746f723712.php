	<div class="row">	
		<div class="col-md-6">
			<div class="form-group">
				<?php echo Form::label('item_category_id',trans('messages.item').' '.trans('messages.category'),['class' => 'control-label']); ?>

				<?php echo Form::select('item_category_id', $item_categories, isset($item) ? $item->item_category_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

			</div>
			<div class="form-group">
			<?php echo Form::label('name',trans('messages.name'),[]); ?>

			<?php echo Form::input('text','name',isset($item) ? $item->name : '',['class'=>'form-control','placeholder'=>trans('messages.name')]); ?>

			</div>
			<div class="form-group">
			<?php echo Form::label('code',trans('messages.item').' '.trans('messages.code'),[]); ?>

			<?php echo Form::input('text','code',isset($item) ? $item->code : '',['class'=>'form-control','placeholder'=>trans('messages.item').' '.trans('messages.code')]); ?>

			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<?php echo Form::label('taxation_id',trans('messages.default').' '.trans('messages.taxation'),['class' => 'control-label']); ?>

				<?php echo Form::select('taxation_id', $taxations, isset($item) ? $item->taxation_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

			</div>
			<div class="form-group">
			<?php echo Form::label('discount',trans('messages.default').' '.trans('messages.item').' '.trans('messages.discount').' (%)',[]); ?>

			<?php echo Form::input('numeric','discount',isset($item) ? $item->discount : '',['class'=>'form-control','placeholder'=>trans('messages.default').' '.trans('messages.item').' '.trans('messages.discount')]); ?>

			</div>
			<div class="form-group">
				<?php echo Form::label('description',trans('messages.description'),[]); ?>

				<?php echo Form::textarea('description',isset($item) ? $item->description : '',['size' => '30x4', 'class' => 'form-control', 'placeholder' => trans('messages.description'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit')]); ?>

				<span class="countdown"></span>
			</div>
		</div>
	</div>
	<?php echo e(getCustomFields('item-form',$custom_field_values)); ?>

	<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

