                    <div class="row">
                        <div class="col-md-4  col-md-offset-3" style="margin-top:20px;margin-bottom:20px;"><?php echo getAvatar($user->id,150); ?></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-stripped table-hover show-table">
                            <tbody>
                                <tr>
                                    <th><?php echo e(trans('messages.name')); ?></th>
                                    <td><?php echo e($user->full_name); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(trans('messages.status')); ?></th>
                                    <td><?php echo e(toWord($user->status)); ?></td>
                                </tr>
                                <?php if($type == 'staff'): ?>
                                <tr>
                                    <th><?php echo e(trans('messages.role')); ?></th>
                                    <td>
                                        <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo e(ucfirst($role->name)); ?><br />
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo e(trans('messages.designation')); ?></th>
                                    <td><?php echo e($user->designation_with_department); ?></td>
                                </tr>
                                <?php else: ?>
                                <tr>
                                    <th><?php echo e(trans('messages.company')); ?></th>
                                    <td><?php echo e(($user->Profile->Company) ? $user->Profile->Company->name : ''); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(trans('messages.group')); ?></th>
                                    <td>
                                        <ol>
                                        <?php $__currentLoopData = $user->CustomerGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($group->name); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ol>
                                    </td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <th><?php echo e(trans('messages.email')); ?></th>
                                    <td><?php echo e($user->email); ?></td>
                                </tr>
                                <?php if(!config('config.login')): ?>
                                <tr>
                                    <th><?php echo e(trans('messages.username')); ?></th>
                                    <td><?php echo e($user->username); ?></td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <th><?php echo e(trans('messages.signup').' '.trans('messages.date')); ?></th>
                                    <td><?php echo e(showDate($user->created_at)); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo e(trans('messages.last').' '.trans('messages.login')); ?></th>
                                    <td><?php echo e(showDateTime($user->last_login)); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php if(Auth::user()->id == $user->id): ?>
                        <div class="row" style="padding:10px;">
                            <div class="col-md-6">
                                <a href="#" data-href="/change-password" data-toggle="modal" data-target="#myModal" class="btn btn-block btn-primary"><?php echo e(trans('messages.change').' '.trans('messages.password')); ?></a>
                            </div>
                            <div class="col-md-6">
                                <a href="#" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();" class="btn btn-block btn-danger"><?php echo e(trans('messages.logout')); ?></a>
                            </div>
                        </div>
                    <?php endif; ?>