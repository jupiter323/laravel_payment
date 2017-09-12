@extends('layouts.app')

	@section('breadcrumb')
		<ul class="breadcrumb">
		    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
		    <li class="active">{!! trans('messages.custom').' '.trans('messages.field') !!}</li>
		</ul>
	@stop
	
	@section('content')
		<div class="row">
			
			<div class="col-sm-12">
				<div class="box-info full">
					<h2><strong>{!! trans('messages.list_all') !!}</strong> {!! trans('messages.column').' '.trans('messages.field') !!}
					</h2>
					@include('global.datatable',['table' => $table_data['column-table']])
				</div>
			</div>
		</div>
	@stop