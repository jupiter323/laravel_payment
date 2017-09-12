		<div class="col-md-6">	
			<div class="row">
				<div class="col-sm-6">
				  <div class="form-group">
				    <?php echo Form::label('account_id',trans('messages.account'),[]); ?>

					<?php echo Form::select('account_id', $accounts, isset($transaction) ? $transaction->account_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

				  </div>
				</div>
				<div class="col-sm-6">
				  <div class="form-group">
				  	<?php if($type == 'income'): ?>
					    <?php echo Form::label('income_category_id',trans('messages.income').' '.trans('messages.category'),[]); ?>

					    <?php echo Form::select('income_category_id', $income_categories, isset($transaction) ? $transaction->income_category_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

				    <?php elseif($type == 'expense'): ?>
				    	<?php echo Form::label('expense_category_id',trans('messages.expense').' '.trans('messages.category'),[]); ?>

				    	<?php echo Form::select('expense_category_id', $expense_categories, isset($transaction) ? $transaction->expense_category_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

				    <?php elseif($type == 'account-transfer'): ?>
				    	<?php echo Form::label('from_account_id',trans('messages.from').' '.trans('messages.account'),[]); ?>

						<?php echo Form::select('from_account_id', $accounts, isset($transaction) ? $transaction->from_account_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

				    <?php endif; ?>
				  </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
				  <div class="form-group">
				    <?php echo Form::label('payment_method_id',trans('messages.payment').' '.trans('messages.method'),[]); ?>

					<?php echo Form::select('payment_method_id', $payment_methods, isset($transaction) ? $transaction->payment_method_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

				  </div>
				</div>
				<div class="col-sm-6">
				  <div class="form-group">
				  	<?php if($type == 'income'): ?>
					    <?php echo Form::label('customer_id',trans('messages.payer'),[]); ?>

					    <?php echo Form::select('customer_id', $customers, isset($transaction) ? $transaction->customer_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

				    <?php elseif($type == 'expense'): ?>
				    	<?php echo Form::label('customer_id',trans('messages.payee'),[]); ?>

				    	<?php echo Form::select('customer_id', $customers, isset($transaction) ? $transaction->customer_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

				    <?php endif; ?>
				  </div>
				</div>
			</div>
			<div class="form-group">
			    <?php echo Form::label('tags',trans('messages.tags'),[]); ?>

				<?php echo Form::input('text','tags',isset($transaction) ? $transaction->tags : '',['class'=>'form-control','placeholder'=>trans('messages.tags'),'data-role' => 'tagsinput']); ?>

			</div>
			<div class="form-group">
				<?php echo $__env->make('upload.index',['module' => $type,'upload_button' => trans('messages.upload').' '.trans('messages.file'),'module_id' => isset($transaction) ? $transaction->id : ''], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				<?php echo Form::label('amount',trans('messages.amount'),['class' => 'control-label']); ?>

				<div class="row">
					<div class="col-md-4">
						<?php echo Form::select('currency_id', $currencies, isset($transaction) ? $transaction->currency_id : (($default_currency) ? $default_currency->id : ''),['class'=>'form-control show-tick','id' => 'currency-conversion','title'=>trans('messages.select_one'),'data-currency-date' => isset($transaction) ? $transaction->date : date('Y-m-d'),'data-currency-id' => isset($transaction) ? $transaction->currency_id : (($default_currency) ? $default_currency->id : '')]); ?>

					</div>
					<div class="col-md-8">
						<?php echo Form::input('text','amount',isset($transaction) ? round($transaction->amount,$transaction->Currency->decimal_place) : '',['class'=>'form-control','placeholder'=>trans('messages.amount')]); ?>

					</div>
					<div class="col-md-8">
						<div id="currency-conversion-field">
							<?php if(isset($transaction) && $transaction->currency_id != $default_currency->id): ?>
								<div class="form-group">
									<label class="conversion_rate"><?php echo e(trans('messages.conversion').' '.trans('messages.rate')); ?></label>
									<div class="input-group">
										<span class="input-group-addon">1 <?php echo e($default_currency->detail); ?> = </span>
										<?php echo Form::input('text','conversion_rate',isset($transaction) ? round($transaction->conversion_rate,5) : '',['class'=>'form-control','placeholder'=>trans('messages.conversion').' '.trans('messages.rate')]); ?>

										<span class="input-group-addon"><?php echo e($transaction->Currency->detail); ?> </span>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<?php echo Form::label('date',trans('messages.date'),[]); ?>

						<?php echo Form::input('text','date',isset($transaction) ? $transaction->date : date('Y-m-d'),['class'=>'form-control datepicker','id' => 'currency-date','placeholder'=>trans('messages.date'),'readonly' => 'true','data-currency-date' => isset($transaction) ? $transaction->date : date('Y-m-d'),'data-currency-id' => isset($transaction) ? $transaction->currency_id : (($default_currency) ? $default_currency->id : '')]); ?>

					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<?php echo Form::label('reference_number',trans('messages.reference').' '.trans('messages.number'),[]); ?>

						<?php echo Form::input('text','reference_number',isset($transaction) ? $transaction->reference_number : (config('config.random_transaction_reference_number') ? strtoupper(randomString(8)) : '' ),['class'=>'form-control','placeholder'=>trans('messages.reference').' '.trans('messages.number')]); ?>

					</div>
				</div>
			</div>
			<div class="form-group">
			    <?php echo Form::label('description',trans('messages.description'),[]); ?>

			    <?php echo Form::textarea('description',isset($transaction->description) ? $transaction->description : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.description'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1]); ?>

			    <span class="countdown"></span>
			</div>
		</div>
		<div class="col-md-12">
			<?php echo e(getCustomFields($type.'-form',$custom_field_values)); ?>

			<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

		</div>
		
