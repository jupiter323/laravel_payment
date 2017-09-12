@extends('layouts.app')

	@section('breadcrumb')
		<ul class="breadcrumb">
		    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
		    <li><a href="/user/{{$type}}">{!! trans('messages.'.$type) !!}</a></li>
		    <li class="active">{!! $user->full_name !!}</li>
		</ul>
	@stop
	
	@section('content')
		<div class="row">
			<div class="col-sm-8">
				<div class="box-info full">
					<div class="tabs-left">	
						<ul class="nav nav-tabs col-md-2 tab-list" style="padding-right:0;">
						  <li><a href="#basic-tab" data-toggle="tab"> {{ trans('messages.basic') }} </a></li>
						  <li><a href="#avatar-tab" data-toggle="tab"> {{ trans('messages.avatar') }} </a></li>
						  <li><a href="#social-tab" data-toggle="tab"> {{ trans('messages.social') }} </a></li>
                          @if($user->id != Auth::user()->id && Entrust::can('reset-'.$type.'-password'))
						  	<li><a href="#reset-password-tab" data-toggle="tab"> {{ trans('messages.reset').' '.trans('messages.password') }} </a></li>
						  @endif
						  @if(config('config.enable_email_template') && Entrust::can('email-'.$type))
						    <li><a href="#email-tab" data-toggle="tab">{{trans('messages.email')}}</a>
                            </li>
						  @endif
						</ul>
				        <div class="tab-content col-md-10 col-xs-10" style="padding:0px 25px 10px 25px;">
						  <div class="tab-pane animated fadeInRight" id="basic-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{{ trans('messages.basic') }} </strong></h2>
						    	{!! Form::model($user,['method' => 'POST','route' => ['user.profile-update',$user->id] ,'class' => 'user-profile-form','id' => 'user-profile-form','data-no-form-clear' => 1,'data-refresh' => 'load-user-detail']) !!}
                                    <div class="row">
                                        <div class="col-md-6">
                                            @if(!$user->hasRole(DEFAULT_ROLE) && $type != 'customer')
                                                <div class="form-group">
                                                    {!! Form::label('role_id',trans('messages.role'),[])!!}
                                                    {!! Form::select('role_id[]',$roles,$user->Roles->pluck('id')->all(),['class'=>'form-control show-tick'])!!}
                                                </div>
                                                <div class="form-group">
                                                    {!! Form::label('designation_id',trans('messages.designation'),[])!!}
                                                    {!! Form::select('designation_id',$designations,isset($user->Profile->designation_id) ? $user->Profile->designation_id : '',['class'=>'form-control show-tick'])!!}
                                                </div>
                                            @endif
                                            @if($type == 'customer')
                                                <div class="form-group">
                                                    {!! Form::label('company_id',trans('messages.company'),[])!!}
                                                    {!! Form::select('company_id', $companies,$user->Profile->company_id,['class'=>'form-control show-tick','title' => trans('messages.select_one')])!!}
                                                </div>
                                                <div class="form-group">
                                                    {!! Form::label('customer_group_id',trans('messages.group'),[])!!}
                                                    {!! Form::select('customer_group_id[]', $customer_groups,$user->CustomerGroup->pluck('id')->all(),['class'=>'form-control show-tick','multiple' => 'multiple','data-actions-box' => "true"])!!}
                                                </div>
                                            @endif
                                          <div class="form-group">
                                            {!! Form::label('name',trans('messages.name'),[])!!}
                                            <div class="row">
                                                <div class="col-md-6">
                                                {!! Form::input('text','first_name',$user->Profile->first_name,['class'=>'form-control','placeholder'=>trans('messages.first').' '.trans('messages.name')])!!}
                                                </div>
                                                <div class="col-md-6">
                                                {!! Form::input('text','last_name',$user->Profile->last_name,['class'=>'form-control','placeholder'=>trans('messages.last').' '.trans('messages.name')])!!}
                                                </div>
                                            </div>
                                          </div>
                                            <div class="form-group">
                                            {!! Form::label('phone',trans('messages.phone'))!!}
                                            {!! Form::input('text','phone',$user->Profile->phone,['class'=>'form-control','placeholder'=>trans('messages.phone')])!!}
                                            <div class="help-block">This will be used to send two factor auth code.</div>
                                            <div class="row">
                                                <div class="col-xs-8">
                                                {!! Form::input('text','work_phone',$user->Profile->work_phone,['class'=>'form-control','placeholder'=>trans('messages.work')])!!}
                                                </div>
                                                <div class="col-xs-4">
                                                {!! Form::input('text','work_phone_extension',$user->Profile->work_phone_extension,['class'=>'form-control','placeholder'=>trans('messages.ext')])!!}
                                                </div>
                                            </div>
                                            <br />
                                            {!! Form::input('text','home_phone',$user->Profile->home_phone,['class'=>'form-control','placeholder'=>trans('messages.home').' '.trans('messages.phone')])!!}
                                            </div>
                                            <div class="form-group">
                                                {!! Form::label('work_email',trans('messages.work').' '.trans('messages.email'))!!}
                                                {!! Form::input('email','work_email',$user->Profile->work_email,['class'=>'form-control','placeholder'=>trans('messages.work').' '.trans('messages.email')])!!}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                          <div class="form-group">
                                            {!! Form::label('date_of_birth',trans('messages.date_of_birth'),[])!!}
                                            {!! Form::input('text','date_of_birth',$user->Profile->date_of_birth,['class'=>'form-control datepicker','placeholder'=>trans('messages.date_of_birth')])!!}
                                          </div>
                                          <div class="form-group">
                                            {!! Form::label('date_of_anniversary',trans('messages.date_of_anniversary'),[])!!}
                                            {!! Form::input('text','date_of_anniversary',$user->Profile->date_of_anniversary,['class'=>'form-control datepicker','placeholder'=>trans('messages.date_of_anniversary')])!!}
                                          </div>
                                            <div class="form-group">
                                                {!! Form::label('address',trans('messages.address'),[])!!}
                                                {!! Form::input('text','address_line_1',$user->Profile->address_line_1,['class'=>'form-control','placeholder'=>trans('messages.address_line_1')])!!}
                                                <br />
                                                {!! Form::input('text','address_line_2',$user->Profile->address_line_2,['class'=>'form-control','placeholder'=>trans('messages.address_line_2')])!!}
                                                <br />
                                                <div class="row">
                                                    <div class="col-xs-5">
                                                    {!! Form::input('text','city',$user->Profile->city,['class'=>'form-control','placeholder'=>trans('messages.city')])!!}
                                                    </div>
                                                    <div class="col-xs-4">
                                                    {!! Form::input('text','state',$user->Profile->state,['class'=>'form-control','placeholder'=>trans('messages.state')])!!}
                                                    </div>
                                                    <div class="col-xs-3">
                                                    {!! Form::input('text','zipcode',$user->Profile->zipcode,['class'=>'form-control','placeholder'=>trans('messages.zipcode')])!!}
                                                    </div>
                                                </div>
                                                <br />
                                                {!! Form::select('country_id', [null => trans('messages.select_one')] + config('country'),$user->Profile->country_id,['class'=>'form-control show-tick','title'=>trans('messages.country')])!!}
                                            </div>
                                        </div>
                                    </div>            
                                    {{ getCustomFields('user-registration-form',$custom_register_field_values) }}
                                    {!! Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}                            
                                {!! Form::close() !!}
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="avatar-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{{ trans('messages.avatar') }} </strong></h2>
						    	{!! Form::model($user,['files' => true, 'method' => 'POST','route' => ['user.avatar',$user->id] ,'class' => 'user-avatar-form','id' => 'user-avatar-form']) !!}
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="file" name="avatar" id="avatar" title="{!! trans('messages.select').' '.trans('messages.avatar') !!}" class="btn btn-default file-input" data-buttonText="{!! trans('messages.select').' '.trans('messages.avatar') !!}">
                                            </div>
                                        </div>
                                    </div>
                                    @if($user->Profile->avatar && File::exists(config('constant.upload_path.avatar').$user->Profile->avatar))
                                    <div class="form-group">
                                        <img src="{!! URL::to(config('constant.upload_path.avatar').$user->Profile->avatar) !!}" width="150px" style="margin-left:20px;">
                                        <div class="checkbox">
                                            <label>
                                              <input name="remove_avatar" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" data-off-value="0"> {!! trans('messages.remove').' '.trans('messages.avatar') !!}
                                            </label>
                                        </div>
                                    </div>
                                    @endif
                                    <input type="hidden" name="redirect_url" value="/user/$type/{{$user->id}}" readonly>
                                    {!! Form::submit(trans('messages.save'),['class' => 'btn btn-primary']) !!}
                                {!! Form::close() !!}
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="social-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{{ trans('messages.social') }} </strong></h2>
						    	{!! Form::model($user,['method' => 'POST','route' => ['user.social-update',$user->id] ,'class' => 'user-social-form','id' => 'user-social-form','data-no-form-clear' => 1]) !!}
                                  <div class="form-group">
                                    {!! Form::label('facebook','Facebook',[])!!}
                                    {!! Form::input('text','facebook',$user->Profile->facebook,['class'=>'form-control','placeholder'=>'Facebook'])!!}
                                  </div>
                                  <div class="form-group">
                                    {!! Form::label('twitter','Twitter',[])!!}
                                    {!! Form::input('text','twitter',$user->Profile->twitter,['class'=>'form-control','placeholder'=>'Twitter'])!!}
                                  </div>
                                  <div class="form-group">
                                    {!! Form::label('google_plus','Google Plus',[])!!}
                                    {!! Form::input('text','google_plus',$user->Profile->google_plus,['class'=>'form-control','placeholder'=>'Google Plus'])!!}
                                  </div>
                                {{ getCustomFields('user-social-form',$custom_social_field_values) }}
                                {!! Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
                                {!! Form::close() !!}
						    </div>
						  </div>
						  @if($user->id != Auth::user()->id && Entrust::can('reset-'.$type.'-password'))
						  <div class="tab-pane animated fadeInRight" id="reset-password-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{{ trans('messages.reset').' '.trans('messages.password') }} </strong></h2>
						    	{!! Form::model($user,['method' => 'POST','route' => ['user.force-change-password',$user->id] ,'class' => 'user-force-change-password-form','id' => 'user-force-change-password-form']) !!}
									<div class="form-group">
									    {!! Form::label('new_password',trans('messages.new').' '.trans('messages.password'),[])!!}
										{!! Form::input('password','new_password','',['class'=>'form-control '.(config('config.enable_password_strength_meter') ? 'password-strength' : ''),'placeholder'=>trans('messages.new').' '.trans('messages.password')])!!}
									</div>
									<div class="form-group">
									    {!! Form::label('new_password_confirmation',trans('messages.confirm').' '.trans('messages.password'),[])!!}
										{!! Form::input('password','new_password_confirmation','',['class'=>'form-control','placeholder'=>trans('messages.confirm').' '.trans('messages.password')])!!}
									</div>
									<div class="form-group">
										{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.update'),['class' => 'btn btn-primary pull-right']) !!}
									</div>
								{!! Form::close() !!}
						    </div>
						  </div>
						  @endif
						  @if(config('config.enable_email_template') && Entrust::can('email-'.$type))
						  	<div class="tab-pane animated fadeInRight" id="email-tab">
							    <div class="user-profile-content-wm">
							    	<h2><strong>{{ trans('messages.email').' '.trans('messages.'.$type) }} </strong></h2>
							    	{!! Form::model($user,['method' => 'POST','route' => ['user.email',$user->id] ,'class' => $type.'-email-form','id' => $type.'-email-form','data-user-id' => $user->id,'data-url' => '/template/content']) !!}
                                    <div class="form-group">
                                        {!! Form::select('template_id', $templates,'',['class'=>'form-control show-tick','id'=>'template_id','title' => trans('messages.select_one')])!!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::input('text','subject','',['class'=>'form-control','placeholder'=>trans('messages.subject'),'id' => 'mail_subject']) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::textarea('body','',['size' => '30x3', 'class' => 'form-control summernote', 'id' => 'mail_body', 'placeholder' => trans('messages.body')])!!}
                                    </div>
                                    {!! Form::submit(trans('messages.send'),['class' => 'btn btn-primary pull-right']) !!}
                                    {!! Form::close() !!}
							    </div>
						   	</div>
						  @endif
						</div>
					</div>
				</div>
			</div>
            <div class="col-sm-4">
                <div class="box-info full">
                    <h2>
                        <strong>{!!trans('messages.'.$type).'</strong> '.trans('messages.profile')!!}
                    </h2>
                    <div id="load-user-detail" data-extra="&user_id={{$user->id}}" data-source="/user-detail"></div>
                </div>
            </div>
		</div>
	@stop