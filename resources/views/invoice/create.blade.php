@extends('layouts.app')

	@section('breadcrumb')
        <ul class="breadcrumb">
		    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
		    <li><a href="/invoice">{!! trans('messages.invoice') !!}</a></li>
		    <li class="active">{!! trans('messages.add_new') !!}</li>
		</ul>
	@stop
	
	@section('content')
		<div class="row" id="invoice-page">
			<div class="col-md-12">
				<div class="box-info">
					{!! Form::open(['route' => 'invoice.store','role' => 'form', 'class'=>'invoice-form','id' => 'invoice-form','data-disable-enter-submission' => '1','data-file-upload' => '.file-uploader']) !!}
					<h2><strong>{{trans('messages.add_new')}}</strong> {{trans('messages.invoice')}}</h2>
					<div class="additional-btn">
						@if(!isset($invoice))
							<a href="/invoice" class="btn btn-danger btn-sm"><i class="fa fa-times icon"></i> {{trans('messages.invoice_discard')}}</a> 
						@endif
						{!! Form::submit(isset($buttonText) ? $buttonText : (trans('messages.send')),['name' => 'send_invoice','class' => 'btn btn-success btn-sm post-button','data-button-value' => 'send']) !!}
						{!! Form::submit(isset($buttonText) ? $buttonText : (trans('messages.save').' '.trans('messages.invoice_draft')),['name' => 'draft_invoice','class' => 'btn btn-primary btn-sm post-button','data-button-value' => 'draft']) !!}

{!! Form::submit(isset($buttonText) ? $buttonText : (trans('messages.preview')),['name' => 'view_invoice','class' => 'btn btn-success btn-sm post-button','data-button-value' => 'view']) !!}
					</div>
						@include('invoice._form')
						
					{{ getCustomFields('invoice-form',$custom_field_values) }}

					<div class="pull-right">
						@if(!isset($invoice))
							<a href="/invoice" class="btn btn-danger btn-sm"><i class="fa fa-times icon"></i> {{trans('messages.invoice_discard')}}</a> 
						@endif
						{!! Form::submit(isset($buttonText) ? $buttonText : (trans('messages.send')),['name' => 'send_invoice','class' => 'btn btn-success btn-sm post-button','data-button-value' => 'send']) !!}
						{!! Form::submit(isset($buttonText) ? $buttonText : (trans('messages.save').' '.trans('messages.invoice_draft')),['name' => 'draft_invoice','class' => 'btn btn-primary btn-sm post-button','data-button-value' => 'draft']) !!}
					</div>
					<input type="hidden" name="form_action" id="form-action" value="" readonly>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	@stop