

<?php $__env->startSection('content'); ?>

<div class="full-content-center animated fadeInDownBig">

    <?php echo getCompanyLogo(); ?>

    
    <div class="login-wrap">
        <div class="box-info">
        <h2 class="text-center"><strong><?php echo e(trans('messages.verify')); ?></strong> <?php echo e(trans('messages.purchase')); ?></h2>
            <form role="form" action="<?php echo URL::to('/verify-purchase'); ?>" method="post" class="verify-purchase-form" id="verify-purchase-form">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                <input type="text" name="envato_username" id="envato_username" class="form-control text-input" placeholder="Envato Username">
                </div>
                <div class="form-group">
                <input type="text" name="purchase_code" id="purchase_code" class="form-control text-input" placeholder="Purchase Code">
                </div>
                <div class="row">
                    <div class="col-sm-12">
                    <button type="submit" class="btn btn-success btn-block"><i class="fa fa-unlock"></i> Verify</button>
                    </div>
                </div>
            </form>
            <p class="text-center"><a href="<?php echo URL::to('/'); ?>"><i class="fa fa-lock"></i> <?php echo trans('messages.back_to').' '.trans('messages.login'); ?></a></p>
        </div>
    </div>
</div>
<form id="logout-form" action="/logout" method="POST" style="display: none;">
    <?php echo e(csrf_field()); ?>

</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guest', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>