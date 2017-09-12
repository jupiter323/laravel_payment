<?php $__currentLoopData = \App\Designation::whereNull('top_designation_id')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<h4><?php echo $designation->designation_with_department; ?></h4>
	<?php echo createLineTreeView($tree,$designation->id); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>