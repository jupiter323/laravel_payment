

	<?php $__env->startSection('breadcrumb'); ?>
        <ul class="breadcrumb">
		    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
		    <li class="active"><?php echo trans('messages.role'); ?></li>
		</ul>
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row">
			<div class="col-sm-4">
				<div class="box-info">
                    <h2>
                        <strong><?php echo trans('messages.add_new').'</strong> '.trans('messages.role'); ?>

                    </h2>
                    <?php echo Form::open(['route' => 'role.store','role' => 'form', 'class'=>'role-form','id' => 'role-form']); ?>

						<?php echo $__env->make('role._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					<?php echo Form::close(); ?>

                </div>
			</div>
			<div class="col-sm-8">
				<div class="box-info full">
                    <h2>
                        <strong><?php echo trans('messages.list_all').'</strong> '.trans('messages.role'); ?>

                    </h2>
					<?php echo $__env->make('global.datatable',['table' => $table_data['role-table']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
			</div>
		</div>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>