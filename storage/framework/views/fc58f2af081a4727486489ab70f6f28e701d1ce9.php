			<div class="form-group">
			    <?php echo Form::label('theme_color','Color',[]); ?>

				<?php echo Form::select('theme_color', [
							'default' => 'Default',
							'blue' => 'Blue',
							'dark-blue' => 'Dark Blue',
							'grey' => 'Grey',
							'light' => 'Light'
				],(config('config.theme_color')) ? : 'default',['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

			</div>
            <div class="form-group">
			    <?php echo Form::label('theme_font','Font',[]); ?>

				<?php echo Form::select('theme_font', [
							'Arial' => 'Arial',
							'Verdana' => 'Verdana',
							'Tahoma' => 'Tahoma',
							'Open+Sans' => 'Open Sans',
							'Roboto' => 'Roboto',
							'Lato' => 'Lato',
							'Oswald' => 'Oswald',
							'Raleway' => 'Raleway',
				],(config('config.theme_font')) ? : 'default',['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

			</div>
			<div class="form-group">
			    <?php echo Form::label('direction',trans('messages.direction'),[]); ?>

				<?php echo Form::select('direction', [
							'ltr' => trans('messages.ltr'),
							'rtl' => trans('messages.rtl'),
				],(config('config.direction')) ? : 'ltr',['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

			</div>
			<input type="hidden" name="config_type" class="hidden_fields" value="theme">
			<?php echo Form::submit(trans('messages.save'),['class' => 'btn btn-primary']); ?>