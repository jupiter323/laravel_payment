
            <div class="header content rows-content-header">
            
                <button class="button-menu-mobile show-sidebar">
                    <i class="fa fa-bars"></i>
                </button>
                
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <i class="fa fa-angle-double-down"></i>
                            </button>
                        </div>
                        
                        <?php if($right_sidebar): ?>
                            <a href="#" class="navbar-toggle toggle-right btn btn-sm" data-toggle="sidebar" data-target=".sidebar-right" style="margin-left:10px;">
                              <i class="fa fa-question-circle icon" data-toggle="tooltip" data-title="Help" data-placement="bottom" style="color:#000000;"></i>
                            </a>
                        <?php endif; ?>

                        <div class="navbar-collapse collapse">
                        
                            <ul class="nav navbar-nav">
                                <li>
                                    <?php if(session('parent_login')): ?>
                                        <a href="#" data-ajax="1" data-source="/login-return"><span class="label label-danger"><?php echo e(trans('messages.login_back_as',['attribute' => \App\User::whereId(session('parent_login'))->first()->full_name])); ?></span> </a>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        
                            <ul class="nav navbar-nav navbar-right top-navbar">
                                
                                <?php if(Entrust::can('manage-todo') && config('config.enable_to_do')): ?>
                                <li><a href="#" data-href="/todo" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-list-ul fa-lg icon" data-toggle="tooltip" title="<?php echo trans('messages.to_do'); ?>" data-placement="bottom"></i></a></li>
                                <?php endif; ?>
                                <?php if(config('config.multilingual') && Entrust::can('change-localization')): ?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-language fa-lg icon" data-toggle="tooltip" title="<?php echo trans('messages.localization'); ?>" data-placement="bottom"></i> </a>
                                    <ul class="dropdown-menu animated half flipInX">
                                        <li class="active"><a href="#" style="color:white;cursor:default;"><?php echo config('localization.'.session('localization').'.localization').' ('.session('localization').')'; ?></a></li>
                                        <?php $__currentLoopData = config('localization'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $localization): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(session('localization') != $key): ?>
                                            <li><a href="/change-localization/<?php echo e($key); ?>"><?php echo $localization['localization']." (".$key.")"; ?></a></li>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li>
                                <?php endif; ?>

                                <?php if(!Entrust::hasRole(config('constant.default_customer_role'))): ?>
                                    <li class="dropdown configuration-list-container">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-cog" data-toggle="tooltip" title="<?php echo e(trans('messages.configuration')); ?>" data-placement="bottom"></i>
                                        </a>
                                        <ul class="dropdown-menu animated half flipInX configuration-list">
                                        <?php if(Entrust::can('manage-configuration')): ?>
                                            <li><a href="/configuration"><?php echo e(trans('messages.configuration')); ?></a></li>
                                        <?php endif; ?>
                                        <?php if(Entrust::can('manage-role')): ?>
                                            <li><a href="/role"><?php echo e(trans('messages.role').' '.trans('messages.configuration')); ?></a></li>
                                        <?php endif; ?>
                                        <?php if(Entrust::can('manage-permission')): ?>
                                            <li><a href="/permission"><?php echo e(trans('messages.permission')); ?></a></li>
                                        <?php endif; ?>
                                        <?php if(Entrust::can('list-department')): ?>
                                            <li><a href="/department"><?php echo e(trans('messages.department')); ?></a></li>
                                        <?php endif; ?>
                                        <?php if(Entrust::can('list-designation')): ?>
                                            <li><a href="/designation"><?php echo e(trans('messages.designation')); ?></a></li>
                                        <?php endif; ?>
                                        <?php if(Entrust::can('manage-configuration')): ?>
                                            <li><a href="/currency-conversion"><?php echo e(trans('messages.currency').' '.trans('messages.conversion')); ?></a></li>
                                        <?php endif; ?>
                                        <?php if(config('config.multilingual') && Entrust::can('manage-localization')): ?>
                                            <li><a href="/localization"><?php echo e(trans('messages.localization')); ?></a></li>
                                        <?php endif; ?>
                                        <?php if(config('config.enable_custom_field') && Entrust::can('manage-custom-field')): ?>
                                            <li><a href="/custom-field"><?php echo e(trans('messages.custom').' '.trans('messages.field')); ?></a></li>
                                        <?php endif; ?>
                                        <?php if(config('config.enable_ip_filter') && Entrust::can('manage-ip-filter')): ?>
                                            <li><a href="/ip-filter">Ip <?php echo e(trans('messages.filter')); ?></a></li>
                                        <?php endif; ?>
                                        <?php if(Entrust::can('manage-template')): ?>
                                            <li><a href="/template"><?php echo e(trans('messages.email').' '.trans('messages.template')); ?></a></li>
                                        <?php endif; ?>
                                        <?php if(Entrust::can('manage-campaign')): ?>
                                            <li><a href="/campaign"><?php echo e(trans('messages.email').' '.trans('messages.campaign')); ?></a></li>
                                        <?php endif; ?>
                                        <?php if(!Entrust::hasRole(config('constant.default_customer_role'))): ?>
                                            <li><a href="/activity-log"><?php echo e(trans('messages.activity').' '.trans('messages.log')); ?></a></li>
                                        <?php endif; ?>
                                        <?php if(Entrust::can('manage-email-log')): ?>
                                            <li><a href="/email"><?php echo e(trans('messages.email').' '.trans('messages.log')); ?></a></li>
                                        <?php endif; ?>
                                        <?php if(Entrust::can('manage-backup')): ?>
                                            <li><a href="/backup"><?php echo e(trans('messages.database').' '.trans('messages.backup')); ?></a></li>
                                        <?php endif; ?>
                                        </ul>
                                    </li>
                                <?php endif; ?>
                                
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo e(trans('messages.greeting')); ?>, <strong><?php echo e(Auth::user()->full_name); ?></strong> <i class="fa fa-chevron-down i-xs"></i></a>
                                    <ul class="dropdown-menu animated half flipInX">
                                        <?php if(getMode() && defaultRole()): ?>
                                        <li><a href="#" data-href="/check-update" data-toggle='modal' data-target='#myModal'><?php echo trans('messages.check').' '.trans('messages.update'); ?></a></li>
                                        <li><a href="/release-license"><?php echo trans('messages.release_license'); ?></a></li>
                                        <?php endif; ?>
                                        <li class="divider"></li>
                                        <li><a href="/profile"><i class="fa fa-user fa-fw"></i> <?php echo e(trans('messages.profile')); ?></a></li>
                                        <li><a href="#" data-href="/change-password" data-toggle="modal" data-target="#myModal"><i class="fa fa-key fa-fw"></i> <?php echo trans('messages.change').' '.trans('messages.password'); ?></a></li>
                                        <li><a href="#" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-fw"></i> <?php echo e(trans('messages.logout')); ?></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <form id="logout-form" action="/logout" method="POST" style="display: none;">
                <?php echo e(csrf_field()); ?>

            </form>