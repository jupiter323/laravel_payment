@extends('layouts.app')

	@section('breadcrumb')
		<ul class="breadcrumb">
		    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
		    <li class="active">{!! trans('messages.configuration') !!}</li>
		</ul>
	@stop
	
	@section('content')
           <div class="row">
			<div class="col-sm-12">
				<div class="box-info full">
				       	 <div class="tab-content col-md-12 col-xs-12" style="padding:0px 25px 10px 25px;">

						 <div class="tab-pane animated fadeInRight" id="social-login-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{{ trans('messages.social') }}</strong> {{ trans('messages.login') }}</h2>
						    	{!! Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-social-login-form','id' => 'config-social-login-form','data-no-form-clear' => 1]) !!}
                                    @include('configuration._social_login_form')
                                {!! Form::close() !!}
						    </div>
						  </div>
					    </div> 						 
                                        </div>
                                    </div> </div>

	@stop
