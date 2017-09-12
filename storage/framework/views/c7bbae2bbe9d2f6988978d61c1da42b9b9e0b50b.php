	<?php $__env->startSection('breadcrumb'); ?>
		<ul class="breadcrumb">
		    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
		    <li class="active"><?php echo trans('messages.configuration'); ?></li>
		</ul>
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row">
			<div class="col-sm-12">
				<div class="box-info full">
					<div class="tabs-left">	
						<ul class="nav nav-tabs col-md-2 tab-list" style="padding-right:0;">
		                    <li><a href="#general-tab" data-toggle="tab"><?php echo e(trans('messages.general')); ?></a>
		                    </li>
		                    <li><a href="#logo-tab" data-toggle="tab"><?php echo e(trans('messages.logo')); ?></a>
		                    </li>
		                    <li><a href="#theme-tab" data-toggle="tab"><?php echo e(trans('messages.theme')); ?></a>
		                    </li>
		                    <li><a href="#system-tab" data-toggle="tab"><?php echo e(trans('messages.system')); ?></a>
		                    </li>
		                    <li><a href="#mail-tab" data-toggle="tab"><?php echo e(trans('messages.mail')); ?></a>
		                    </li>
		                    <li><a href="#sms-tab" data-toggle="tab">SMS</a>
		                    </li>
		                    <li><a href="#auth-tab" data-toggle="tab"><?php echo e(trans('messages.authentication')); ?></a>
		                    </li>
		                    <li><a href="#social-login-tab" data-toggle="tab"><?php echo e(trans('messages.social').' '.trans('messages.login')); ?></a>
		                    </li>
		                    <li><a href="#menu-tab" data-toggle="tab"><?php echo e(trans('messages.menu')); ?></a>
		                    </li>
		                    <li><a href="#payment-gateway-tab" data-toggle="tab"><?php echo e(trans('messages.payment').' '.trans('messages.gateway')); ?></a>
		                    </li>
		                    <li><a href="#currency-tab" data-toggle="tab"><?php echo e(trans('messages.currency')); ?></a>
		                    </li>
		                    <li><a href="#taxation-tab" data-toggle="tab"><?php echo e(trans('messages.taxation')); ?></a>
		                    </li>
		                    <li><a href="#customer-tab" data-toggle="tab"><?php echo e(trans('messages.customer')); ?></a>
		                    </li>
		                    <li><a href="#expense-tab" data-toggle="tab"><?php echo e(trans('messages.expense')); ?></a>
		                    </li>
		                    <li><a href="#income-tab" data-toggle="tab"><?php echo e(trans('messages.income')); ?></a>
		                    </li>
		                    <li><a href="#item-tab" data-toggle="tab"><?php echo e(trans('messages.item')); ?></a>
		                    </li>
		                    <li><a href="#invoice-tab" data-toggle="tab"><?php echo e(trans('messages.invoice')); ?></a>
		                    </li>
		                    <li><a href="#quotation-tab" data-toggle="tab"><?php echo e(trans('messages.quotation')); ?></a>
		                    </li>
		                    <li><a href="#payment-tab" data-toggle="tab"><?php echo e(trans('messages.payment')); ?></a>
		                    </li>
		                    <li><a href="#schedule-job-tab" data-toggle="tab"><?php echo e(trans('messages.scheduled_job')); ?></a>
		                    </li>
		                </ul>

				        <div class="tab-content col-md-10 col-xs-10" style="padding:0px 25px 10px 25px;">
						  <div class="tab-pane animated fadeInRight" id="general-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo e(trans('messages.general')); ?></strong> <?php echo e(trans('messages.configuration')); ?></h2>
						    	<?php echo Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-general-form','id' => 'config-general-form','data-no-form-clear' => 1]); ?>

                                    <?php echo $__env->make('configuration._general_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php echo Form::close(); ?>

						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="logo-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo e(trans('messages.logo')); ?></strong></h2>
						    	<?php echo Form::open(['files' => true, 'route' => 'configuration.logo','role' => 'form', 'class'=>'config-logo-form','id' => 'config-logo-form']); ?>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="file" class="btn btn-default file-input" name="company_logo" id="company_logo" data-buttonText="<?php echo trans('messages.select').' '.trans('messages.logo'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php if(config('config.company_logo') && File::exists(config('constant.upload_path.company_logo').config('config.company_logo'))): ?>
                                    <div class="form-group">
                                        <img src="<?php echo e(URL::to(config('constant.upload_path.company_logo').config('config.company_logo'))); ?>" width="150px" style="margin-left:20px;">
                                        <div class="checkbox">
                                            <label>
                                              <input name="remove_logo" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" data-off-value="0"> <?php echo trans('messages.remove').' '.trans('messages.logo'); ?>

                                            </label>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                <?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary']); ?>

                                <?php echo Form::close(); ?>

						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="theme-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo e(trans('messages.theme')); ?></strong> <?php echo e(trans('messages.configuration')); ?></h2>
						    	<?php echo Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-theme-form','id' => 'config-theme-form']); ?>

                                    <?php echo $__env->make('configuration._theme_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php echo Form::close(); ?>

						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="system-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo e(trans('messages.system')); ?></strong> <?php echo e(trans('messages.configuration')); ?></h2>
						    	<?php echo Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-system-form','id' => 'config-system-form','data-disable-enter-submission' => '1','data-no-form-clear' => 1]); ?>

                                    <?php echo $__env->make('configuration._system_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php echo Form::close(); ?>

						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="mail-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo e(trans('messages.mail')); ?></strong> <?php echo e(trans('messages.mail')); ?></h2>
						    	<?php echo Form::open(['route' => 'configuration.mail','role' => 'form', 'class'=>'config-mail-form','id' => 'config-mail-form','data-no-form-clear' => 1]); ?>

                                    <?php echo $__env->make('configuration._mail_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php echo Form::close(); ?>

						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="sms-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>SMS</strong> <?php echo e(trans('messages.configuration')); ?></h2>
						    	<?php echo Form::open(['route' => 'configuration.sms','role' => 'form', 'class'=>'config-sms-form','id' => 'config-sms-form','data-no-form-clear' => 1]); ?>

                                    <?php echo $__env->make('configuration._sms_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php echo Form::close(); ?>

						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="auth-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo e(trans('messages.authentication')); ?></strong></h2>
						    	<?php echo Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-auth-form','id' => 'config-auth-form','data-no-form-clear' => 1]); ?>

                                    <?php echo $__env->make('configuration._auth_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php echo Form::close(); ?>

						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="social-login-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo e(trans('messages.social')); ?></strong> <?php echo e(trans('messages.login')); ?></h2>
						    	<?php echo Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-social-login-form','id' => 'config-social-login-form','data-no-form-clear' => 1]); ?>

                                    <?php echo $__env->make('configuration._social_login_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php echo Form::close(); ?>

						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="menu-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo e(trans('messages.menu')); ?></strong> <?php echo e(trans('messages.configuration')); ?></h2>
						    	<?php echo Form::open(['route' => 'configuration.menu','role' => 'form', 'class'=>'config-menu-form','id' => 'config-menu-form','data-draggable' => 1,'data-no-form-clear' => 1,'data-sidebar' => 1]); ?>

								<div class="draggable-container">
									<?php $i = 0; ?>
									<?php $__currentLoopData = \App\Menu::orderBy('order')->orderBy('id')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php $i++; ?>
									  <div class="draggable" data-name="<?php echo e($menu_item->name); ?>" data-index="<?php echo e($i); ?>">
									    <p><input type="checkbox" class="icheck" name="<?php echo e($menu_item->name); ?>-visible" value="1" <?php echo e(($menu_item->visible) ? 'checked' : ''); ?>> <span style="margin-left:50px;"><?php echo e(toWord($menu_item->name)); ?></span></p>
									  </div>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</div>
								<?php echo Form::hidden('config_type','menu'); ?>

			  					<?php echo Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

								<?php echo Form::close(); ?>

						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="currency-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo trans('messages.currency').' '.trans('messages.configuration'); ?></strong></h2>
						    	<div class="row">
									<div class="col-sm-4">
										<div class="box-info">
											<h2><strong><?php echo trans('messages.add_new'); ?></strong> <?php echo trans('messages.currency'); ?> </h2>
											<?php echo Form::open(['route' => 'currency.store','class'=>'currency-form','id' => 'currency-form','data-table-refresh' => 'currency-table']); ?>

												<?php echo $__env->make('currency._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
											<?php echo Form::close(); ?>

										</div>
									</div>
									<div class="col-sm-8">
										<div class="box-info full">
											<h2><strong><?php echo trans('messages.list_all').'</strong> '.trans('messages.currency'); ?> </h2>
											<div class="table-responsive">
												<table data-sortable class="table table-hover table-striped ajax-table show-table" id="currency-table" data-source="/currency/lists">
													<thead>
														<tr>
															<th><?php echo trans('messages.name'); ?></th>
															<th><?php echo trans('messages.symbol'); ?></th>
															<th><?php echo trans('messages.position'); ?></th>
															<th><?php echo trans('messages.decimal'); ?></th>
															<th><?php echo trans('messages.default'); ?></th>
															<th data-sortable="false"><?php echo trans('messages.option'); ?></th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
										<div class="box-info">
											<h2><strong>Note</strong></h2>
											<div class="the-notes success" style="text-align:justify;">
												Choose default currency carefully, do not change default currency after making any transaction. Your calculation may go wrong if you change default currency after making transaction.
											</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="payment-gateway-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo e(trans('messages.payment').' '.trans('messages.gateway')); ?> </strong><?php echo trans('messages.configuration'); ?></h2>
						    	<?php echo Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-payment-gateway-form','id' => 'config-payment-gateway-form','data-no-form-clear' => 1]); ?>

						    		<?php echo $__env->make('configuration._payment_gateway_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php echo Form::close(); ?>


						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="taxation-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo trans('messages.taxation').' '.trans('messages.configuration'); ?></strong></h2>
						    	<div class="row">
									<div class="col-sm-4">
										<div class="box-info">
											<h2><strong><?php echo trans('messages.add_new'); ?></strong> <?php echo trans('messages.taxation'); ?> </h2>
											<?php echo Form::open(['route' => 'taxation.store','class'=>'taxation-form','id' => 'taxation-form','data-table-refresh' => 'taxation-table']); ?>

												<?php echo $__env->make('taxation._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
											<?php echo Form::close(); ?>

										</div>
									</div>
									<div class="col-sm-8">
										<div class="box-info full">
											<h2><strong><?php echo trans('messages.list_all').'</strong> '.trans('messages.taxation'); ?> </h2>
											<div class="table-responsive">
												<table data-sortable class="table table-hover table-striped ajax-table show-table" id="taxation-table" data-source="/taxation/lists">
													<thead>
														<tr>
															<th><?php echo trans('messages.name'); ?></th>
															<th><?php echo trans('messages.value'); ?></th>
															<th><?php echo trans('messages.description'); ?></th>
															<th><?php echo trans('messages.default'); ?></th>
															<th data-sortable="false"><?php echo trans('messages.option'); ?></th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="customer-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo trans('messages.customer').' '.trans('messages.configuration'); ?></strong></h2>
						    	<div class="row">
									<div class="col-sm-4">
										<div class="box-info">
											<h2><strong><?php echo trans('messages.add_new'); ?></strong> <?php echo trans('messages.customer').' '.trans('messages.group'); ?> </h2>
											<?php echo Form::open(['route' => 'customer-group.store','class'=>'customer-group-form','id' => 'customer-group-form','data-table-refresh' => 'customer-group-table']); ?>

												<?php echo $__env->make('customer_group._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
											<?php echo Form::close(); ?>

										</div>
									</div>
									<div class="col-sm-8">
										<div class="box-info full">
											<h2><strong><?php echo trans('messages.list_all').'</strong> '.trans('messages.customer').' '.trans('messages.group'); ?> </h2>
											<div class="table-responsive">
												<table data-sortable class="table table-hover table-striped ajax-table show-table" id="customer-group-table" data-source="/customer-group/lists">
													<thead>
														<tr>
															<th><?php echo trans('messages.name'); ?></th>
															<th><?php echo trans('messages.description'); ?></th>
															<th data-sortable="false"><?php echo trans('messages.option'); ?></th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="expense-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo trans('messages.expense').' '.trans('messages.configuration'); ?></strong></h2>
						    	<div class="row">
									<div class="col-sm-4">
										<div class="box-info">
											<h2><strong><?php echo trans('messages.add_new'); ?></strong> <?php echo trans('messages.expense').' '.trans('messages.category'); ?> </h2>
											<?php echo Form::open(['route' => 'expense-category.store','class'=>'expense-category-form','id' => 'expense-category-form','data-table-refresh' => 'expense-category-table']); ?>

												<?php echo $__env->make('expense_category._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
											<?php echo Form::close(); ?>

										</div>
									</div>
									<div class="col-sm-8">
										<div class="box-info full">
											<h2><strong><?php echo trans('messages.list_all').'</strong> '.trans('messages.expense').' '.trans('messages.category'); ?> </h2>
											<div class="table-responsive">
												<table data-sortable class="table table-hover table-striped ajax-table show-table" id="expense-category-table" data-source="/expense-category/lists">
													<thead>
														<tr>
															<th><?php echo trans('messages.name'); ?></th>
															<th><?php echo trans('messages.description'); ?></th>
															<th data-sortable="false"><?php echo trans('messages.option'); ?></th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="income-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo trans('messages.income').' '.trans('messages.configuration'); ?></strong></h2>
						    	<div class="row">
									<div class="col-sm-4">
										<div class="box-info">
											<h2><strong><?php echo trans('messages.add_new'); ?></strong> <?php echo trans('messages.income').' '.trans('messages.category'); ?> </h2>
											<?php echo Form::open(['route' => 'income-category.store','class'=>'income-category-form','id' => 'income-category-form','data-table-refresh' => 'income-category-table']); ?>

												<?php echo $__env->make('income_category._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
											<?php echo Form::close(); ?>

										</div>
									</div>
									<div class="col-sm-8">
										<div class="box-info full">
											<h2><strong><?php echo trans('messages.list_all').'</strong> '.trans('messages.income').' '.trans('messages.category'); ?> </h2>
											<div class="table-responsive">
												<table data-sortable class="table table-hover table-striped ajax-table show-table" id="income-category-table" data-source="/income-category/lists">
													<thead>
														<tr>
															<th><?php echo trans('messages.name'); ?></th>
															<th><?php echo trans('messages.description'); ?></th>
															<th data-sortable="false"><?php echo trans('messages.option'); ?></th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="item-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo trans('messages.item').' '.trans('messages.configuration'); ?></strong></h2>
						    	<div class="row">
									<div class="col-sm-4">
										<div class="box-info">
											<h2><strong><?php echo trans('messages.add_new'); ?></strong> <?php echo trans('messages.item').' '.trans('messages.category'); ?> </h2>
											<?php echo Form::open(['route' => 'item-category.store','class'=>'item-category-form','id' => 'item-category-form','data-table-refresh' => 'item-category-table']); ?>

												<?php echo $__env->make('item_category._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
											<?php echo Form::close(); ?>

										</div>
									</div>
									<div class="col-sm-8">
										<div class="box-info full">
											<h2><strong><?php echo trans('messages.list_all').'</strong> '.trans('messages.item').' '.trans('messages.category'); ?> </h2>
											<div class="table-responsive">
												<table data-sortable class="table table-hover table-striped ajax-table show-table" id="item-category-table" data-source="/item-category/lists">
													<thead>
														<tr>
															<th><?php echo trans('messages.name'); ?></th>
															<th><?php echo trans('messages.type'); ?></th>
															<th><?php echo trans('messages.description'); ?></th>
															<th data-sortable="false"><?php echo trans('messages.option'); ?></th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="invoice-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo trans('messages.invoice').' '.trans('messages.configuration'); ?></strong></h2>
						    	<?php echo $__env->make('configuration._invoice_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="quotation-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo trans('messages.quotation').' '.trans('messages.configuration'); ?></strong></h2>
						    	<?php echo $__env->make('configuration._quotation_form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="payment-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo trans('messages.payment').' '.trans('messages.configuration'); ?></strong></h2>
						    	<div class="row">
									<div class="col-sm-4">
										<div class="box-info">
											<h2><strong><?php echo trans('messages.add_new'); ?></strong> <?php echo trans('messages.payment').' '.trans('messages.method'); ?> </h2>
											<?php echo Form::open(['route' => 'payment-method.store','class'=>'payment-method-form','id' => 'payment-method-form','data-table-refresh' => 'payment-method-table']); ?>

												<?php echo $__env->make('payment_method._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
											<?php echo Form::close(); ?>

										</div>
									</div>
									<div class="col-sm-8">
										<div class="box-info full">
											<h2><strong><?php echo trans('messages.list_all').'</strong> '.trans('messages.payment').' '.trans('messages.method'); ?> </h2>
											<div class="table-responsive">
												<table data-sortable class="table table-hover table-striped ajax-table show-table" id="payment-method-table" data-source="/payment-method/lists">
													<thead>
														<tr>
															<th><?php echo trans('messages.name'); ?></th>
															<th><?php echo trans('messages.type'); ?></th>
															<th><?php echo trans('messages.description'); ?></th>
															<th data-sortable="false"><?php echo trans('messages.option'); ?></th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="schedule-job-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo e(trans('messages.scheduled_job')); ?></strong></h2>
						    	<p>Add below cron command in your server:</p>
								<div class="well">
									php /path-to-artisan schedule:run >> /dev/null 2>&1
								</div>
								<div class="table-responsive">
									<table class="table table-stripped table-bordered table-hover">
										<thead>
											<tr>
												<th>Action</th>
												<th>Frequency</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Recurring Invoice Generation</td>
												<td>Once Per day at 12:00 AM</td>
											</tr>
											<tr>
												<td>Birthday/Anniversary wish to Staff/Customer</td>
												<td>Once per day at 09:00 AM</td>
											</tr>
											<tr>
												<td>Daily Backup</td>
												<td>Once per day at 01:00 AM</td>
											</tr>
										</tbody>
									</table>
								</div>
						    </div>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>

	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>