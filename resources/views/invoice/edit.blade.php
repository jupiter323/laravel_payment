@extends('layouts.app')

	@section('breadcrumb')
		<ul class="breadcrumb">
		    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
		    <li><a href="/invoice">{!! trans('messages.invoice') !!}</a></li>
		    <li class="active">{!! $invoice->Customer->full_name !!}</li>
		</ul>
	@stop
	
	@section('content')
		<div class="row" id="invoice-page">
			<div class="col-md-12">
			{!! Form::model($invoice,['method' => 'PATCH','route' => ['invoice.update',$invoice->id] ,'class' => 'invoice-edit-form','id' => 'invoice-edit-form','data-file-upload' => '.file-uploader']) !!}
			<div class="box-info">
				<h2><strong>{{ trans('messages.edit') }}</strong> {{ trans('messages.invoice') }}
				</h2>
				<div class="additional-btn">
					<a href="/invoice/{{$invoice->uuid}}" class="btn btn-danger btn-sm"><i class="fa fa-times icon"></i> {{trans('messages.cancel').' '.trans('messages.edit')}}</a> 
					{!! Form::submit(trans('messages.update'),['class' => 'btn btn-primary btn-sm']) !!}
				</div>
				@include('invoice._form')
				{{ getCustomFields('invoice-form',$custom_field_values) }}

				<div class="pull-right">
					<a href="/invoice/{{$invoice->uuid}}" class="btn btn-danger"><i class="fa fa-times icon"></i> {{trans('messages.cancel').' '.trans('messages.edit')}}</a> 
					{!! Form::submit(trans('messages.update'),['class' => 'btn btn-primary']) !!}
				</div>
			</div>
			{!! Form::close() !!}
			</div>
		</div>
	@stop