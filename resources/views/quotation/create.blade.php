@extends('layouts.app')

	@section('breadcrumb')
        <ul class="breadcrumb">
		    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
		    <li><a href="/quotation">{!! trans('messages.quotation') !!}</a></li>
		    <li class="active">{!! trans('messages.add_new') !!}</li>
		</ul>
	@stop
	
	@section('content')
		<div class="row" id="invoice-page">
			<div class="col-md-12">
				<div class="box-info">
					{!! Form::open(['route' => 'quotation.store','role' => 'form', 'class'=>'quotation-form','id' => 'quotation-form','data-file-upload' => '.file-uploader']) !!}
					<h2><strong>{{trans('messages.add_new')}}</strong> {{trans('messages.quotation')}}</h2>
					<div class="additional-btn">
						@if(!isset($quotation))
							<a href="/quotation" class="btn btn-danger btn-sm"><i class="fa fa-times icon"></i> {{trans('messages.invoice_discard')}}</a> 
						@endif
						{!! Form::submit(isset($buttonText) ? $buttonText : (trans('messages.send')),['name' => 'send_quotation','class' => 'btn btn-success btn-sm post-button','data-button-value' => 'send']) !!}
						{!! Form::submit(isset($buttonText) ? $buttonText : (trans('messages.save').' '.trans('messages.invoice_draft')),['name' => 'draft_quotation','class' => 'btn btn-primary btn-sm post-button','data-button-value' => 'draft']) !!}
					</div>
						@include('quotation._form')
						{{ getCustomFields('quotation-form',$custom_field_values) }}

						<div class="pull-right">
							@if(!isset($quotation))
								<a href="/quotation" class="btn btn-danger btn-sm"><i class="fa fa-times icon"></i> {{trans('messages.invoice_discard')}}</a> 
							@endif
							{!! Form::submit(isset($buttonText) ? $buttonText : (trans('messages.send')),['name' => 'send_quotation','class' => 'btn btn-success btn-sm post-button','data-button-value' => 'send']) !!}
							{!! Form::submit(isset($buttonText) ? $buttonText : (trans('messages.save').' '.trans('messages.invoice_draft')),['name' => 'draft_quotation','class' => 'btn btn-primary btn-sm post-button','data-button-value' => 'draft']) !!}
						</div>
						<input type="hidden" name="form_action" id="form-action" value="" readonly>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	@stop