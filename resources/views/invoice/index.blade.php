@extends('layouts.app')

	@section('breadcrumb')
		<ul class="breadcrumb">
		    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
		    <li class="active">{!! trans('messages.invoice') !!}</li>
		</ul>
	@stop
	
	@section('content')

		<div class="row">
			<div class="col-sm-12 collapse" id="box-detail-filter">
				<div class="box-info">
					<h2><strong>{!! trans('messages.filter') !!}</strong> {!! trans('messages.invoice') !!}
					<div class="additional-btn">
						<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#box-detail-filter"><i class="fa fa-minus icon"></i> {!! trans('messages.hide') !!}</button>
					</div></h2>
					{!! Form::open(['url' => 'filter','id' => 'invoice-filter-form','data-no-form-clear' => 1]) !!}
						<div class="row">
							@if(!Entrust::hasRole(config('constant.default_user_role')))
								<div class="col-md-3">
								  	<div class="form-group">
										<label for="to_date">{!! trans('messages.customer') !!}</label>
										{!! Form::select('customer_id[]', $customers,'',['class'=>'form-control show-tick','title'=>trans('messages.select_one'),'multiple' => 'multiple','data-actions-box' => "true"])!!}
								  	</div>
								</div>
								<div class="col-md-3">
								  	<div class="form-group">
										<label for="to_date">{!! trans('messages.staff') !!}</label>
										{!! Form::select('user_id[]', $users,'',['class'=>'form-control show-tick','title'=>trans('messages.select_one'),'multiple' => 'multiple','data-actions-box' => "true"])!!}
								  	</div>
								</div>
							@endif
							<div class="col-md-3">
							  	<div class="form-group">
									<label for="to_date">{!! trans('messages.status') !!}</label>
									{!! Form::select('status[]', $invoice_status,'',['class'=>'form-control show-tick','title'=>trans('messages.select_one'),'multiple' => 'multiple','data-actions-box' => "true"])!!}
							  	</div>
							</div>
							<div class="col-md-3">
							  	<div class="form-group">
									<label for="to_date">{!! trans('messages.payment').' '.trans('messages.status') !!}</label>
									{!! Form::select('payment_status[]', $invoice_payment_status,'',['class'=>'form-control show-tick','title'=>trans('messages.select_one'),'multiple' => 'multiple','data-actions-box' => "true"])!!}
							  	</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="date_range">{{trans('messages.date')}}</label>
									<div class="input-daterange input-group" id="datepicker">
									    <input type="text" class="input-sm form-control" name="start_date" readonly />
									    <span class="input-group-addon">to</span>
									    <input type="text" class="input-sm form-control" name="end_date" readonly />
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<label for="">&nbsp;</label>
								<div class="checkbox">
			                        <label>
			                        	<input type="checkbox" class="icheck" name="cancelled" value="1"> {{trans('messages.cancelled')}}
			                        </label>
			                        <label>
			                        	<input type="checkbox" class="icheck" name="recurring" value="1"> {{trans('messages.recurring')}}
			                        </label>
			                        <label>
			                        	<input type="checkbox" class="icheck" name="overdue" value="1"> {{trans('messages.overdue')}}
			                        </label>
			                    </div>
							</div>
						</div>
						<div class="form-group">
						<button type="submit" class="btn btn-default btn-success pull-right">{!! trans('messages.filter') !!}</button>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
			<div class="col-sm-12">
				<div class="box-info full">
					<h2><strong>{!! trans('messages.list_all') !!}</strong> {!! trans('messages.invoice') !!}</h2>
					<div class="additional-btn">
						<a href="#" data-toggle="collapse" data-target="#box-detail-filter"><button class="btn btn-sm btn-primary"><i class="fa fa-filter icon"></i> {!! trans('messages.filter') !!}</button></a>
						@if(Entrust::can('create-invoice'))
							<a href="/invoice/create" class="btn btn-sm btn-primary"><i class="fa fa-plus icon"></i> {!! trans('messages.add_new') !!}</a>
						@endif
					</div>
					@include('global.datatable',['table' => $table_data['invoice-table']])
				</div>
			</div>
		</div>

	@stop