@extends('layouts.app')

	@section('breadcrumb')
		<ul class="breadcrumb">
		    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
		    <li class="active">{!! trans('messages.expense') !!}</li>
		</ul>
	@stop
	
	@section('content')
		<div class="row">
			<div class="col-sm-12 collapse" id="box-detail-filter">
				<div class="box-info">
					<h2><strong>{!! trans('messages.filter') !!}</strong> {!! trans('messages.expense') !!}
					<div class="additional-btn">
						<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#box-detail-filter"><i class="fa fa-minus icon"></i> {!! trans('messages.hide') !!}</button>
					</div></h2>
					{!! Form::open(['url' => 'filter','id' => 'expense-filter-form','data-no-form-clear' => 1]) !!}
						<div class="col-md-3">
							<div class="form-group">
								<label for="reference_number">{!! trans('messages.reference').' '.trans('messages.number') !!}</label>
								{!! Form::input('text','reference_number','',['class'=>'form-control','placeholder'=>trans('messages.reference').' '.trans('messages.number')])!!}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="reference_number">{!! trans('messages.token') !!}</label>
								{!! Form::input('text','token','',['class'=>'form-control','placeholder'=>trans('messages.token')])!!}
							</div>
						</div>
						<div class="col-md-3">
						  	<div class="form-group">
								<label for="expense_category_id">{!! trans('messages.expense').' '.trans('messages.category') !!}</label>
								{!! Form::select('expense_category_id[]', $expense_categories,'',['class'=>'form-control show-tick','title'=>trans('messages.select_one'),'multiple' => 'multiple','data-actions-box' => "true"])!!}
						  	</div>
						</div>
						<div class="col-md-3">
						  	<div class="form-group">
								<label for="currency_id">{!! trans('messages.currency') !!}</label>
								{!! Form::select('currency_id[]', $currencies,'',['class'=>'form-control show-tick','title'=>trans('messages.select_one'),'multiple' => 'multiple','data-actions-box' => "true"])!!}
						  	</div>
						</div>
						<div class="col-md-3">
						  	<div class="form-group">
								<label for="customer_id">{!! trans('messages.customer') !!}</label>
								{!! Form::select('customer_id', $customers,'',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
						  	</div>
						</div>
						<div class="col-md-3">
						  	<div class="form-group">
								<label for="account_id">{!! trans('messages.account') !!}</label>
								{!! Form::select('account_id[]', $accounts,'',['class'=>'form-control show-tick','title'=>trans('messages.select_one'),'multiple' => 'multiple','data-actions-box' => "true"])!!}
						  	</div>
						</div>
						<div class="col-md-3">
						  	<div class="form-group">
								<label for="payment_method_id">{!! trans('messages.payment').' '.trans('messages.method') !!}</label>
								{!! Form::select('payment_method_id[]', $payment_methods,'',['class'=>'form-control show-tick','title'=>trans('messages.select_one'),'multiple' => 'multiple','data-actions-box' => "true"])!!}
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
						<div class="col-md-3">
							<div class="checkbox">
		                        <label>
		                        	<input type="checkbox" class="icheck" name="has_attachment" value="1"> has {{trans('messages.attachment')}}
		                        </label>
		                    </div>
						</div>
						<div class="clear"></div>
						<div class="form-group">
							<button type="submit" class="btn btn-default btn-success pull-right">{!! trans('messages.filter') !!}</button>
						</div>
					{!! Form::close() !!}
				</div>
			</div>

			@if(Entrust::can('create-expense'))
			<div class="col-sm-12 collapse" id="box-detail">
				<div class="box-info">
					<h2><strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.expense') !!}
					<div class="additional-btn">
						<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#box-detail"><i class="fa fa-minus icon"></i> {!! trans('messages.hide') !!}</button>
					</div></h2>
					{!! Form::model($type,['method' => 'POST','route' => ['transaction.store',$type] ,'class' => 'transaction-form','id' => 'transaction-edit','files' => true,'data-disable-enter-submission' => 1,'data-file-upload' => '.file-uploader']) !!}
						@include('transaction._form')
					{!! Form::close() !!}
				</div>
			</div>
			@endif

			<div class="col-sm-12">
				<div class="box-info full">
					<h2><strong>{!! trans('messages.list_all') !!}</strong> {!! trans('messages.expense') !!}</h2>
					<div class="additional-btn">
						<a href="#" data-toggle="collapse" data-target="#box-detail-filter"><button class="btn btn-sm btn-primary"><i class="fa fa-filter icon"></i> {!! trans('messages.filter') !!}</button></a>
						@if(Entrust::can('create-expense'))
							<a href="#" data-toggle="collapse" data-target="#box-detail"><button class="btn btn-sm btn-primary"><i class="fa fa-plus icon"></i> {!! trans('messages.add_new') !!}</button></a>
						@endif
					</div>
					@include('global.datatable',['table' => $table_data['expense-table']])
				</div>
			</div>
		</div>

	@stop