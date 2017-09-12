
			  <div class="form-group">
			    <?php echo Form::label('name',trans('messages.department').' '.trans('messages.name'),[]); ?>

				<?php echo Form::input('text','name',isset($department) ? $department->name : '',['class'=>'form-control','placeholder'=>trans('messages.department').' '.trans('messages.name')]); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('description',trans('messages.description'),[]); ?>

			    <?php echo Form::textarea('description',isset($department) ? $department->description : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.description'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1]); ?>

			    <span class="countdown"></span>
			  </div>

				<?php echo e(getCustomFields('department-form',$custom_field_values)); ?>

				<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

