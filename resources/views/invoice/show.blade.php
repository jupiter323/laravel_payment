@extends('layouts.app')

	@section('breadcrumb')
		<ul class="breadcrumb">
		    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
		    <li><a href="/invoice">{!! trans('messages.invoice') !!}</a></li>
		    <li class="active">{!! $invoice->Customer->full_name !!}</li>
		</ul>
	@stop
	
	@section('content')
		<div class="row">
			<div class="col-md-12">
				<div id="load-invoice-action-button" data-extra="&invoice_id={{$invoice->id}}" data-source="/invoice-action-button" style="margin-bottom: 10px;"></div>
			</div>

			@if(Entrust::hasRole(config('constant.default_customer_role')) && config('config.enable_customer_payment'))
			<div class="col-sm-12 collapse" id="customer-payment-detail">
				<div class="box-info full">
					<div class="tabs-left">	
						<ul class="nav nav-tabs col-md-2 tab-list" style="padding-right:0;">
							@if(config('config.enable_paypal_payment'))
		                    	<li><a href="#paypal-tab" data-toggle="tab">Paypal</a></li>
		                    @endif
		                    @if(config('config.enable_stripe_payment'))
		                    	<li><a href="#stripe-tab" data-toggle="tab">Stripe</a></li>
		                    @endif
		                    @if(config('config.enable_tco_payment'))
		                    	<li><a href="#tco-tab" data-toggle="tab">Two Checkout</a></li>
		                    @endif
		                    @if($invoice->Currency->name == 'INR' && config('config.enable_payumoney_payment'))
		                    	<li><a href="#payumoney-tab" data-toggle="tab">PayUMoney</a></li>
		                    @endif
		                </ul>

				        <div class="tab-content col-md-10 col-xs-10" style="padding:0px 25px 10px 25px;">
				          @if(config('config.enable_paypal_payment'))
							  <div class="tab-pane animated fadeInRight" id="paypal-tab">
							    <div class="user-profile-content-wm">
							    	<h2><strong>Pay via Paypal</strong></h2>
							    	{!! Form::model($invoice,['method' => 'POST','route' => ['paypal',$invoice->id] ,'class' => 'paypal-payment-form','id' => 'paypal-payment-form','data-submit' => 'noAjax']) !!}
							    		@include('invoice._customer_payment_form',['gateway' => 'paypal'])
							    	{!! Form::close() !!}
							    </div>
							  </div>
						  @endif
						  @if(config('config.enable_stripe_payment'))
							  <div class="tab-pane animated fadeInRight" id="stripe-tab">
							    <div class="user-profile-content-wm">
							    	<h2><strong>Pay via Stripe (Credit Card)</strong></h2>
							    	{!! Form::model($invoice,['method' => 'POST','route' => ['stripe',$invoice->id] ,'class' => 'stripe-payment-form','id' => 'stripe-payment-form','data-submit' => 'noAjax']) !!}
							    		@include('invoice._customer_payment_form',['gateway' => 'stripe'])
							    	{!! Form::close() !!}
							    </div>
							  </div>
						  @endif
						  @if(config('config.enable_tco_payment'))
							  <div class="tab-pane animated fadeInRight" id="tco-tab">
							    <div class="user-profile-content-wm">
							    	<h2><strong>Pay via 2 Checkout (Credit Card)</strong></h2>
							    	{!! Form::model($invoice,['method' => 'POST','route' => ['tco',$invoice->id] ,'class' => 'tco-payment-form','id' => 'tco-payment-form','data-submit' => 'noAjax']) !!}
							    		@include('invoice._customer_payment_form',['gateway' => 'tco'])
							    	{!! Form::close() !!}
							    </div>
							  </div>
						  @endif
						  @if($invoice->Currency->name == 'INR' && config('config.enable_payumoney_payment'))
							  <div class="tab-pane animated fadeInRight" id="payumoney-tab">
							    <div class="user-profile-content-wm">
						    		<h2><strong>Pay via PayUMoney</strong></h2>
							    	{!! Form::model($invoice,['method' => 'POST','route' => ['payumoney',$invoice->id] ,'class' => 'payumoney-payment-form','id' => 'payumoney-payment-form','data-submit' => 'noAjax']) !!}
						    			@include('invoice._customer_payment_form',['gateway' => 'payumoney'])
						    		{!! Form::close() !!}
							    </div>
							  </div>
						  @endif
						</div>
		            </div>
				</div>
			</div>
			@endif

			@if(!Entrust::hasRole(config('constant.default_customer_role')))
			<div class="col-sm-12 collapse" id="recurring-detail">
				<div class="box-info">
					<h2><strong>{!! trans('messages.recurring') !!}</strong> {!! trans('messages.invoice') !!}</h2>
					<div class="additional-btn">
						<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#recurring-detail"><i class="fa fa-minus icon"></i> {!! trans('messages.hide') !!}</button>
					</div>

					{!! Form::model($invoice,['method' => 'POST','route' => ['invoice.recurring',$invoice->id] ,'class' => 'invoice-recurring-form','id' => 'invoice-recurring-form','data-refresh' => 'load-invoice-action-button','data-no-form-clear' => 1]) !!}
						<div class="col-md-4">
							<div class="form-group">
							    {!! Form::label('is_recurring',trans('messages.recurring'),['class' => 'control-label '])!!}
				                <div class="checkbox">
				                <input name="is_recurring" type="checkbox" class="switch-input enable-show-hide" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" {{ ($invoice->is_recurring) ? 'checked' : '' }} data-off-value="0">
				                </div>
				            </div>
							<div id="is_recurring_field">
					            <div class="form-group">
									{!! Form::label('recurrence_from_date',trans('messages.recurrence').' '.trans('messages.from'))!!}
									{!! Form::input('text','recurrence_from_date',isset($invoice) ? $invoice->recurrence_from_date : $invoice->date,['class'=>'form-control datepicker','placeholder'=>trans('messages.recurrence').' '.trans('messages.from'),'readonly' => 'true'])!!}
								</div>
								<div class="form-group">
								    {!! Form::label('recurring_frequency',trans('messages.recurring').' '.trans('messages.frequency'),['class' => 'control-label '])!!}
					                {!! Form::select('recurring_frequency', $recurring_days, $invoice->recurring_frequency,['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
					            </div>
					            <div class="form-group">
									{!! Form::label('recurrence_upto',trans('messages.recurrence').' '.trans('messages.upto'))!!}
									{!! Form::input('text','recurrence_upto',isset($invoice) ? $invoice->recurrence_upto : '',['class'=>'form-control datepicker','placeholder'=>trans('messages.recurrence').' '.trans('messages.upto'),'readonly' => 'true'])!!}
								</div>
							</div>
							{!! Form::submit(trans('messages.save'),['class' => 'btn btn-primary']) !!}
						</div>
						<div class="col-md-8">
							<div class="table-responsive">
								<table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="invoice-recurring-table" data-source="/invoice/recurring/lists" data-extra="&invoice_id={{$invoice->id}}">
									<thead>
										<tr>
											<th>{!! trans('messages.date') !!}</th>
											<th>{!! trans('messages.status') !!}</th>
											<th data-sortable="false">{!! trans('messages.option') !!}</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>

			<div class="col-sm-12 collapse" id="payment-detail">
				<div class="box-info">
					<h2><strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.payment') !!}</h2>
					<div class="additional-btn">
						<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#payment-detail"><i class="fa fa-minus icon"></i> {!! trans('messages.hide') !!}</button>
					</div>
					@if($invoice->status == 'draft')
						@include('global.notification',['message' => trans('messages.no_payment_on_draft_invoice'),'type' => 'danger'])
					@elseif($invoice->is_cancelled)
						@include('global.notification',['message' => trans('messages.no_payment_on_cancelled_invoice'),'type' => 'danger'])
					@else
						<div class="col-md-5">
							{!! Form::model($invoice,['method' => 'POST','route' => ['invoice.payment',$invoice->id] ,'class' => 'invoice-payment-form','id' => 'invoice-payment-form','data-disable-enter-submission' => 1,'data-table-refresh' => 'invoice-payment-table','data-refresh' => 'load-invoice-status','files' => true,'data-file-upload' => '.file-uploader']) !!}
								@include('invoice._payment_form')
							{!! Form::close() !!}
						</div>
						<div class="col-md-7">
							<div class="table-responsive">
								<table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="invoice-payment-table" data-source="/invoice/payment/lists" data-extra="&invoice_id={{$invoice->id}}">
									<thead>
										<tr>
											<th>{!! trans('messages.account') !!}</th>
											<th>{!! trans('messages.date') !!}</th>
											<th>{!! trans('messages.amount') !!}</th>
											<th>{!! trans('messages.method') !!}</th>
											<th data-sortable="false" style="width:150px;">{!! trans('messages.option') !!}</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					@endif
				</div>
			</div>
			
			<div class="col-sm-12 collapse" id="email-detail">
				<div class="box-info">
					<h2><strong>{!! trans('messages.email') !!}</strong> {!! trans('messages.log') !!}</h2>
					<div class="additional-btn">
						<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#email-detail"><i class="fa fa-minus icon"></i> {!! trans('messages.hide') !!}</button>
					</div>
					<div class="table-responsive custom-scrollbar">
						<table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="invoice-email-table" data-source="/invoice/email/lists" data-extra="&invoice_id={{$invoice->id}}">
							<thead>
								<tr>
									<th>{!! trans('messages.to') !!}</th>
									<th>{!! trans('messages.subject') !!}</th>
									<th>{!! trans('messages.date') !!}</th>
									<th data-sortable="false" style="width:150px;">{!! trans('messages.option') !!}</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			@endif
		</div>
		@include('invoice.invoice')

		@if($invoice_uploads->count())
		<div class="row">
			<div class="col-md-12">
				<div class="box-info">
					<h2><strong>{{trans('messages.attachment')}}</strong></h2>
		            @foreach($invoice_uploads as $invoice_upload)
		                <p><i class="fa fa-paperclip"></i> <a href="/invoice/{{$invoice_upload->attachments}}/download">{{$invoice_upload->user_filename}}</a></p>
		            @endforeach
        		</div>
			</div>
		</div>
		@endif
	@stop