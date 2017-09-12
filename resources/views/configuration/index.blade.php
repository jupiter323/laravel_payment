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
					<div class="tabs-left">	
					<!--	<ul class="nav nav-tabs col-md-2 tab-list" style="padding-right:0;">
		                    <li><a href="#general-tab" data-toggle="tab">{{trans('messages.general')}}</a>
		                    </li>
		                    <li><a href="#logo-tab" data-toggle="tab">{{trans('messages.logo')}}</a>
		                    </li>
		                    <li><a href="#theme-tab" data-toggle="tab">{{trans('messages.theme')}}</a>
		                    </li>
		                    <li><a href="#system-tab" data-toggle="tab">{{trans('messages.system')}}</a>
		                    </li>
		                    <li><a href="#mail-tab" data-toggle="tab">{{trans('messages.mail')}}</a>
		                    </li>
		                    <li><a href="#sms-tab" data-toggle="tab">SMS</a>
		                    </li>
		                    <li><a href="#auth-tab" data-toggle="tab">{{trans('messages.authentication')}}</a>
		                    </li>
		                    <li><a href="#social-login-tab" data-toggle="tab">{{trans('messages.social').' '.trans('messages.login')}}</a>
		                    </li>
		                    <li><a href="#menu-tab" data-toggle="tab">{{trans('messages.menu')}}</a>
		                    </li>
		                    <li><a href="#payment-gateway-tab" data-toggle="tab">{{trans('messages.payment').' '.trans('messages.gateway')}}</a>
		                    </li>
		                    <li><a href="#currency-tab" data-toggle="tab">{{trans('messages.currency')}}</a>
		                    </li>
		                    <li><a href="#taxation-tab" data-toggle="tab">{{trans('messages.taxation')}}</a>
		                    </li>
		                    <li><a href="#customer-tab" data-toggle="tab">{{trans('messages.customer')}}</a>
		                    </li>
		                    <li><a href="#expense-tab" data-toggle="tab">{{trans('messages.expense')}}</a>
		                    </li>
		                    <li><a href="#income-tab" data-toggle="tab">{{trans('messages.income')}}</a>
		                    </li>
		                    <li><a href="#item-tab" data-toggle="tab">{{trans('messages.item')}}</a>
		                    </li>
		                    <li><a href="#invoice-tab" data-toggle="tab">{{trans('messages.invoice')}}</a>
		                    </li>
		                    <li><a href="#quotation-tab" data-toggle="tab">{{trans('messages.quotation')}}</a>
		                    </li>
		                    <li><a href="#payment-tab" data-toggle="tab">{{trans('messages.payment')}}</a>
		                    </li>
		                    <li><a href="#schedule-job-tab" data-toggle="tab">{{trans('messages.scheduled_job')}}</a>
		                    </li>
		                </ul>-->

				        <div class="tab-content col-md-12 col-xs-12" style="padding:0px 25px 10px 25px;">
						  <div class="tab-pane animated fadeInRight" id="general-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{{ trans('messages.general') }}</strong> {{ trans('messages.configuration') }}</h2>
						    	{!! Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-general-form','id' => 'config-general-form','data-no-form-clear' => 1]) !!}
                                    @include('configuration._general_form')
                                {!! Form::close() !!}
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="logo-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{{ trans('messages.logo') }}</strong></h2>
						    	{!! Form::open(['files' => true, 'route' => 'configuration.logo','role' => 'form', 'class'=>'config-logo-form','id' => 'config-logo-form']) !!}
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <input type="file" class="btn btn-default file-input" name="company_logo" id="company_logo" data-buttonText="{!! trans('messages.select').' '.trans('messages.logo') !!}">
                                            </div>
                                        </div>
                                    </div>
                                    @if(config('config.company_logo') && File::exists(config('constant.upload_path.company_logo').config('config.company_logo')))
                                    <div class="form-group">
                                        <img src="{{ URL::to(config('constant.upload_path.company_logo').config('config.company_logo')) }}" width="150px" style="margin-left:20px;">
                                        <div class="checkbox">
                                            <label>
                                              <input name="remove_logo" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" data-off-value="0"> {!! trans('messages.remove').' '.trans('messages.logo') !!}
                                            </label>
                                        </div>
                                    </div>
                                    @endif
                                {!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary']) !!}
                                {!! Form::close() !!}
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="theme-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{{trans('messages.theme')}}</strong> {{ trans('messages.configuration') }}</h2>
						    	{!! Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-theme-form','id' => 'config-theme-form']) !!}
                                    @include('configuration._theme_form')
                                {!! Form::close() !!}
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="system-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{{ trans('messages.system') }}</strong> {{ trans('messages.configuration') }}</h2>
						    	{!! Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-system-form','id' => 'config-system-form','data-disable-enter-submission' => '1','data-no-form-clear' => 1]) !!}
                                    @include('configuration._system_form')
                                {!! Form::close() !!}
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="mail-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{{trans('messages.mail')}}</strong> {{ trans('messages.mail') }}</h2>
						    	{!! Form::open(['route' => 'configuration.mail','role' => 'form', 'class'=>'config-mail-form','id' => 'config-mail-form','data-no-form-clear' => 1]) !!}
                                    @include('configuration._mail_form')
                                {!! Form::close() !!}
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="sms-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>SMS</strong> {{ trans('messages.configuration') }}</h2>
						    	{!! Form::open(['route' => 'configuration.sms','role' => 'form', 'class'=>'config-sms-form','id' => 'config-sms-form','data-no-form-clear' => 1]) !!}
                                    @include('configuration._sms_form')
                                {!! Form::close() !!}
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="auth-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{{ trans('messages.authentication') }}</strong></h2>
						    	{!! Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-auth-form','id' => 'config-auth-form','data-no-form-clear' => 1]) !!}
                                    @include('configuration._auth_form')
                                {!! Form::close() !!}
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="social-login-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{{ trans('messages.social') }}</strong> {{ trans('messages.login') }}</h2>
						    	{!! Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-social-login-form','id' => 'config-social-login-form','data-no-form-clear' => 1]) !!}
                                    @include('configuration._social_login_form')
                                {!! Form::close() !!}
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="menu-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{{ trans('messages.menu') }}</strong> {{ trans('messages.configuration') }}</h2>
						    	{!! Form::open(['route' => 'configuration.menu','role' => 'form', 'class'=>'config-menu-form','id' => 'config-menu-form','data-draggable' => 1,'data-no-form-clear' => 1,'data-sidebar' => 1]) !!}
								<div class="draggable-container">
									<?php $i = 0; ?>
									@foreach(\App\Menu::orderBy('order')->orderBy('id')->get() as $menu_item)
										<?php $i++; ?>
									  <div class="draggable" data-name="{{$menu_item->name}}" data-index="{{$i}}">
									    <p><input type="checkbox" class="icheck" name="{{$menu_item->name}}-visible" value="1" {{($menu_item->visible) ? 'checked' : ''}}> <span style="margin-left:50px;">{{toWord($menu_item->name)}}</span></p>
									  </div>
									@endforeach
								</div>
								{!! Form::hidden('config_type','menu')!!}
			  					{!! Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
								{!! Form::close() !!}
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="currency-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{!! trans('messages.currency').' '.trans('messages.configuration') !!}</strong></h2>
						    	<div class="row">
									<div class="col-sm-4">
										<div class="box-info">
											<h2><strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.currency') !!} </h2>
											{!! Form::open(['route' => 'currency.store','class'=>'currency-form','id' => 'currency-form','data-table-refresh' => 'currency-table']) !!}
												@include('currency._form')
											{!! Form::close() !!}
										</div>
									</div>
									<div class="col-sm-8">
										<div class="box-info full">
											<h2><strong>{!! trans('messages.list_all').'</strong> '.trans('messages.currency') !!} </h2>
											<div class="table-responsive">
												<table data-sortable class="table table-hover table-striped ajax-table show-table" id="currency-table" data-source="/currency/lists">
													<thead>
														<tr>
															<th>{!! trans('messages.name') !!}</th>
															<th>{!! trans('messages.symbol') !!}</th>
															<th>{!! trans('messages.position') !!}</th>
															<th>{!! trans('messages.decimal') !!}</th>
															<th>{!! trans('messages.default') !!}</th>
															<th data-sortable="false">{!! trans('messages.option') !!}</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
										<div class="box-info">
											<h2><strong>Note</strong></h2>
											<div class="the-notes success" style="text-align:justify;">
												Choose default currency carefully, do not change default currency after making any transaction. Your calculation may go wrong if you change default currency after making transaction.
											</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="payment-gateway-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{{trans('messages.payment').' '.trans('messages.gateway')}} </strong>{!!trans('messages.configuration') !!}</h2>
						    	{!! Form::open(['route' => 'configuration.store','role' => 'form', 'class'=>'config-payment-gateway-form','id' => 'config-payment-gateway-form','data-no-form-clear' => 1]) !!}
						    		@include('configuration._payment_gateway_form')
                                {!! Form::close() !!}

						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="taxation-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{!! trans('messages.taxation').' '.trans('messages.configuration') !!}</strong></h2>
						    	<div class="row">
									<div class="col-sm-4">
										<div class="box-info">
											<h2><strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.taxation') !!} </h2>
											{!! Form::open(['route' => 'taxation.store','class'=>'taxation-form','id' => 'taxation-form','data-table-refresh' => 'taxation-table']) !!}
												@include('taxation._form')
											{!! Form::close() !!}
										</div>
									</div>
									<div class="col-sm-8">
										<div class="box-info full">
											<h2><strong>{!! trans('messages.list_all').'</strong> '.trans('messages.taxation') !!} </h2>
											<div class="table-responsive">
												<table data-sortable class="table table-hover table-striped ajax-table show-table" id="taxation-table" data-source="/taxation/lists">
													<thead>
														<tr>
															<th>{!! trans('messages.name') !!}</th>
															<th>{!! trans('messages.value') !!}</th>
															<th>{!! trans('messages.description') !!}</th>
															<th>{!! trans('messages.default') !!}</th>
															<th data-sortable="false">{!! trans('messages.option') !!}</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="customer-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{!! trans('messages.customer').' '.trans('messages.configuration') !!}</strong></h2>
						    	<div class="row">
									<div class="col-sm-4">
										<div class="box-info">
											<h2><strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.customer').' '.trans('messages.group') !!} </h2>
											{!! Form::open(['route' => 'customer-group.store','class'=>'customer-group-form','id' => 'customer-group-form','data-table-refresh' => 'customer-group-table']) !!}
												@include('customer_group._form')
											{!! Form::close() !!}
										</div>
									</div>
									<div class="col-sm-8">
										<div class="box-info full">
											<h2><strong>{!! trans('messages.list_all').'</strong> '.trans('messages.customer').' '.trans('messages.group') !!} </h2>
											<div class="table-responsive">
												<table data-sortable class="table table-hover table-striped ajax-table show-table" id="customer-group-table" data-source="/customer-group/lists">
													<thead>
														<tr>
															<th>{!! trans('messages.name') !!}</th>
															<th>{!! trans('messages.description') !!}</th>
															<th data-sortable="false">{!! trans('messages.option') !!}</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="expense-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{!! trans('messages.expense').' '.trans('messages.configuration') !!}</strong></h2>
						    	<div class="row">
									<div class="col-sm-4">
										<div class="box-info">
											<h2><strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.expense').' '.trans('messages.category') !!} </h2>
											{!! Form::open(['route' => 'expense-category.store','class'=>'expense-category-form','id' => 'expense-category-form','data-table-refresh' => 'expense-category-table']) !!}
												@include('expense_category._form')
											{!! Form::close() !!}
										</div>
									</div>
									<div class="col-sm-8">
										<div class="box-info full">
											<h2><strong>{!! trans('messages.list_all').'</strong> '.trans('messages.expense').' '.trans('messages.category') !!} </h2>
											<div class="table-responsive">
												<table data-sortable class="table table-hover table-striped ajax-table show-table" id="expense-category-table" data-source="/expense-category/lists">
													<thead>
														<tr>
															<th>{!! trans('messages.name') !!}</th>
															<th>{!! trans('messages.description') !!}</th>
															<th data-sortable="false">{!! trans('messages.option') !!}</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="income-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{!! trans('messages.income').' '.trans('messages.configuration') !!}</strong></h2>
						    	<div class="row">
									<div class="col-sm-4">
										<div class="box-info">
											<h2><strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.income').' '.trans('messages.category') !!} </h2>
											{!! Form::open(['route' => 'income-category.store','class'=>'income-category-form','id' => 'income-category-form','data-table-refresh' => 'income-category-table']) !!}
												@include('income_category._form')
											{!! Form::close() !!}
										</div>
									</div>
									<div class="col-sm-8">
										<div class="box-info full">
											<h2><strong>{!! trans('messages.list_all').'</strong> '.trans('messages.income').' '.trans('messages.category') !!} </h2>
											<div class="table-responsive">
												<table data-sortable class="table table-hover table-striped ajax-table show-table" id="income-category-table" data-source="/income-category/lists">
													<thead>
														<tr>
															<th>{!! trans('messages.name') !!}</th>
															<th>{!! trans('messages.description') !!}</th>
															<th data-sortable="false">{!! trans('messages.option') !!}</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="item-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{!! trans('messages.item').' '.trans('messages.configuration') !!}</strong></h2>
						    	<div class="row">
									<div class="col-sm-4">
										<div class="box-info">
											<h2><strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.item').' '.trans('messages.category') !!} </h2>
											{!! Form::open(['route' => 'item-category.store','class'=>'item-category-form','id' => 'item-category-form','data-table-refresh' => 'item-category-table']) !!}
												@include('item_category._form')
											{!! Form::close() !!}
										</div>
									</div>
									<div class="col-sm-8">
										<div class="box-info full">
											<h2><strong>{!! trans('messages.list_all').'</strong> '.trans('messages.item').' '.trans('messages.category') !!} </h2>
											<div class="table-responsive">
												<table data-sortable class="table table-hover table-striped ajax-table show-table" id="item-category-table" data-source="/item-category/lists">
													<thead>
														<tr>
															<th>{!! trans('messages.name') !!}</th>
															<th>{!! trans('messages.type') !!}</th>
															<th>{!! trans('messages.description') !!}</th>
															<th data-sortable="false">{!! trans('messages.option') !!}</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="invoice-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{!! trans('messages.invoice').' '.trans('messages.configuration') !!}</strong></h2>
						    	@include('configuration._invoice_form')
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="quotation-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{!! trans('messages.quotation').' '.trans('messages.configuration') !!}</strong></h2>
						    	@include('configuration._quotation_form')
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="payment-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{!! trans('messages.payment').' '.trans('messages.configuration') !!}</strong></h2>
						    	<div class="row">
									<div class="col-sm-4">
										<div class="box-info">
											<h2><strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.payment').' '.trans('messages.method') !!} </h2>
											{!! Form::open(['route' => 'payment-method.store','class'=>'payment-method-form','id' => 'payment-method-form','data-table-refresh' => 'payment-method-table']) !!}
												@include('payment_method._form')
											{!! Form::close() !!}
										</div>
									</div>
									<div class="col-sm-8">
										<div class="box-info full">
											<h2><strong>{!! trans('messages.list_all').'</strong> '.trans('messages.payment').' '.trans('messages.method') !!} </h2>
											<div class="table-responsive">
												<table data-sortable class="table table-hover table-striped ajax-table show-table" id="payment-method-table" data-source="/payment-method/lists">
													<thead>
														<tr>
															<th>{!! trans('messages.name') !!}</th>
															<th>{!! trans('messages.type') !!}</th>
															<th>{!! trans('messages.description') !!}</th>
															<th data-sortable="false">{!! trans('messages.option') !!}</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
						  <div class="tab-pane animated fadeInRight" id="schedule-job-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{{trans('messages.scheduled_job')}}</strong></h2>
						    	<p>Add below cron command in your server:</p>
								<div class="well">
									php /path-to-artisan schedule:run >> /dev/null 2>&1
								</div>
								<div class="table-responsive">
									<table class="table table-stripped table-bordered table-hover">
										<thead>
											<tr>
												<th>Action</th>
												<th>Frequency</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Recurring Invoice Generation</td>
												<td>Once Per day at 12:00 AM</td>
											</tr>
											<tr>
												<td>Birthday/Anniversary wish to Staff/Customer</td>
												<td>Once per day at 09:00 AM</td>
											</tr>
											<tr>
												<td>Daily Backup</td>
												<td>Once per day at 01:00 AM</td>
											</tr>
										</tbody>
									</table>
								</div>
						    </div>
						  </div>
						</div>
					</div>
				</div>
			</div>
		</div>

	@stop