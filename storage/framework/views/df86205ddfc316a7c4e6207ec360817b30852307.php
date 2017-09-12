

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
					    </div> 						 
                                        </div>
                                    </div> </div>

	<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>