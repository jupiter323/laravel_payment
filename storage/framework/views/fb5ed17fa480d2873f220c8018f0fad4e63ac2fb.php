
			  <div class="form-group">
			    <?php echo Form::label('name',trans('messages.item').' '.trans('messages.category'),[]); ?>

				<?php echo Form::input('text','name',isset($item_category->name) ? $item_category->name : '',['class'=>'form-control','placeholder'=>trans('messages.item').' '.trans('messages.category')]); ?>

			  </div>
			<div class="form-group">
				<?php echo Form::label('type',trans('messages.type'),['class' => 'control-label']); ?>

				<?php echo Form::select('type', ['product' => trans('messages.product'),'services' => trans('messages.services')], isset($item_category) ? $item_category->type : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

			</div>
			  <div class="form-group">
			    <?php echo Form::label('description',trans('messages.description'),[]); ?>

			    <?php echo Form::textarea('description',isset($item_category->description) ? $item_category->description : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.description'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1]); ?>

			    <span class="countdown"></span>
			  </div>
			  	<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

			  	
