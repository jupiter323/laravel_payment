@extends('layouts.app')

	@section('breadcrumb')
		<ul class="breadcrumb">
		    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
		    <li><a href="/currency">{!! trans('messages.currency') !!}</a></li>
		    <li class="active">{!! trans('messages.currency').' '.trans('messages.conversion') !!}</li>
		</ul>
	@stop
	
	@section('content')
			
		<div class="row">
			<div class="col-sm-12 collapse" id="box-detail-filter">
				<div class="box-info">
					<h2><strong>{!! trans('messages.filter') !!}</strong> 
					<div class="additional-btn">
						<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#box-detail-filter"><i class="fa fa-minus icon"></i> {!! trans('messages.hide') !!}</button>
					</div></h2>
					{!! Form::open(['url' => 'filter','id' => 'currency-conversion-filter-form','data-no-form-clear' => 1]) !!}
						<div class="row">
							<div class="col-md-3">
							  	<div class="form-group">
									<label for="to_date">{!! trans('messages.currency') !!}</label>
									{!! Form::select('currency_id[]', $currencies,'',['class'=>'form-control show-tick','title'=>trans('messages.select_one'),'multiple' => 'multiple','data-actions-box' => "true"])!!}
							  	</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="start_date_range">{{trans('messages.date')}}</label>
									<div class="input-daterange input-group">
									    <input type="text" class="input-sm form-control" name="start_date" readonly />
									    <span class="input-group-addon">to</span>
									    <input type="text" class="input-sm form-control" name="end_date" readonly />
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
						<button type="submit" class="btn btn-default btn-success pull-right">{!! trans('messages.filter') !!}</button>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
			<div class="col-md-4">
				<div class="box-info">
					<h2><strong>{!!trans('messages.save').'</strong> '.trans('messages.conversion')!!}</h2>
					{!! Form::open(['route' => 'currency-conversion.store','role' => 'form', 'class'=>'currency-conversion-form','id' => 'currency-conversion-form','data-no-form-clear' => 1]) !!}
						<div class="form-group">
							{!! Form::label('date',trans('messages.date'),[])!!}
							{!! Form::input('text','date',date('Y-m-d'),['class'=>'form-control datepicker','placeholder'=>trans('messages.date'),'readonly' => 'true','id' => 'conversion_date'])!!}
						</div>
						<div id="currency-list" data-source="/fetch-currency" data-field="conversion_date"></div>
					{!! Form::close() !!}
				</div>
			</div>
			<div class="col-md-8">
				<div class="box-info full">
					<h2><strong>{!! trans('messages.list_all') !!}</strong> {!! trans('messages.conversion') !!}</h2>
					<div class="additional-btn">
						<a href="#" data-toggle="collapse" data-target="#box-detail-filter"><button class="btn btn-sm btn-primary"><i class="fa fa-filter icon"></i> {!! trans('messages.filter') !!}</button></a>
					</div>
					
					@include('global.datatable',['table' => $table_data['currency-conversion-table']])
				</div>
			</div>
		</div>
	@stop