	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<?php echo Form::label('enable_social_login',trans('messages.enable').' Social Login',['class' => 'control-label ']); ?>

				<div class="checkbox">
					<input name="enable_social_login" type="checkbox" class="switch-input enable-show-hide" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" <?php echo e((config('config.enable_social_login') == 1) ? 'checked' : ''); ?> data-off-value="0">
				</div>
			</div>
		</div>
		<div id="enable_social_login_field">
			<?php $__currentLoopData = config('constant.social_login_provider'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="col-md-4">
					<div class="form-group">
						<?php echo Form::label('enable_'.$provider.'_login',trans('messages.enable').' '.toWord($provider).' Login',['class' => 'control-label ']); ?>

						<div class="checkbox">
							<input name="enable_<?php echo e($provider); ?>_login" type="checkbox" class="switch-input enable-show-hide" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" <?php echo e((config('config.enable_'.$provider.'_login') == 1) ? 'checked' : ''); ?> data-off-value="0">
						</div>
					</div>
					<div id="enable_<?php echo e($provider); ?>_login_field">
						<div class="form-group">
							<?php echo Form::label($provider.'_client_id',toWord($provider).' Client Id',[]); ?>

							<?php echo Form::input('text',$provider.'_client_id',(config('config.'.$provider.'_client_id')) ? config('config.hidden_value') : '',['class'=>'form-control','placeholder'=>toWord($provider).' Client Id']); ?>

						</div>
						<div class="form-group">
							<?php echo Form::label($provider.'_client_secret',toWord($provider).' Client Secret',[]); ?>

							<?php echo Form::input('text',$provider.'_client_secret',(config('config.'.$provider.'_client_secret')) ? config('config.hidden_value') : '',['class'=>'form-control','placeholder'=>toWord($provider).' Client Secret']); ?>

						</div>
						<div class="form-group">
							<?php echo Form::label($provider.'_redirect',toWord($provider).' App Redirect URL',[]); ?>

							<?php echo Form::input('text',$provider.'_redirect',(config('config.'.$provider.'_redirect')) ? config('config.hidden_value') : '',['class'=>'form-control','placeholder'=>toWord($provider).' App Redirect URL']); ?>

						</div>
					</div>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
	</div>
	<div class="form-group">
		<input type="hidden" name="config_type" class="hidden_fields" value="social_login">
		<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

	</div>