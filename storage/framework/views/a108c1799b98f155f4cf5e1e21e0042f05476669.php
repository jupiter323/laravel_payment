<?php echo $__env->make('layouts.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <body class="tooltips">
        <div class="container">
            <div class="logo-brand header sidebar rows">
<?php
if (Auth::check())
     {
     $id=Auth::user()->id;
     }   
$profiles=\App\Profile::where('user_id',$id)->get();
foreach ($profiles as $profile)
{
$company_id=$profile['company_id'];
$companys=\App\Company::where('id',$company_id)->get();
}
 ?>
                <div class="logo">
                   <!-- <h1><a href="/"><?php echo e(config('config.application_name')); ?></a></h1>-->
<?php $__currentLoopData = $companys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <img src="/<?php echo e($company['logo']); ?>" alt="<?php echo e(config('config.application_name')); ?>" style="width:120px;">

                   <!-- <img src="/<?php echo e(config('config.company_logo')); ?>" alt="<?php echo e(config('config.application_name')); ?>" style="width:120px;">-->
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                </div>
            </div>

            <?php echo $__env->make('layouts.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <div class="right content-page">

                <?php echo $__env->make('layouts.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                <div class="body content rows scroll-y">

                    <?php echo $__env->yieldContent('breadcrumb'); ?>

                    <?php echo $__env->make('global.message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    
                    <?php echo $__env->yieldContent('content'); ?>

                    <?php echo $__env->make('layouts.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                </div>

            </div>

            <?php if($right_sidebar): ?>
                <div class="col-xs-7 col-sm-3 col-md-3 sidebar sidebar-right sidebar-animate">
                    <?php echo $__env->yieldContent('right_sidebar'); ?>
                </div>
            <?php endif; ?>
            
        <img id="loading-img" src="/images/loading.gif" />

        <div class="overlay"></div>
        <div class="modal fade-scale" id="myModal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                </div>
            </div>
        </div>

    </div>

    <?php echo $__env->make('layouts.foot', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>