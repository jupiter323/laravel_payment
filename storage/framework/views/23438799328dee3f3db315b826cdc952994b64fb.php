
            <div class="col-sm-6">
                <div class="box-info">
                    <h2><strong><?php echo trans('messages.announcement'); ?></strong> </h2>
                    <div class="custom-scrollbar">
                    <?php if(count($announcements)): ?>
                        <?php $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="the-notes info">
                                <h4><a href="#" data-href="/announcement/<?php echo e($announcement->id); ?>" data-toggle="modal" data-target="#myModal"><?php echo $announcement->title; ?></a></h4>
                                <span style="color:green;"><i class="fa fa-clock-o"></i> <?php echo showDateTime($announcement->created_at); ?></span>
                                <p class="time pull-right" style="text-align:right;"><?php echo trans('messages.by').' '.$announcement->User->full_name.'<br />'.$announcement->User->designation_with_department; ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <?php echo $__env->make('global.notification',['type' => 'danger','message' => trans('messages.no_data_found')], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php endif; ?>
                    </div>
                </div>
            </div>