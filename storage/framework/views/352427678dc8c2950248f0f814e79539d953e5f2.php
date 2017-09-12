

	<?php $__env->startSection('breadcrumb'); ?>
		<ul class="breadcrumb">
		    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
		    <li class="active"><?php echo trans('messages.localization'); ?></li>
		</ul>
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row">
			<div class="col-sm-4">
				<div class="box-info">
					<h2><strong><?php echo trans('messages.add_new'); ?></strong> <?php echo trans('messages.word'); ?></h2>
					<?php echo Form::open(['route' => 'localization.add-words','role' => 'form', 'class'=>'translation-entry-form','id' => 'translation-entry-form']); ?>

			  		  <div class="form-group">
					    <?php echo Form::label('text','Key',[]); ?>

						<?php echo Form::input('text','key','',['class'=>'form-control','placeholder'=>'Key']); ?>

					  </div>
			  		  <div class="form-group">
					    <?php echo Form::label('text',trans('messages.word_or_sentence'),[]); ?>

						<?php echo Form::input('text','text','',['class'=>'form-control','placeholder'=>trans('messages.word_or_sentence')]); ?>

					  </div>
			  		  <div class="form-group">
					    <?php echo Form::label('module',trans('messages.module'),[]); ?>

						<?php echo Form::input('text','module','',['class'=>'form-control','placeholder'=>trans('messages.module')]); ?>

					  </div>
					<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

					<?php echo Form::close(); ?>

				</div>
				<div class="box-info">
					<h2><strong><?php echo trans('messages.add_new'); ?></strong> <?php echo trans('messages.localization'); ?></h2>
					<?php echo Form::open(['route' => 'localization.store','role' => 'form', 'class'=>'localization-form','id' => 'localization-form','data-form-table' => 'localization_table']); ?>

						<?php echo $__env->make('localization._form', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					<?php echo Form::close(); ?>

				</div>
			</div>
			<div class="col-sm-8">
				<div class="box-info full">
					<h2><strong><?php echo trans('messages.list_all'); ?></strong> <?php echo trans('messages.localization'); ?></h2>
					<?php echo $__env->make('global.datatable',['table' => $table_data['localization-table']], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				</div>
			</div>

		</div>

	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>