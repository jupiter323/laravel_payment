			<div class="col-sm-6">
			  <div class="form-group">
			    <?php echo Form::label('company_name',trans('messages.company').' '.trans('messages.name'),[]); ?>

				<?php echo Form::input('text','company_name',(config('config.company_name')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.company').' '.trans('messages.name')]); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('contact_person',trans('messages.contact').' '.trans('messages.person'),[]); ?>

				<?php echo Form::input('text','contact_person',(config('config.contact_person')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.contact').' '.trans('messages.person')]); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('company_email',trans('messages.email'),[]); ?>

				<?php echo Form::input('text','company_email',(config('config.company_email')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.email')]); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('company_phone',trans('messages.phone'),[]); ?>

				<?php echo Form::input('text','company_phone',(config('config.company_phone')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.phone')]); ?>

			  </div>
			  <div class="form-group">
			    <?php echo Form::label('company_website',trans('messages.website'),[]); ?>

				<?php echo Form::input('text','company_website',(config('config.company_website')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.website')]); ?>

			  </div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
				    <?php echo Form::label('company_address_line_1',trans('messages.address'),[]); ?>

					<?php echo Form::input('text','company_address_line_1',(config('config.company_address_line_1')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.address_line_1')]); ?>

					<br />
					<?php echo Form::input('text','company_address_line_2',(config('config.company_address_line_2')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.address_line_2')]); ?>

					<br />
					<div class="row">
						<div class="col-xs-5">
						<?php echo Form::input('text','company_city',(config('config.company_city')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.city')]); ?>

						</div>
						<div class="col-xs-4">
						<?php echo Form::input('text','company_state',(config('config.company_state')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.state')]); ?>

						</div>
						<div class="col-xs-3">
						<?php echo Form::input('text','company_zipcode',(config('config.company_zipcode')) ? : '',['class'=>'form-control','placeholder'=>trans('messages.zipcode')]); ?>

						</div>
					</div>
					<br />
					<?php echo Form::select('company_country_id', config('country'),(config('config.company_country_id')) ? : '',['class'=>'form-control show-tick','title'=>trans('messages.country')]); ?>

				</div>
				<input type="hidden" name="config_type" class="hidden_fields" readonly value="general">
			  	<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

			</div>
