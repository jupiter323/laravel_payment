				<div class="file-uploader" data-module="<?php echo e($module); ?>" data-key="" data-module-id="<?php echo e(isset($module_id) ? $module_id : ''); ?>">
					<div class="file-uploader-button" data-upload-button="<?php echo e(isset($upload_button) ? $upload_button : trans('messages.upload')); ?>" data-max-size="<?php echo e(config('config.max_file_size_upload')*1024*1024); ?>"></div>
					<span style="margin-top: 5px;" class="file-uploader-list"></span>
					<?php if(isset($uploads)): ?>
						<div style="margin-top: 10px;">
						<?php $__currentLoopData = $uploads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $upload): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<p><a href="#" data-ajax="1" data-extra="&id=<?php echo e($upload->id); ?>" data-source="/upload-temp-delete" class="click-alert-message mark-hidden"><i class="fa fa-times" style="color: red;margin-right: 10px;"></i></a> <?php echo e($upload->user_filename); ?></p>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					<?php endif; ?>
				</div>