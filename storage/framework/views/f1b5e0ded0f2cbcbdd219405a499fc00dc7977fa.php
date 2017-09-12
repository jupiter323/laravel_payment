

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
				       	 <div class="tab-content col-md-12 col-xs-12" style="padding:0px 25px 10px 25px;">

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
					    </div> 						 
                                        </div>
                                    </div> </div>

	<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>