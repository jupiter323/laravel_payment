@extends('layouts.app')

	@section('breadcrumb')
		<ul class="breadcrumb">
		    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
		    <li><a href="/quotation">{!! trans('messages.quotation') !!}</a></li>
		    <li class="active">{!! $quotation->Customer->full_name !!}</li>
		</ul>
	@stop
	
	@section('content')

		<div class="row">
			<div class="col-md-12">
				<div id="load-quotation-action-button" data-extra="&quotation_id={{$quotation->id}}" data-source="/quotation-action-button" style="margin-bottom: 10px;"></div>
			</div>
		
			<div class="col-sm-12 collapse" id="quotation-discussion">
				<div class="box-info">
					<h2><strong>{!! trans('messages.quotation') !!}</strong> {!! trans('messages.discussion') !!}</h2>
					<div class="additional-btn">
						<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#box-detail"><i class="fa fa-minus icon"></i> {!! trans('messages.hide') !!}</button>
					</div>
					@if($quotation->status != 'dead')
						{!! Form::model($quotation,['method' => 'POST','route' => ['quotation.store-discussion',$quotation] ,'class' => 'quotation-discussion-form','id' => 'quotation-discussion-form','data-refresh' => 'load-quotation-discussion']) !!}
							<div class="form-group">
								{!! Form::textarea('comment','',['size' => '30x1', 'class' => 'form-control', 'placeholder' => trans('messages.comment'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1])!!}
								<span class="countdown"></span>
							</div>
							<div class="form-group">
								{!! Form::submit(trans('messages.post'),['class' => 'btn btn-primary btn-sm pull-right']) !!}
							</div>
						{!! Form::close() !!}
					@else
						@include('global.notification',['message' => trans('messages.quotation').' '.trans('messages.marked').' '.trans('messages.as').' '.trans('messages.dead'),'type' => 'danger'])
					@endif

					<div class="clear"></div>

					<div id="load-quotation-discussion" data-extra="&quotation_id={{$quotation->id}}" data-source="/quotation-discussion" style="margin-top: 20px;"></div>
				</div>
			</div>
			<div class="col-sm-12 collapse" id="email-detail">
				<div class="box-info">
					<h2><strong>{!! trans('messages.email') !!}</strong> {!! trans('messages.log') !!}</h2>
					<div class="additional-btn">
						<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#email-detail"><i class="fa fa-minus icon"></i> {!! trans('messages.hide') !!}</button>
					</div>
					<div class="table-responsive custom-scrollbar">
						<table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="quotation-email-table" data-source="/quotation/email/lists" data-extra="&quotation_id={{$quotation->id}}">
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
		</div>

		@include('quotation.quotation')

		@if($uploads->count())
		<div class="row">
			<div class="col-md-12">
				<div class="box-info">
					<h2><strong>{{trans('messages.attachment')}}</strong></h2>
		            @foreach($uploads as $upload)
		                <p><i class="fa fa-paperclip"></i> <a href="/quotation/{{$upload->attachments}}/download">{{$upload->user_filename}}</a></p>
		            @endforeach
        		</div>
			</div>
		</div>
		@endif
	@stop