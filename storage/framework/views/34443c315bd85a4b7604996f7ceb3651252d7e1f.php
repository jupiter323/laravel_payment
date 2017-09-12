	<div class="row">	
		<div class="col-md-6">
			<div class="form-group">
			<?php echo Form::label('title',trans('messages.title'),[]); ?>

			<?php echo Form::input('text','title',isset($announcement->title) ? $announcement->title : '',['class'=>'form-control','placeholder'=>trans('messages.title')]); ?>

			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
					<?php echo Form::label('from_date',trans('messages.from').' '.trans('messages.date'),[]); ?>

					<?php echo Form::input('text','from_date',isset($announcement->from_date) ? $announcement->from_date : '',['class'=>'form-control datepicker','placeholder'=>trans('messages.from').' '.trans('messages.date'),'readonly' => 'true']); ?>

					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?php echo Form::label('to_date',trans('messages.to').' '.trans('messages.date'),[]); ?>

						<?php echo Form::input('text','to_date',isset($announcement->to_date) ? $announcement->to_date : '',['class'=>'form-control datepicker','placeholder'=>trans('messages.to').' '.trans('messages.date'),'readonly' => 'true']); ?>

					</div>
				</div>
			</div>
		  	<div class="form-group">
			    <?php echo Form::label('audience',trans('messages.audience'),['class' => 'control-label ']); ?>

	            <div class="checkbox">
	            <input name="audience" type="checkbox" class="switch-input enable-show-hide" data-size="mini" data-on-text="<?php echo e(trans('messages.staff')); ?>" data-off-text="<?php echo e(trans('messages.customer')); ?>" value="1" <?php echo e((isset($announcement) && $announcement->audience) ? 'checked' : ''); ?> data-off-value="0">
	            </div>
          	</div>
          	<div id="audience_field">
				<div class="form-group">
					<?php echo Form::label('designation_id',trans('messages.designation'),['class' => 'control-label']); ?>

					<?php echo Form::select('designation_id[]', $designations, isset($selected_designation) ? $selected_designation : '',['class'=>'form-control input-xlarge show-tick','title'=>trans('messages.select_one'),'multiple' => true,'data-actions-box' => "true"]); ?>

					<div class="help-block"><?php echo trans('messages.leave_blank_for_all_designation'); ?></div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<?php echo Form::label('description',trans('messages.description'),[]); ?>

				<?php echo Form::textarea('description',isset($announcement->description) ? $announcement->description : '',['size' => '30x10', 'class' => 'form-control summernote', 'placeholder' => trans('messages.description')]); ?>

			</div>
			<?php echo $__env->make('upload.index',['module' => 'announcement','upload_button' => trans('messages.upload').' '.trans('messages.file'),'module_id' => isset($announcement) ? $announcement->id : ''], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		</div>
	</div>
	<?php echo e(getCustomFields('announcement-form',$custom_field_values)); ?>

	<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

