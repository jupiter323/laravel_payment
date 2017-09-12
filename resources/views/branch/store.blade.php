@extends('layouts.app')

	@section('breadcrumb')
		<ul class="breadcrumb">
		    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
		    <li class="active">{!! trans('messages.branch') !!}</li>
		</ul>
	@stop
	
	@section('content')
		<div class="row">
			
@if(Entrust::can('create-company'))
			<div class="col-sm-12 " id="box-detail">
				<div class="box-info">
					<h2><strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.branch') !!}
					<div class="additional-btn">
						
					</div></h2>
					{!! Form::open(['route' => 'branch.store','role' => 'form', 'class'=>'branch-form','id' => 'branch-form']) !!}
						@include('branch._form')
					{!! Form::close() !!}
				</div>
			</div>
			@endif
			
		</div>

	@stop