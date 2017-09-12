

	<?php $__env->startSection('breadcrumb'); ?>
		<ul class="breadcrumb">
		    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
		    <li class="active"><?php echo trans('messages.expense'); ?></li>
		</ul>
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row">
			<div class="col-sm-12 collapse" id="box-detail-filter">
				<div class="box-info">
					<h2><strong><?php echo trans('messages.filter'); ?></strong> <?php echo trans('messages.expense'); ?>

					<div class="additional-btn">
						<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#box-detail-filter"><i class="fa fa-minus icon"></i> <?php echo trans('messages.hide'); ?></button>
					</div></h2>
					<?php echo Form::open(['url' => 'filter','id' => 'expense-filter-form','data-no-form-clear' => 1]); ?>

						<div class="col-md-3">
							<div class="form-group">
								<label for="reference_number"><?php echo trans('messages.reference').' '.trans('messages.number'); ?></label>
								<?php echo Form::input('text','reference_number','',['class'=>'form-control','placeholder'=>trans('messages.reference').' '.trans('messages.number')]); ?>

							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="reference_number"><?php echo trans('messages.token'); ?></label>
								<?php echo Form::input('text','token','',['class'=>'form-control','placeholder'=>trans('messages.token')]); ?>

							</div>
						</div>
						<div class="col-md-3">
						  	<div class="form-group">
								<label for="expense_category_id"><?php echo trans('messages.expense').' '.trans('messages.category'); ?></label>
								<?php echo Form::select('expense_category_id[]', $expense_categories,'',['class'=>'form-control show-tick','title'=>trans('messages.select_one'),'multiple' => 'multiple','data-actions-box' => "true"]); ?>

						  	</div>
						</div>
						<div class="col-md-3">
						  	<div class="form-group">
								<label for="currency_id"><?php echo trans('messages.currency'); ?></label>
								<?php echo Form::select('currency_id[]', $currencies,'',['class'=>'form-control show-tick','title'=>trans('messages.select_one'),'multiple' => 'multiple','data-actions-box' => "true"]); ?>

						  	</div>
						</div>
						<div class="col-md-3">
						  	<div class="form-group">
								<label for="customer_id"><?php echo trans('messages.customer'); ?></label>
								<?php echo Form::select('customer_id', $customers,'',['class'=>'form-control show-tick','title'=>trans('messages.select_one')]); ?>

						  	</div>
						</div>
						<div class="col-md-3">
						  	<div class="form-group">
								<label for="account_id"><?php echo trans('messages.account'); ?></label>
								<?php echo Form::select('account_id[]', $accounts,'',['class'=>'form-control show-tick','title'=>trans('messages.select_one'),'multiple' => 'multiple','data-actions-box' => "true"]); ?>

						  	</div>
						</div>
						<div class="col-md-3">
						  	<div class="form-group">
								<label for="payment_method_id"><?php echo trans('messages.payment').' '.trans('messages.method'); ?></label>
								<?php echo Form::select('payment_method_id[]', $payment_methods,'',['class'=>'form-control show-tick','title'=>trans('messages.select_one'),'multiple' => 'multiple','data-actions-box' => "true"]); ?>

						  	</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="date_range"><?php echo e(trans('messages.date')); ?></label>
								<div class="input-daterange input-group" id="datepicker">
								    <input type="text" class="input-sm form-control" name="start_date" readonly />
								    <span class="input-group-addon">to</span>
								    <input type="text" class="input-sm form-control" name="end_date" readonly />
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="checkbox">
		                        <label>
		                        	<input type="checkbox" class="icheck" name="has_attachment" value="1"> has <?php echo e(trans('messages.attachment')); ?>

		                        </label>
		                    </div>
						</div>
						<div class="clear"></div>
						<div class="form-group">
							<button type="submit" class="btn btn-default btn-success pull-right"><?php echo trans('messages.filter'); ?></button>
						</div>
					<?php echo Form::close(); ?>

				</div>
			</div>

			<?php if(Entrust::can('create-expense')): ?>
			<div class="col-sm-12 collapse" id="box-detail">
				<div class="box-info">
					<h2><strong><?php echo trans('messages.add_new'); ?></strong> <?php echo trans('messages.expense'); ?>

					<div class="additional-btn">
						<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#box-detail"><i class="fa fa-minus icon"></i> <?php echo trans('messages.hide'); ?></button>
					</div></h2>
					<?php echo Form::model($type,['method' => 'POST','route' => ['transaction.store',$type] ,'class' => 'transaction-form','id' => 'transaction-edit','files' => true,'data-disable-enter-submission' => 1,'data-file-upload' => '.file-uploader']); ?>

						<?php echo $__env->make('transaction._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					<?php echo Form::close(); ?>

				</div>
			</div>
			<?php endif; ?>

			<div class="col-sm-12">
				<div class="box-info full">
					<h2><strong><?php echo trans('messages.list_all'); ?></strong> <?php echo trans('messages.expense'); ?></h2>
					<div class="additional-btn">
						<a href="#" data-toggle="collapse" data-target="#box-detail-filter"><button class="btn btn-sm btn-primary"><i class="fa fa-filter icon"></i> <?php echo trans('messages.filter'); ?></button></a>
						<?php if(Entrust::can('create-expense')): ?>
							<a href="#" data-toggle="collapse" data-target="#box-detail"><button class="btn btn-sm btn-primary"><i class="fa fa-plus icon"></i> <?php echo trans('messages.add_new'); ?></button></a>
						<?php endif; ?>
					</div>
					<?php echo $__env->make('global.datatable',['table' => $table_data['expense-table']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				</div>
			</div>
		</div>

	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>