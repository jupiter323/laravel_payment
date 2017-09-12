
    <div class="progress">
        <div class="progress-bar progress-bar-<?php echo e(progressColor($setup_percentage)); ?>" role="progressbar" aria-valuenow="<?php echo e($setup_percentage); ?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo e($setup_percentage); ?>%;">
        <?php echo e($setup_percentage); ?>%
        </div>
    </div>
    <?php $__currentLoopData = $setup->chunk(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="row" style="padding:5px;">
            <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setup_guide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-xs-3">
                    <?php if($setup_guide->completed): ?>
                        <i class="fa fa-check-circle success fa-2x" style="vertical-align:middle;"></i> <?php echo e(toWord($setup_guide->module)); ?>

                    <?php else: ?>
                        <i class="fa fa-times-circle danger fa-2x" style="vertical-align:middle;"></i><a href="/<?php echo e(config('setup.'.$setup_guide->module.'.link')); ?>" <?php echo e(($con && config('setup.'.$setup_guide->module.'.tab') ? 'data-toggle="tab"' : '')); ?>> <?php echo e(toWord($setup_guide->module)); ?></a>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php if($setup_percentage == 100): ?>
        <p class="alert alert-success">Great! You have setup the application completely and ready to use. </p>
    <?php endif; ?>