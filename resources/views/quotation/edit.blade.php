@extends('layouts.app')

	@section('breadcrumb')
		<ul class="breadcrumb">
		    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
		    <li><a href="/quotation">{!! trans('messages.quotation') !!}</a></li>
		    <li class="active">{!! $quotation->Customer->full_name !!}</li>
		</ul>
	@stop
	
	@section('content')
		<div class="row" id="invoice-page">
			<div class="col-md-12">
			{!! Form::model($quotation,['method' => 'PATCH','route' => ['quotation.update',$quotation->id] ,'class' => 'quotation-edit-form','id' => 'quotation-edit-form','data-file-upload' => '.file-uploader']) !!}
			<div class="box-info">
				<h2><strong>{{ trans('messages.edit') }}</strong> {{ trans('messages.quotation') }}
				</h2>
				<div class="additional-btn">
					<a href="/quotation/{{$quotation->uuid}}" class="btn btn-danger btn-sm"><i class="fa fa-times icon"></i> {{trans('messages.cancel').' '.trans('messages.edit')}}</a> 
					{!! Form::submit(trans('messages.update'),['class' => 'btn btn-primary btn-sm']) !!}
				</div>
				@include('quotation._form')
				{{ getCustomFields('quotation-form',$custom_field_values) }}

				<div class="pull-right">
					<a href="/quotation/{{$quotation->uuid}}" class="btn btn-danger"><i class="fa fa-times icon"></i> {{trans('messages.cancel').' '.trans('messages.edit')}}</a> 
					{!! Form::submit(trans('messages.update'),['class' => 'btn btn-primary']) !!}
				</div>
			</div>
			{!! Form::close() !!}
			</div>
		</div>
	@stop