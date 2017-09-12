

	<?php $__env->startSection('breadcrumb'); ?>
		<ul class="breadcrumb">
		    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
		    <li class="active"><?php echo trans('messages.email').' '.trans('messages.log'); ?></li>
		</ul>
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>

		<div class="row">
			<div class="col-sm-6 collapse" id="box-detail-filter">
				<div class="box-info">
					<h2><strong><?php echo trans('messages.filter'); ?></strong> <?php echo trans('messages.log'); ?>

					<div class="additional-btn">
						<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#box-detail-filter"><i class="fa fa-minus icon"></i> <?php echo trans('messages.hide'); ?></button>
					</div></h2>
					<?php echo Form::open(['url' => 'filter','id' => 'email-log-filter-form','data-no-form-clear' => 1]); ?>

						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label for="start_date_range"><?php echo e(trans('messages.date')); ?></label>
									<div class="input-daterange input-group">
									    <input type="text" class="input-sm form-control" name="start_date" readonly />
									    <span class="input-group-addon">to</span>
									    <input type="text" class="input-sm form-control" name="end_date" readonly />
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-default btn-success pull-right"><?php echo trans('messages.filter'); ?></button>
						</div>
					<?php echo Form::close(); ?>

				</div>
			</div>
		</div>
	
		<div class="row">
			<div class="col-sm-12">
				<div class="box-info full">
                    <h2>
						<strong><?php echo trans('messages.list_all'); ?></strong> <?php echo trans('messages.email').' '.trans('messages.log'); ?>

					</h2>
                    <div class="additional-btn">
						<a href="#" data-toggle="collapse" data-target="#box-detail-filter"><button class="btn btn-sm btn-primary"><i class="fa fa-filter icon"></i> <?php echo trans('messages.filter'); ?></button></a>
					</div>
					<?php echo $__env->make('global.datatable',['table' => $table_data['email-table']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				</div>
			</div>
		</div>

	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>