
			  <div class="form-group">
			    <?php echo Form::label('name',trans('messages.currency').' '.trans('messages.name'),[]); ?>

				<?php echo Form::input('text','name',isset($currency) ? $currency->name : '',['class'=>'form-control','placeholder'=>trans('messages.currency').' '.trans('messages.name')]); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('name',trans('messages.currency').' '.trans('messages.symbol'),[]); ?>

				<?php echo Form::input('text','symbol',isset($currency) ? $currency->symbol : '',['class'=>'form-control','placeholder'=>trans('messages.currency').' '.trans('messages.symbol')]); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('decimal_place',trans('messages.currency').' '.trans('messages.decimal'),[]); ?>

				<?php echo Form::input('number','decimal_place',isset($currency) ? $currency->decimal_place : '',['class'=>'form-control','placeholder'=>trans('messages.currency').' '.trans('messages.decimal')]); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('position',trans('messages.currency').' '.trans('messages.position'),[]); ?>

				<?php echo Form::select('position', [
					'prefix'=>trans('messages.prefix'),
					'suffix' => trans('messages.suffix')
					],isset($currency) ? $currency->position : '',['class'=>'form-control show-tick','title'=>trans('messages.position')]); ?>

			  </div>
			  <div class="form-group">
			  <?php echo Form::label('is_default',trans('messages.default'),['class' => 'control-label ']); ?>

	                <div class="checkbox">
	                	<input name="is_default" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" <?php echo e((isset($currency) && $currency->is_default) ? 'checked' : ''); ?> data-off-value="0">
	                </div>
			  </div>
			  <?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

			  	
