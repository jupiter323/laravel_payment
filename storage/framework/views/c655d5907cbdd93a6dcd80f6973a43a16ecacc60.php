
			  <div class="form-group">
			    <?php echo Form::label('name',trans('messages.payment').' '.trans('messages.method'),[]); ?>

				<?php echo Form::input('text','name',isset($payment_method->name) ? $payment_method->name : '',['class'=>'form-control','placeholder'=>trans('messages.payment').' '.trans('messages.method')]); ?>

			  </div>
			<div class="form-group">
				<?php echo Form::label('type',trans('messages.type'),['class' => 'control-label']); ?>

				<?php echo Form::select('type', ['income' => trans('messages.income'),'expense' => trans('messages.expense'),'account_transfer' => trans('messages.account').' '.trans('messages.transfer')], isset($payment_method) ? $payment_method->type : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

			</div>
			  <div class="form-group">
			    <?php echo Form::label('description',trans('messages.description'),[]); ?>

			    <?php echo Form::textarea('description',isset($payment_method->description) ? $payment_method->description : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.description'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1]); ?>

			    <span class="countdown"></span>
			  </div>
			  	<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

			  	
