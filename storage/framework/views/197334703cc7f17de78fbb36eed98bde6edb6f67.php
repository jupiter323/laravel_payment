
			  <div class="form-group">
			    <?php echo Form::label('locale',trans('messages.locale'),[]); ?>

			  	<?php if(!isset($locale)): ?>
					<?php echo Form::input('text','locale',isset($locale) ? $locale : '',['class'=>'form-control','placeholder'=>trans('messages.locale')]); ?>

				<?php else: ?>
					<?php echo Form::input('text','locale',isset($locale) ? $locale : '',['class'=>'form-control','placeholder'=>trans('messages.locale'),'readonly' => 'true']); ?>

				<?php endif; ?>	
			  </div>
			  <div class="form-group">
			    <?php echo Form::label('name',trans('messages.localization').' '.trans('messages.name'),[]); ?>

				<?php echo Form::input('text','name',isset($locale) ? config('lang.'.$locale.'.localization') : '',['class'=>'form-control','placeholder'=>trans('messages.localization').' '.trans('messages.name')]); ?>

			  </div>
			  	<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

