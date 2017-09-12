
        <div class="left side-menu">
            <div class="body rows scroll-y">
                <div class="sidebar-inner slimscroller">
                    <div class="media">
                        <a class="pull-left" href="#">
                            <?php echo getAvatar(Auth::user()->id,60); ?>

                        </a>
                        <div class="media-body">
                            <?php echo e(trans('messages.welcome')); ?>,
                            <h4 class="media-heading"><strong><?php echo e(Auth::user()->full_name); ?></strong></h4>
                            <small><?php echo e(trans('messages.last_login').' '.Auth::user()->last_login); ?>

                            <?php if(Auth::user()->last_login_ip): ?>
                            | <?php echo e(trans('messages.from').' '.Auth::user()->last_login_ip); ?>

                            <?php endif; ?>
                            </small>
                        </div>
                    </div>
                    <div id="sidebar-menu">
                        <ul id="sidebar-menu-list">
                        </ul>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>