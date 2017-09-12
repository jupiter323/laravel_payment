

	<?php $__env->startSection('breadcrumb'); ?>
		<ul class="breadcrumb">
		    <li><a href="/home"><?php echo trans('messages.home'); ?></a></li>
		    <li><a href="/user/<?php echo e($type); ?>"><?php echo trans('messages.'.$type); ?></a></li>
		    <li class="active"><?php echo $user->full_name; ?></li>
		</ul>
	<?php $__env->stopSection(); ?>
	
	<?php $__env->startSection('content'); ?>
		<div class="row">
			<div class="col-sm-8">
				<div class="box-info full">
					<div class="tabs-left">	
						<ul class="nav nav-tabs col-md-2 tab-list" style="padding-right:0;">
						  <li><a href="#basic-tab" data-toggle="tab"> <?php echo e(trans('messages.basic')); ?> </a></li>
						  <li><a href="#avatar-tab" data-toggle="tab"> <?php echo e(trans('messages.avatar')); ?> </a></li>
						  <li><a href="#social-tab" data-toggle="tab"> <?php echo e(trans('messages.social')); ?> </a></li>
                          <?php if($user->id != Auth::user()->id && Entrust::can('reset-'.$type.'-password')): ?>
						  	<li><a href="#reset-password-tab" data-toggle="tab"> <?php echo e(trans('messages.reset').' '.trans('messages.password')); ?> </a></li>
						  <?php endif; ?>
						  <?php if(config('config.enable_email_template') && Entrust::can('email-'.$type)): ?>
						    <li><a href="#email-tab" data-toggle="tab"><?php echo e(trans('messages.email')); ?></a>
                            </li>
						  <?php endif; ?>
						</ul>
				        <div class="tab-content col-md-10 col-xs-10" style="padding:0px 25px 10px 25px;">
						  <div class="tab-pane animated fadeInRight" id="basic-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo e(trans('messages.basic')); ?> </strong></h2>
						    	<?php echo Form::model($user,['method' => 'POST','route' => ['user.profile-update',$user->id] ,'class' => 'user-profile-form','id' => 'user-profile-form','data-no-form-clear' => 1,'data-refresh' => 'load-user-detail']); ?>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <?php if(!$user->hasRole(DEFAULT_ROLE) && $type != 'customer'): ?>
                                                <div class="form-group">
                                                    <?php echo Form::label('role_id',trans('messages.role'),[]); ?>

                                                    <?php echo Form::select('role_id[]',$roles,$user->Roles->pluck('id')->all(),['class'=>'form-control show-tick']); ?>

                                                </div>
                                                <div class="form-group">
                                                    <?php echo Form::label('designation_id',trans('messages.designation'),[]); ?>

                                                    <?php echo Form::select('designation_id',$designations,isset($user->Profile->designation_id) ? $user->Profile->designation_id : '',['class'=>'form-control show-tick']); ?>

                                                </div>
                                            <?php endif; ?>
                                            <?php if($type == 'customer'): ?>
                                                <div class="form-group">
                                                    <?php echo Form::label('company_id',trans('messages.company'),[]); ?>

                                                    <?php echo Form::select('company_id', $companies,$user->Profile->company_id,['class'=>'form-control show-tick','title' => trans('messages.select_one')]); ?>

                                                </div>
                                                <div class="form-group">
                                                    <?php echo Form::label('customer_group_id',trans('messages.group'),[]); ?>

                                                    <?php echo Form::select('customer_group_id[]', $customer_groups,$user->CustomerGroup->pluck('id')->all(),['class'=>'form-control show-tick','multiple' => 'multiple','data-actions-box' => "true"]); ?>

                                                </div>
                                            <?php endif; ?>
                                          <div class="form-group">
                                            <?php echo Form::label('name',trans('messages.name'),[]); ?>

                                            <div class="row">
                                                <div class="col-md-6">
                                                <?php echo Form::input('text','first_name',$user->Profile->first_name,['class'=>'form-control','placeholder'=>trans('messages.first').' '.trans('messages.name')]); ?>

                                                </div>
                                                <div class="col-md-6">
                                                <?php echo Form::input('text','last_name',$user->Profile->last_name,['class'=>'form-control','placeholder'=>trans('messages.last').' '.trans('messages.name')]); ?>

                                                </div>
                                            </div>
                                          </div>
                                            <div class="form-group">
                                            <?php echo Form::label('phone',trans('messages.phone')); ?>

                                            <?php echo Form::input('text','phone',$user->Profile->phone,['class'=>'form-control','placeholder'=>trans('messages.phone')]); ?>

                                            <div class="help-block">This will be used to send two factor auth code.</div>
                                            <div class="row">
                                                <div class="col-xs-8">
                                                <?php echo Form::input('text','work_phone',$user->Profile->work_phone,['class'=>'form-control','placeholder'=>trans('messages.work')]); ?>

                                                </div>
                                                <div class="col-xs-4">
                                                <?php echo Form::input('text','work_phone_extension',$user->Profile->work_phone_extension,['class'=>'form-control','placeholder'=>trans('messages.ext')]); ?>

                                                </div>
                                            </div>
                                            <br />
                                            <?php echo Form::input('text','home_phone',$user->Profile->home_phone,['class'=>'form-control','placeholder'=>trans('messages.home').' '.trans('messages.phone')]); ?>

                                            </div>
                                            <div class="form-group">
                                                <?php echo Form::label('work_email',trans('messages.work').' '.trans('messages.email')); ?>

                                                <?php echo Form::input('email','work_email',$user->Profile->work_email,['class'=>'form-control','placeholder'=>trans('messages.work').' '.trans('messages.email')]); ?>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            <?php echo Form::label('date_of_birth',trans('messages.date_of_birth'),[]); ?>

                                            <?php echo Form::input('text','date_of_birth',$user->Profile->date_of_birth,['class'=>'form-control datepicker','placeholder'=>trans('messages.date_of_birth')]); ?>

                                          </div>
                                          <div class="form-group">
                                            <?php echo Form::label('date_of_anniversary',trans('messages.date_of_anniversary'),[]); ?>

                                            <?php echo Form::input('text','date_of_anniversary',$user->Profile->date_of_anniversary,['class'=>'form-control datepicker','placeholder'=>trans('messages.date_of_anniversary')]); ?>

                                          </div>
                                            <div class="form-group">
                                                <?php echo Form::label('address',trans('messages.address'),[]); ?>

                                                <?php echo Form::input('text','address_line_1',$user->Profile->address_line_1,['class'=>'form-control','placeholder'=>trans('messages.address_line_1')]); ?>

                                                <br />
                                                <?php echo Form::input('text','address_line_2',$user->Profile->address_line_2,['class'=>'form-control','placeholder'=>trans('messages.address_line_2')]); ?>

                                                <br />
                                                <div class="row">
                                                    <div class="col-xs-5">
                                                    <?php echo Form::input('text','city',$user->Profile->city,['class'=>'form-control','placeholder'=>trans('messages.city')]); ?>

                                                    </div>
                                                    <div class="col-xs-4">
                                                    <?php echo Form::input('text','state',$user->Profile->state,['class'=>'form-control','placeholder'=>trans('messages.state')]); ?>

                                                    </div>
                                                    <div class="col-xs-3">
                                                    <?php echo Form::input('text','zipcode',$user->Profile->zipcode,['class'=>'form-control','placeholder'=>trans('messages.zipcode')]); ?>

                                                    </div>
                                                </div>
                                                <br />
                                                <?php echo Form::select('country_id', [null => trans('messages.select_one')] + config('country'),$user->Profile->country_id,['class'=>'form-control show-tick','title'=>trans('messages.country')]); ?>

                                            </div>
                                        </div>
                                    </div>            
                                    <?php echo e(getCustomFields('user-registration-form',$custom_register_field_values)); ?>

                                    <?php echo Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>                            
                                <?php echo Form::close(); ?>

						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="avatar-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo e(trans('messages.avatar')); ?> </strong></h2>
						    	<?php echo Form::model($user,['files' => true, 'method' => 'POST','route' => ['user.avatar',$user->id] ,'class' => 'user-avatar-form','id' => 'user-avatar-form']); ?>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="file" name="avatar" id="avatar" title="<?php echo trans('messages.select').' '.trans('messages.avatar'); ?>" class="btn btn-default file-input" data-buttonText="<?php echo trans('messages.select').' '.trans('messages.avatar'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <?php if($user->Profile->avatar && File::exists(config('constant.upload_path.avatar').$user->Profile->avatar)): ?>
                                    <div class="form-group">
                                        <img src="<?php echo URL::to(config('constant.upload_path.avatar').$user->Profile->avatar); ?>" width="150px" style="margin-left:20px;">
                                        <div class="checkbox">
                                            <label>
                                              <input name="remove_avatar" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" data-off-value="0"> <?php echo trans('messages.remove').' '.trans('messages.avatar'); ?>

                                            </label>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <input type="hidden" name="redirect_url" value="/user/$type/<?php echo e($user->id); ?>" readonly>
                                    <?php echo Form::submit(trans('messages.save'),['class' => 'btn btn-primary']); ?>

                                <?php echo Form::close(); ?>

						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="social-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo e(trans('messages.social')); ?> </strong></h2>
						    	<?php echo Form::model($user,['method' => 'POST','route' => ['user.social-update',$user->id] ,'class' => 'user-social-form','id' => 'user-social-form','data-no-form-clear' => 1]); ?>

                                  <div class="form-group">
                                    <?php echo Form::label('facebook','Facebook',[]); ?>

                                    <?php echo Form::input('text','facebook',$user->Profile->facebook,['class'=>'form-control','placeholder'=>'Facebook']); ?>

                                  </div>
                                  <div class="form-group">
                                    <?php echo Form::label('twitter','Twitter',[]); ?>

                                    <?php echo Form::input('text','twitter',$user->Profile->twitter,['class'=>'form-control','placeholder'=>'Twitter']); ?>

                                  </div>
                                  <div class="form-group">
                                    <?php echo Form::label('google_plus','Google Plus',[]); ?>

                                    <?php echo Form::input('text','google_plus',$user->Profile->google_plus,['class'=>'form-control','placeholder'=>'Google Plus']); ?>

                                  </div>
                                <?php echo e(getCustomFields('user-social-form',$custom_social_field_values)); ?>

                                <?php echo Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']); ?>

                                <?php echo Form::close(); ?>

						    </div>
						  </div>
						  <?php if($user->id != Auth::user()->id && Entrust::can('reset-'.$type.'-password')): ?>
						  <div class="tab-pane animated fadeInRight" id="reset-password-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong><?php echo e(trans('messages.reset').' '.trans('messages.password')); ?> </strong></h2>
						    	<?php echo Form::model($user,['method' => 'POST','route' => ['user.force-change-password',$user->id] ,'class' => 'user-force-change-password-form','id' => 'user-force-change-password-form']); ?>

									<div class="form-group">
									    <?php echo Form::label('new_password',trans('messages.new').' '.trans('messages.password'),[]); ?>

										<?php echo Form::input('password','new_password','',['class'=>'form-control '.(config('config.enable_password_strength_meter') ? 'password-strength' : ''),'placeholder'=>trans('messages.new').' '.trans('messages.password')]); ?>

									</div>
									<div class="form-group">
									    <?php echo Form::label('new_password_confirmation',trans('messages.confirm').' '.trans('messages.password'),[]); ?>

										<?php echo Form::input('password','new_password_confirmation','',['class'=>'form-control','placeholder'=>trans('messages.confirm').' '.trans('messages.password')]); ?>

									</div>
									<div class="form-group">
										<?php echo Form::submit(isset($buttonText) ? $buttonText : trans('messages.update'),['class' => 'btn btn-primary pull-right']); ?>

									</div>
								<?php echo Form::close(); ?>

						    </div>
						  </div>
						  <?php endif; ?>
						  <?php if(config('config.enable_email_template') && Entrust::can('email-'.$type)): ?>
						  	<div class="tab-pane animated fadeInRight" id="email-tab">
							    <div class="user-profile-content-wm">
							    	<h2><strong><?php echo e(trans('messages.email').' '.trans('messages.'.$type)); ?> </strong></h2>
							    	<?php echo Form::model($user,['method' => 'POST','route' => ['user.email',$user->id] ,'class' => $type.'-email-form','id' => $type.'-email-form','data-user-id' => $user->id,'data-url' => '/template/content']); ?>

                                    <div class="form-group">
                                        <?php echo Form::select('template_id', $templates,'',['class'=>'form-control show-tick','id'=>'template_id','title' => trans('messages.select_one')]); ?>

                                    </div>
                                    <div class="form-group">
                                        <?php echo Form::input('text','subject','',['class'=>'form-control','placeholder'=>trans('messages.subject'),'id' => 'mail_subject']); ?>

                                    </div>
                                    <div class="form-group">
                                        <?php echo Form::textarea('body','',['size' => '30x3', 'class' => 'form-control summernote', 'id' => 'mail_body', 'placeholder' => trans('messages.body')]); ?>

                                    </div>
                                    <?php echo Form::submit(trans('messages.send'),['class' => 'btn btn-primary pull-right']); ?>

                                    <?php echo Form::close(); ?>

							    </div>
						   	</div>
						  <?php endif; ?>
						</div>
					</div>
				</div>
			</div>
            <div class="col-sm-4">
                <div class="box-info full">
                    <h2>
                        <strong><?php echo trans('messages.'.$type).'</strong> '.trans('messages.profile'); ?>

                    </h2>
                    <div id="load-user-detail" data-extra="&user_id=<?php echo e($user->id); ?>" data-source="/user-detail"></div>
                </div>
            </div>
		</div>
	<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>