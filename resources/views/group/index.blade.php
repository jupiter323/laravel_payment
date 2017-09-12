@extends('layouts.app')

	@section('breadcrumb')
		<ul class="breadcrumb">
		    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
		    <li class="active">{!! trans('messages.group') !!}</li>
		</ul>
	@stop
	
	@section('content')
		<div class="row">
			
			<div class="col-sm-12 collapse" id="box-detail">
				<div class="box-info">
					<h2><strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.group') !!}
					<div class="additional-btn">
						<button class="btn btn-sm btn-primary" data-toggle="collapse" data-target="#box-detail"><i class="fa fa-minus icon"></i> {!! trans('messages.hide') !!}</button>
					</div></h2>
					{!! Form::open(['route' => 'group.store','role' => 'form', 'class'=>'group-form','id' => 'group-form']) !!}
						@include('group._form')
					{!! Form::close() !!}
				</div>
			</div>
			

			<div class="col-sm-12">
				<div class="box-info full">
					<h2><strong>{!! trans('messages.list_all') !!}</strong> {!! trans('messages.group') !!}</h2>
					<div class="additional-btn">
						
							<a href="#" data-toggle="collapse" data-target="#box-detail"><button class="btn btn-sm btn-primary"><i class="fa fa-plus icon"></i> {!! trans('messages.add_new') !!}</button></a>
						
					</div>
					@include('global.datatable',['table' => $table_data['company-table']])
				</div>
			</div>
		</div>

	@stop