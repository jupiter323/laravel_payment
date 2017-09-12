			<div class="col-sm-6">
			  <div class="form-group">
			    <?php echo Form::label('group_name',trans('messages.group').' '.trans('messages.name'),[]); ?>

				<?php echo Form::input('text','group_name',(isset($company) ? $company->name : ''),['class'=>'form-control','placeholder'=>trans('messages.group').' '.trans('messages.name')]); ?>

			  </div>
			
			
					
			</div>
				<?php echo e(getCustomFields('company-form',$custom_field_values)); ?>

			  	<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

			</div>
