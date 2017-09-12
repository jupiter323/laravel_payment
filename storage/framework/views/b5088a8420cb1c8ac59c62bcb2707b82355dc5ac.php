                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo Form::label('email',trans('messages.email'),[]); ?>

                                    <input type="email" class="form-control text-input" name="email" placeholder="<?php echo e(trans('messages.email')); ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo Form::label('username',trans('messages.username'),[]); ?>

                                    <input type="text" class="form-control text-input" name="username" placeholder="<?php echo e(trans('messages.username')); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo Form::label('first_name',trans('messages.first').' '.trans('messages.name'),[]); ?>

                                    <input type="text" class="form-control text-input" name="first_name" placeholder="<?php echo e(trans('messages.first').' '.trans('messages.name')); ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo Form::label('last_name',trans('messages.last').' '.trans('messages.name'),[]); ?>

                                    <input type="text" class="form-control text-input" name="last_name" placeholder="<?php echo e(trans('messages.last').' '.trans('messages.name')); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo Form::label('password',trans('messages.password'),[]); ?>

                                    <input type="password" class="form-control text-input <?php if(config('config.enable_password_strength_meter')): ?> password-strength <?php endif; ?>" name="password" placeholder="<?php echo e(trans('messages.password')); ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo Form::label('password_confirmation',trans('messages.confirm').' '.trans('messages.password'),[]); ?>

                                    <input type="password" class="form-control text-input" name="password_confirmation" placeholder="<?php echo e(trans('messages.confirm').' '.trans('messages.password')); ?>">
                                </div>
                            </div>
                        </div>
                        <?php if($type == 'staff'): ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo Form::label('role_id',trans('messages.role'),[]); ?>

                                    <?php echo Form::select('role_id', $roles,'',['class'=>'form-control show-tick']); ?>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo Form::label('designation_id',trans('messages.designation'),[]); ?>

                                    <?php echo Form::select('designation_id', $designations,'',['class'=>'form-control show-tick','title' => trans('messages.select_one')]); ?>

                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                            <div class="form-group">
                                <?php echo Form::label('company_id',trans('messages.company'),[]); ?>

                                <?php echo Form::select('company_id', $companies,'',['class'=>'form-control show-tick','title' => trans('messages.select_one')]); ?>

                            </div>
                            <div class="form-group">
                                <?php echo Form::label('customer_group_id',trans('messages.group'),[]); ?>

                                <?php echo Form::select('customer_group_id[]', $customer_groups,'',['class'=>'form-control show-tick','multiple' => 'multiple','data-actions-box' => "true"]); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <?php echo Form::label('address',trans('messages.address'),[]); ?>

                            <?php echo Form::input('text','address_line_1',(isset($company) ? $company->address_line_1 : ''),['class'=>'form-control','placeholder'=>trans('messages.address_line_1')]); ?>

                            <br />
                            <?php echo Form::input('text','address_line_2',(isset($company) ? $company->address_line_2 : ''),['class'=>'form-control','placeholder'=>trans('messages.address_line_2')]); ?>

                            <br />
                            <div class="row">
                                <div class="col-xs-5">
                                <?php echo Form::input('text','city',(isset($company) ? $company->city : ''),['class'=>'form-control','placeholder'=>trans('messages.city')]); ?>

                                </div>
                                <div class="col-xs-4">
                                <?php echo Form::input('text','state',(isset($company) ? $company->state : ''),['class'=>'form-control','placeholder'=>trans('messages.state')]); ?>

                                </div>
                                <div class="col-xs-3">
                                <?php echo Form::input('text','zipcode',(isset($company) ? $company->zipcode : ''),['class'=>'form-control','placeholder'=>trans('messages.zipcode')]); ?>

                                </div>
                            </div>
                            <br />
                            <?php echo Form::select('country_id', config('country'),(isset($company) ? $company->country_id : ''),['class'=>'form-control show-tick','title'=>trans('messages.country')]); ?>

                        </div>
                        <?php echo e(getCustomFields('user-registration-form')); ?>

                        <?php if(Auth::check()): ?>
                        <div class="form-group">
                            <input name="send_welcome_email" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1"> <?php echo e(trans('messages.send')); ?> welcome email
                        </div>
                        <?php endif; ?>
                        <?php if(config('config.enable_tnc') && !Auth::check()): ?>
                        <div class="form-group">
                            <input name="tnc" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1"> I accept <a href="#" data-href="/terms-and-conditions" data-toggle="modal" data-target="#myModal">Terms & Conditions</a>.
                        </div>
                        <?php endif; ?>
                        <?php if(config('config.enable_recaptcha') && !Auth::check()): ?>
                        <div class="g-recaptcha" data-sitekey="<?php echo e(config('config.recaptcha_key')); ?>"></div>
                        <br />
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-lock"></i> <?php echo e(trans('messages.create').' '.trans('messages.account')); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                
                