

	<?php $__env->startSection('breadcrumb'); ?>
		<ul class="breadcrumb">
		    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
		    <li><a href="/invoice"><?php echo trans('messages.invoice'); ?></a></li>
		    <li class="active"><?php echo $invoice->Customer->full_name; ?></li>
		</ul>
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row">
			<div class="col-md-12">
				<div id="load-invoice-action-button" data-extra="&invoice_id=<?php echo e($invoice->id); ?>" data-source="/invoice-action-button" style="margin-bottom: 10px;"></div>
			</div>

			<?php if(Entrust::hasRole(config('constant.default_customer_role')) && config('config.enable_customer_payment')): ?>
			<div class="col-sm-12 collapse" id="customer-payment-detail">
				<div class="box-info full">
					<div class="tabs-left">	
						<ul class="nav nav-tabs col-md-2 tab-list" style="padding-right:0;">
							<?php if(config('config.enable_paypal_payment')): ?>
		                    	<li><a href="#paypal-tab" data-toggle="tab">Paypal</a></li>
		                    <?php endif; ?>
		                    <?php if(config('config.enable_stripe_payment')): ?>
		                    	<li><a href="#stripe-tab" data-toggle="tab">Stripe</a></li>
		                    <?php endif; ?>
		                    <?php if(config('config.enable_tco_payment')): ?>
		                    	<li><a href="#tco-tab" data-toggle="tab">Two Checkout</a></li>
		                    <?php endif; ?>
		                    <?php if($invoice->Currency->name == 'INR' && config('config.enable_payumoney_payment')): ?>
		                    	<li><a href="#payumoney-tab" data-toggle="tab">PayUMoney</a></li>
		                    <?php endif; ?>
		                </ul>

				        <div class="tab-content col-md-10 col-xs-10" style="padding:0px 25px 10px 25px;">
				          <?php if(config('config.enable_paypal_payment')): ?>
							  <div class="tab-pane animated fadeInRight" id="paypal-tab">
							    <div class="user-profile-content-wm">
							    	<h2><strong>Pay via Paypal</strong></h2>
							    	<?php echo Form::model($invoice,['method' => 'POST','route' => ['paypal',$invoice->id] ,'class' => 'paypal-payment-form','id' => 'paypal-payment-form','data-submit' => 'noAjax']); ?>

							    		<?php echo $__env->make('invoice._customer_payment_form',['gateway' => 'paypal'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
							    	<?php echo Form::close(); ?>

							    </div>
							  </div>
						  <?php endif; ?>
						  <?php if(config('config.enable_stripe_payment')): ?>
							  <div class="tab-pane animated fadeInRight" id="stripe-tab">
							    <div class="user-profile-content-wm">
							    	<h2><strong>Pay via Stripe (Credit Card)</strong></h2>
							    	<?php echo Form::model($invoice,['method' => 'POST','route' => ['stripe',$invoice->id] ,'class' => 'stripe-payment-form','id' => 'stripe-payment-form','data-submit' => 'noAjax']); ?>

							    		<?php echo $__env->make('invoice._customer_payment_form',['gateway' => 'stripe'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
							    	<?php echo Form::close(); ?>

							    </div>
							  </div>
						  <?php endif; ?>
						  <?php if(config('config.enable_tco_payment')): ?>
							  <div class="tab-pane animated fadeInRight" id="tco-tab">
							    <div class="user-profile-content-wm">
							    	<h2><strong>Pay via 2 Checkout (Credit Card)</strong></h2>
							    	<?php echo Form::model($invoice,['method' => 'POST','route' => ['tco',$invoice->id] ,'class' => 'tco-payment-form','id' => 'tco-payment-form','data-submit' => 'noAjax']); ?>

							    		<?php echo $__env->make('invoice._customer_payment_form',['gateway' => 'tco'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
							    	<?php echo Form::close(); ?>

							    </div>
							  </div>
						  <?php endif; ?>
						  <?php if($invoice->Currency->name == 'INR' && config('config.enable_payumoney_payment')): ?>
							  <div class="tab-pane animated fadeInRight" id="payumoney-tab">
							    <div class="user-profile-content-wm">
						    		<h2><strong>Pay via PayUMoney</strong></h2>
							    	<?php echo Form::model($invoice,['method' => 'POST','route' => ['payumoney',$invoice->id] ,'class' => 'payumoney-payment-form','id' => 'payumoney-payment-form','data-submit' => 'noAjax']); ?>

						    			<?php echo $__env->make('invoice._customer_payment_form',['gateway' => 'payumoney'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						    		<?php echo Form::close(); ?>

							    </div>
							  </div>
						  <?php endif; ?>
						</div>
		            </div>
				</div>
			</div>
			<?php endif; ?>

			<?php if(!Entrust::hasRole(config('constant.default_customer_role'))): ?>
			<div class="col-sm-12 collapse" id="recurring-detail">
				<div class="box-info">
					<h2><strong><?php echo trans('messages.recurring'); ?></strong> <?php echo trans('messages.invoice'); ?></h2>
					<div class="additional-btn">
						<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#recurring-detail"><i class="fa fa-minus icon"></i> <?php echo trans('messages.hide'); ?></button>
					</div>

					<?php echo Form::model($invoice,['method' => 'POST','route' => ['invoice.recurring',$invoice->id] ,'class' => 'invoice-recurring-form','id' => 'invoice-recurring-form','data-refresh' => 'load-invoice-action-button','data-no-form-clear' => 1]); ?>

						<div class="col-md-4">
							<div class="form-group">
							    <?php echo Form::label('is_recurring',trans('messages.recurring'),['class' => 'control-label ']); ?>

				                <div class="checkbox">
				                <input name="is_recurring" type="checkbox" class="switch-input enable-show-hide" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" <?php echo e(($invoice->is_recurring) ? 'checked' : ''); ?> data-off-value="0">
				                </div>
				            </div>
							<div id="is_recurring_field">
					            <div class="form-group">
									<?php echo Form::label('recurrence_from_date',trans('messages.recurrence').' '.trans('messages.from')); ?>

									<?php echo Form::input('text','recurrence_from_date',isset($invoice) ? $invoice->recurrence_from_date : $invoice->date,['class'=>'form-control datepicker','placeholder'=>trans('messages.recurrence').' '.trans('messages.from'),'readonly' => 'true']); ?>

								</div>
								<div class="form-group">
								    <?php echo Form::label('recurring_frequency',trans('messages.recurring').' '.trans('messages.frequency'),['class' => 'control-label ']); ?>

					                <?php echo Form::select('recurring_frequency', $recurring_days, $invoice->recurring_frequency,['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

					            </div>
					            <div class="form-group">
									<?php echo Form::label('recurrence_upto',trans('messages.recurrence').' '.trans('messages.upto')); ?>

									<?php echo Form::input('text','recurrence_upto',isset($invoice) ? $invoice->recurrence_upto : '',['class'=>'form-control datepicker','placeholder'=>trans('messages.recurrence').' '.trans('messages.upto'),'readonly' => 'true']); ?>

								</div>
							</div>
							<?php echo Form::submit(trans('messages.save'),['class' => 'btn btn-primary']); ?>

						</div>
						<div class="col-md-8">
							<div class="table-responsive">
								<table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="invoice-recurring-table" data-source="/invoice/recurring/lists" data-extra="&invoice_id=<?php echo e($invoice->id); ?>">
									<thead>
										<tr>
											<th><?php echo trans('messages.date'); ?></th>
											<th><?php echo trans('messages.status'); ?></th>
											<th data-sortable="false"><?php echo trans('messages.option'); ?></th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					<?php echo Form::close(); ?>

				</div>
			</div>

			<div class="col-sm-12 collapse" id="payment-detail">
				<div class="box-info">
					<h2><strong><?php echo trans('messages.add_new'); ?></strong> <?php echo trans('messages.payment'); ?></h2>
					<div class="additional-btn">
						<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#payment-detail"><i class="fa fa-minus icon"></i> <?php echo trans('messages.hide'); ?></button>
					</div>
					<?php if($invoice->status == 'draft'): ?>
						<?php echo $__env->make('global.notification',['message' => trans('messages.no_payment_on_draft_invoice'),'type' => 'danger'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					<?php elseif($invoice->is_cancelled): ?>
						<?php echo $__env->make('global.notification',['message' => trans('messages.no_payment_on_cancelled_invoice'),'type' => 'danger'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					<?php else: ?>
						<div class="col-md-5">
							<?php echo Form::model($invoice,['method' => 'POST','route' => ['invoice.payment',$invoice->id] ,'class' => 'invoice-payment-form','id' => 'invoice-payment-form','data-disable-enter-submission' => 1,'data-table-refresh' => 'invoice-payment-table','data-refresh' => 'load-invoice-status','files' => true,'data-file-upload' => '.file-uploader']); ?>

								<?php echo $__env->make('invoice._payment_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
							<?php echo Form::close(); ?>

						</div>
						<div class="col-md-7">
							<div class="table-responsive">
								<table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="invoice-payment-table" data-source="/invoice/payment/lists" data-extra="&invoice_id=<?php echo e($invoice->id); ?>">
									<thead>
										<tr>
											<th><?php echo trans('messages.account'); ?></th>
											<th><?php echo trans('messages.date'); ?></th>
											<th><?php echo trans('messages.amount'); ?></th>
											<th><?php echo trans('messages.method'); ?></th>
											<th data-sortable="false" style="width:150px;"><?php echo trans('messages.option'); ?></th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
			
			<div class="col-sm-12 collapse" id="email-detail">
				<div class="box-info">
					<h2><strong><?php echo trans('messages.email'); ?></strong> <?php echo trans('messages.log'); ?></h2>
					<div class="additional-btn">
						<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#email-detail"><i class="fa fa-minus icon"></i> <?php echo trans('messages.hide'); ?></button>
					</div>
					<div class="table-responsive custom-scrollbar">
						<table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="invoice-email-table" data-source="/invoice/email/lists" data-extra="&invoice_id=<?php echo e($invoice->id); ?>">
							<thead>
								<tr>
									<th><?php echo trans('messages.to'); ?></th>
									<th><?php echo trans('messages.subject'); ?></th>
									<th><?php echo trans('messages.date'); ?></th>
									<th data-sortable="false" style="width:150px;"><?php echo trans('messages.option'); ?></th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<?php echo $__env->make('invoice.invoice', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

		<?php if($invoice_uploads->count()): ?>
		<div class="row">
			<div class="col-md-12">
				<div class="box-info">
					<h2><strong><?php echo e(trans('messages.attachment')); ?></strong></h2>
		            <?php $__currentLoopData = $invoice_uploads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice_upload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                <p><i class="fa fa-paperclip"></i> <a href="/invoice/<?php echo e($invoice_upload->attachments); ?>/download"><?php echo e($invoice_upload->user_filename); ?></a></p>
		            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        		</div>
			</div>
		</div>
		<?php endif; ?>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>