
			  <div class="form-group">
			    <?php echo Form::label('name',trans('messages.customer').' '.trans('messages.group'),[]); ?>

				<?php echo Form::input('text','name',isset($customer_group->name) ? $customer_group->name : '',['class'=>'form-control','placeholder'=>trans('messages.customer').' '.trans('messages.group')]); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('description',trans('messages.description'),[]); ?>

			    <?php echo Form::textarea('description',isset($customer_group->description) ? $customer_group->description : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.description'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1]); ?>

			    <span class="countdown"></span>
			  </div>
			  	<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

			  	
