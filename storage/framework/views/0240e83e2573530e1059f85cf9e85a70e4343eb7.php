			<div class="row">
				<div class="col-sm-6">
				  <div class="form-group">
				    <?php echo Form::label('name',trans('messages.account').' '.trans('messages.name'),[]); ?>

					<?php echo Form::input('text','name',(isset($account) ? $account->name : ''),['class'=>'form-control','placeholder'=>trans('messages.account').' '.trans('messages.name')]); ?>

				  </div>
				</div>
				<div class="col-sm-6">
				  <div class="form-group">
				    <?php echo Form::label('opening_balance',trans('messages.opening').' '.trans('messages.balance'),[]); ?>

					<?php echo Form::input('number','opening_balance',(isset($account) ? currency($account->opening_balance) : ''),['class'=>'form-control','placeholder'=>trans('messages.opening').' '.trans('messages.balance'),'step' => currencyDecimalValue()]); ?>

				  </div>
				</div>
			</div>
			<div class="form-group">
				<?php echo Form::label('type',trans('messages.type'),['class' => 'control-label ']); ?>

				<div class="checkbox">
					<input name="type" type="checkbox" class="switch-input enable-show-hide" data-size="mini" data-on-text="Bank" data-off-text="Cash" value="1" <?php echo e((isset($account) && $account->type == 'bank') ? 'checked' : ''); ?> data-off-value="0">
				</div>
			</div>
			<div id="type_field">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<?php echo Form::label('number',trans('messages.account').' '.trans('messages.number'),[]); ?>

							<?php echo Form::input('text','number',(isset($account) ? $account->number : ''),['class'=>'form-control','placeholder'=>trans('messages.account').' '.trans('messages.number')]); ?>

						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<?php echo Form::label('bank_name',trans('messages.bank').' '.trans('messages.name'),[]); ?>

							<?php echo Form::input('text','bank_name',(isset($account) ? $account->bank_name : ''),['class'=>'form-control','placeholder'=>trans('messages.bank').' '.trans('messages.name')]); ?>

						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<?php echo Form::label('branch_name',trans('messages.branch').' '.trans('messages.name'),[]); ?>

							<?php echo Form::input('text','branch_name',(isset($account) ? $account->branch_name : ''),['class'=>'form-control','placeholder'=>trans('messages.branch').' '.trans('messages.name')]); ?>

						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<?php echo Form::label('branch_code',trans('messages.branch').' '.trans('messages.code'),[]); ?>

							<?php echo Form::input('text','branch_code',(isset($account) ? $account->branch_code : ''),['class'=>'form-control','placeholder'=>trans('messages.branch').' '.trans('messages.code')]); ?>

						</div>
					</div>
				</div>
			</div>
			<?php echo e(getCustomFields('account-form',$custom_field_values)); ?>

		  	<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary']); ?>

