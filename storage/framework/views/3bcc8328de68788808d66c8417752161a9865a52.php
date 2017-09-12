		<div style="margin-top: 10px;">
			<?php $__currentLoopData = $uploads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $upload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<p><a href="#" data-ajax="1" data-extra="&id=<?php echo e($upload->id); ?>" data-source="/upload-delete" data-refresh="<?php echo e($upload->upload_key); ?>-list" class="click-alert-message"><i class="fa fa-times" style="color: red;margin-right: 10px;"></i></a> <?php echo e($upload->user_filename); ?></p>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>
