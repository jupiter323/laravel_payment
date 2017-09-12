			<div class="col-sm-6">
			  <div class="form-group">
			    <?php echo Form::label('name',trans('messages.company').' '.trans('messages.name'),[]); ?>

				<?php echo Form::input('text','name',(isset($company) ? $company->name : ''),['class'=>'form-control','placeholder'=>trans('messages.company').' '.trans('messages.name')]); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('website',trans('messages.website'),[]); ?>

				<?php echo Form::input('text','website',(isset($company) ? $company->website : ''),['class'=>'form-control','placeholder'=>trans('messages.website')]); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('email',trans('messages.email'),[]); ?>

				<?php echo Form::input('text','email',(isset($company) ? $company->email : ''),['class'=>'form-control','placeholder'=>trans('messages.email')]); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('phone',trans('messages.phone'),[]); ?>

				<?php echo Form::input('text','phone',(isset($company) ? $company->phone : ''),['class'=>'form-control','placeholder'=>trans('messages.phone')]); ?>

			  </div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
				    <?php echo Form::label('address',trans('messages.address'),[]); ?>

					<?php echo Form::input('text','address_line_1',(isset($company) ? $company->address_line_1 : ''),['class'=>'form-control','placeholder'=>trans('messages.address_line_1')]); ?>

					<br />
					<?php echo Form::input('text','address_line_2',(isset($company) ? $company->address_line_2 : ''),['class'=>'form-control','placeholder'=>trans('messages.address_line_2')]); ?>

					<br />
					<div class="row">
						<div class="col-xs-5">
						<?php echo Form::input('text','city',(isset($company) ? $company->city : ''),['class'=>'form-control','placeholder'=>trans('messages.city')]); ?>

						</div>
						<div class="col-xs-4">
						<?php echo Form::input('text','state',(isset($company) ? $company->state : ''),['class'=>'form-control','placeholder'=>trans('messages.state')]); ?>

						</div>
						<div class="col-xs-3">
						<?php echo Form::input('text','zipcode',(isset($company) ? $company->zipcode : ''),['class'=>'form-control','placeholder'=>trans('messages.zipcode')]); ?>

						</div>
					</div>
					<br />
					<?php echo Form::select('country_id', config('country'),(isset($company) ? $company->country_id : ''),['class'=>'form-control show-tick','title'=>trans('messages.country')]); ?>

				</div>
				<?php echo e(getCustomFields('company-form',$custom_field_values)); ?>

			  	<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

			</div>
