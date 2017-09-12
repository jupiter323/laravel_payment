

	<?php $__env->startSection('breadcrumb'); ?>
		<ul class="breadcrumb">
		    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
		    <li><a href="/localization"><?php echo trans('messages.localization'); ?></a></li>
		    <li class="active"><?php echo config('localization.'.$locale.'.localization'); ?></li>
		</ul>
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row">
			<div class="col-sm-12">
				<div class="box-info full">
					<div class="tabs-left">	
						<ul class="nav nav-tabs col-md-2 tab-list" style="padding-right:0;">
						  <li><a href="#basic" data-toggle="tab"> <?php echo e(trans('messages.basic')); ?> </a></li>
						  <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						  <li><a href="#_<?php echo e($module); ?>" data-toggle="tab"> <?php echo trans('messages.'.$module); ?> (<?php echo e($word_count[$module]); ?>)</a></li>
						  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>
				        <div class="tab-content col-md-10 col-xs-10" style="padding:0px 25px 10px 25px;">
						  <div class="tab-pane animated fadeInRight" id="basic">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo e(trans('messages.basic')); ?></strong> <?php echo e(trans('messages.configuration')); ?></h2>

						    	<?php echo Form::model($localization,['method' => 'PATCH','route' => ['localization.plugin',$locale] ,'class' => 'localization-plugin-form','id'=>'localization-plugin-form','data-no-form-clear' => 1]); ?>

								  <div class="form-group">
								    <?php echo Form::label('datatable',trans('messages.table').' '.trans('messages.localization'),[]); ?>

									<?php echo Form::select('datatable', config('locale_datatable'),isset($locale) ? config('lang.'.$locale.'.datatable') : '',['class'=>'form-control input-xlarge show-tick','title'=>trans('messages.select_one')]); ?>

								  </div>
								  <div class="form-group">
								    <?php echo Form::label('calendar',trans('messages.calendar').' '.trans('messages.localization'),[]); ?>

									<?php echo Form::select('calendar', config('locale_calendar'),isset($locale) ? config('lang.'.$locale.'.calendar') : '',['class'=>'form-control input-xlarge show-tick','title'=>trans('messages.select_one')]); ?>

								  </div>
								  <div class="form-group">
								    <?php echo Form::label('datepicker',trans('messages.datepicker').' '.trans('messages.localization'),[]); ?>

									<?php echo Form::select('datepicker', config('locale_datepicker'),isset($locale) ? config('lang.'.$locale.'.datepicker') : '',['class'=>'form-control input-xlarge show-tick','title'=>trans('messages.select_one')]); ?>

								  </div>
								<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

								<?php echo Form::close(); ?>

						    </div>
						  </div>
				          <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						  <div class="tab-pane animated fadeInRight" id="_<?php echo e($module); ?>">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo e(trans('messages.'.$module)); ?></strong> <?php echo e(trans('messages.translation')); ?></h2>
						    		<?php echo Form::model($localization,['method' => 'PATCH','route' => ['localization.update-translation',$locale] ,'class' => 'form-horizontal','id'=>'localization_translation_'.$module, 'data-no-form-clear' => 1]); ?>

									<?php $__currentLoopData = $words; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $word): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($word['module'] == $module): ?>
										<div class="form-group">
									    	<?php echo Form::label($key,$word['value'],['class'=>'col-sm-6 control-label pull-left']); ?>

											<div class="col-sm-6">
												<?php if($locale == 'en'): ?>
												<?php echo Form::input('text',$key,(array_key_exists($key, $translation)) ? $translation[$key] : $word['value'],['class'=>'form-control','placeholder'=>trans('messages.translation')]); ?>

												<?php else: ?>
												<?php echo Form::input('text',$key,(array_key_exists($key, $translation)) ? $translation[$key] : '',['class'=>'form-control','placeholder'=>trans('messages.translation')]); ?>

												<?php endif; ?>
											</div>
									  	</div>
									  	<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									<?php echo Form::hidden('module',$module); ?>

									<?php echo Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

								<?php echo Form::close(); ?>

						    </div>
						  </div>
						  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						  <div class="clear"></div>
						</div>
					</div>
				</div>
			</div>
		</div>

	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>