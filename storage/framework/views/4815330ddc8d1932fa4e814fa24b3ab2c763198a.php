<?php $__env->startSection('content'); ?>

<div class="full-content-center animated fadeInDownBig">

    <?php echo getCompanyLogo(); ?>

    
    <?php if(!getMode()): ?>
        <br />
        <br />
        <?php echo $__env->make('global.notification',['message' => 'Version 1.1 Released with some new features on 4th Feb 2017. <a href="#" data-href="/whats-new" data-toggle="modal" data-target="#myModal">Click here to check Whats New?</a>' ,'type' => 'success'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php endif; ?>

    <div class="login-wrap">
        <div class="box-info">
        <h2 class="text-center"><strong><?php echo e(trans('messages.user')); ?></strong> <?php echo e(trans('messages.login')); ?></h2>
            <form role="form" action="<?php echo URL::to('/login'); ?>" method="post" class="login-form" id="login-form"  data-redirect-msg="<?php echo e(trans('messages.login_redirect_message')); ?>" data-redirect-duration="10">
                <?php echo csrf_field(); ?>

                <?php if(config('config.login_type') == 'email'): ?>
                    <div class="form-group login-input">
                    <i class="fa fa-envelope overlay"></i>
                    <input type="email" class="form-control text-input" name="email" placeholder="<?php echo e(trans('messages.email')); ?>">
                    </div>
                <?php elseif(config('config.login_type') == 'username'): ?>
                    <div class="form-group login-input">
                    <i class="fa fa-user overlay"></i>
                    <input type="text" class="form-control text-input" name="username" placeholder="<?php echo e(trans('messages.username')); ?>">
                    </div>
                <?php else: ?>
                    <div class="form-group login-input">
                    <i class="fa fa-user overlay"></i>
                    <input type="text" class="form-control text-input" name="email" placeholder="<?php echo e(trans('messages.username').' '.trans('messages.or').' '.trans('messages.email')); ?>">
                    </div>
                <?php endif; ?>
                <div class="form-group login-input">
                <i class="fa fa-key overlay"></i>
                <input type="password" class="form-control text-input" name="password" placeholder="<?php echo e(trans('messages.password')); ?>">
                </div>
                <?php if(config('config.enable_remember_me')): ?>
                    <div class="checkbox">
                        <label>
                        <input type="checkbox" class="icheck" name="remember" value="1"> <?php echo e(trans('messages.remember').' '.trans('messages.me')); ?>

                        </label>
                    </div>
                <?php endif; ?>
                <?php if(config('config.enable_recaptcha') && config('config.enable_recaptcha_login')): ?>
                <div class="g-recaptcha" data-sitekey="<?php echo e(config('config.recaptcha_key')); ?>"></div>
                <br />
                <?php endif; ?>
                
                <div class="row">
                    <?php if(config('config.enable_user_registration')): ?>
                        <div class="col-sm-6">
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-unlock"></i> <?php echo e(trans('messages.login')); ?></button>
                        </div>
                        <div class="col-sm-6">
                            <a href="/register" class="btn btn-info btn-block"><i class="fa fa-user-plus"></i> <?php echo e(trans('messages.register')); ?></a>
                        </div>
                    <?php else: ?>
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success btn-block"><i class="fa fa-unlock"></i> <?php echo e(trans('messages.login')); ?></button>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
            <?php if(config('config.enable_social_login')): ?>
            <hr>
            <div class="text-center">
                <?php $__currentLoopData = config('constant.social_login_provider'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $provider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(config('config.enable_'.$provider.'_login')): ?>
                    <a class="btn btn-social btn-<?php echo e($provider.(($provider == 'google') ? '-plus' : '')); ?>" href="/auth/<?php echo e($provider); ?>" style="margin-bottom: 5px;">
                        <i class="fa fa-<?php echo e($provider); ?>"></i> <?php echo e(toWord($provider)); ?>

                    </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
            <?php if(!getMode()): ?>
            <div class="row" style="margin-bottom: 15px;">
                <h4 class="text-center">For Demo Purpose Login As</h4>
                <div class="col-md-4">
                    <a href="#" data-username="john.doe" data-email="john.doe@example.com" data-password="abcd1234" class="btn btn-block btn-primary login-as">Admin</a>
                </div>
                <div class="col-md-4">
                    <a href="#" data-username="marry.jen" data-email="marry.jen@example.com" data-password="abcd1234" class="btn btn-block btn-danger login-as">Manager</a>
                </div>
                <div class="col-md-4">
                    <a href="#" data-username="cadel.mills" data-email="cadel.mills@example.com" data-password="abcd1234" class="btn btn-block btn-success login-as">Customer</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if(config('config.enable_reset_password')): ?>
    <p class="text-center"><a href="/password/reset"><i class="fa fa-lock"></i> <?php echo e(trans('messages.forgot').' '.trans('messages.password')); ?>?</a></p>
    <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>