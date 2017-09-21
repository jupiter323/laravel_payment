@extends('layouts.app')

	@section('breadcrumb')
		<ul class="breadcrumb">
		    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
		    <li><a href="/user/customer">{!! trans('messages.customer') !!}</a></li>
		    <li class="active">{!! trans('messages.customer').' '.trans('messages.upload') !!}</li>
		</ul>
	@stop
	
	@section('content')
		<div class="row">
			<div class="col-md-5">
				<div class="box-info">
					<h2><strong>Select Column</strong></h2>
					{!! Form::open(['route' => 'user.upload','role' => 'form', 'class'=>'form-horizontal upload-customer-form','id' => 'upload-customer-form']) !!}
						<div class="form-group">
						    {!! Form::label('0','Column A',['class' => 'col-sm-4 control-label'])!!}
						    <div class="col-sm-8">
								{!! Form::select('0', $columns,'first_name',['class'=>'form-control show-tick','title' => trans('messages.select_one')])!!}
							</div>
						</div>
						<div class="form-group">
						    {!! Form::label('1','Column B',['class' => 'col-sm-4 control-label'])!!}
						    <div class="col-sm-8">
								{!! Form::select('1', $columns,'last_name',['class'=>'form-control show-tick','title' => trans('messages.select_one')])!!}
							</div>
						</div>
						<div class="form-group">
						    {!! Form::label('2','Column C',['class' => 'col-sm-4 control-label'])!!}
						    <div class="col-sm-8">
								{!! Form::select('2', $columns,'username',['class'=>'form-control show-tick','title' => trans('messages.select_one')])!!}
							</div>
						</div>
						<div class="form-group">
						    {!! Form::label('3','Column D',['class' => 'col-sm-4 control-label'])!!}
						    <div class="col-sm-8">
								{!! Form::select('3', $columns,'email',['class'=>'form-control show-tick','title' => trans('messages.select_one')])!!}
							</div>
						</div>
						<div class="form-group">
						    {!! Form::label('4','Column E',['class' => 'col-sm-4 control-label'])!!}
						    <div class="col-sm-8">
								{!! Form::select('4', $columns,'password',['class'=>'form-control show-tick','title' => trans('messages.select_one')])!!}
							</div>
						</div>
						<div class="form-group">
						    {!! Form::label('5','Column F',['class' => 'col-sm-4 control-label'])!!}
						    <div class="col-sm-8">
								{!! Form::select('5', $columns,'date_of_birth',['class'=>'form-control show-tick','title' => trans('messages.select_one')])!!}
							</div>
						</div>
						<div class="form-group">
						    {!! Form::label('6','Column G',['class' => 'col-sm-4 control-label'])!!}
						    <div class="col-sm-8">
								{!! Form::select('6', $columns,'date_of_anniversary',['class'=>'form-control show-tick','title' => trans('messages.select_one')])!!}
							</div>
						</div>
						<div class="form-group">
						    {!! Form::label('7','Column H',['class' => 'col-sm-4 control-label'])!!}
						    <div class="col-sm-8">
								{!! Form::select('7', $columns,'phone',['class'=>'form-control show-tick','title' => trans('messages.select_one')])!!}
							</div>
						</div>
						{!! Form::submit(trans('messages.upload'),['class' => 'btn btn-primary pull-right']) !!}
					{!! Form::close() !!}
				</div>
			</div>
			<div class="col-md-7">
				<div class="box-info">
					<h2><strong>Uploaded File Preview (Max 5 rows)</strong></h2>
					<div class="table-responsive">
						<table data-sortable class="table table-hover table-striped table-bordered">
							<thead>
								<tr>
									<th>Column A</th>
									<th>Column B</th>
									<th>Column C</th>
									<th>Column D</th>
									<th>Column E</th>
									<th>Column F</th>
									<th>Column G</th>
									<th>Column H</th>
								</tr>
							</thead>
							<tbody>
								@foreach($xls_datas as $xls_data)
									<tr>
										<td>{{$xls_data['a']}}</td>
										<td>{{$xls_data['b']}}</td>
										<td>{{$xls_data['c']}}</td>
										<td>{{$xls_data['d']}}</td>
										<td>{{$xls_data['e']}}</td>
										<td>{{$xls_data['f']}}</td>
										<td>{{$xls_data['g']}}</td>
										<td>{{$xls_data['h']}}</td>
									</tr>
								@endforeach
								<tr>
									<td colspan="7"> ....</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	@stop