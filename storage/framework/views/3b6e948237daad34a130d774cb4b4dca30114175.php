<ul class="media-list">
<?php $__currentLoopData = $chats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="media">
    <a class="pull-<?php echo e(($chat->user_id == Auth::user()->id) ? 'right' : 'left'); ?>" href="#">
      <?php echo getAvatar($chat->user_id,45); ?>

    </a>
    <div class="media-body <?php echo e(getColor()); ?>">
      <strong><?php echo e($chat->User->full_name); ?></strong><br />
      <?php echo e($chat->message); ?>

      <p class="time"><?php echo e(timeAgo($chat->created_at)); ?></p>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>