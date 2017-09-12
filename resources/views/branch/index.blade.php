@extends('layouts.app')

	@section('breadcrumb')
		<ul class="breadcrumb">
		    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
		    <li class="active">{!! trans('messages.branch') !!}</li>
		</ul>
	@stop
	
	@section('content')
		<div class="row">
			

			<div class="col-sm-12">
				<div class="box-info full">
					<h2><strong>{!! trans('messages.list_all') !!}</strong> {!! trans('messages.branch') !!}</h2>
					<div class="additional-btn">
						@if(Entrust::can('create-company'))
							<a href="/branch/add"><button class="btn btn-sm btn-primary"><i class="fa fa-plus icon"></i> {!! trans('messages.add_new') !!}</button></a>
						@endif
					</div>
					@include('global.datatable',['table' => $table_data['branch-table']])
				</div>
			</div>
		</div>

	@stop