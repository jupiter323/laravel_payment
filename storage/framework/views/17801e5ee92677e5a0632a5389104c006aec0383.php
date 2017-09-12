
			  <div class="form-group">
			    <?php echo Form::label('department_id',trans('messages.department'),[]); ?>

				<?php echo Form::select('department_id', $departments,isset($designation) ? $designation->department_id : '',['class'=>'form-control input-xlarge show-tick','title' => trans('messages.select_one')]); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('top_designation_id',trans('messages.top').' '.trans('messages.designation'),[]); ?>

				<?php echo Form::select('top_designation_id', $top_designations,(isset($designation)) ? $designation->top_designation_id : '',['class'=>'form-control input-xlarge show-tick','title' => trans('messages.select_one'),'id' => 'top_designation_id']); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('name',trans('messages.designation'),[]); ?>

				<?php echo Form::input('text','name',isset($designation) ? $designation->name : '',['class'=>'form-control','placeholder'=>trans('messages.designation')]); ?>

			  </div>
			  	<?php echo e(getCustomFields('designation-form',$custom_field_values)); ?>

			  	<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

