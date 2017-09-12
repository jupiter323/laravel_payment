@extends('layouts.app')

	@section('breadcrumb')
		<ul class="breadcrumb">
		    <li><a href="/home">{!! trans('messages.home') !!}</a></li>
		    <li class="active">{!! trans('messages.configuration') !!}</li>
		</ul>
	@stop
	
	@section('content')
           <div class="row">
			<div class="col-sm-12">
				<div class="box-info full">
				       	 <div class="tab-content col-md-12 col-xs-12" style="padding:0px 25px 10px 25px;">

						 <div class="tab-pane animated fadeInRight" id="currency-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{!! trans('messages.currency').' '.trans('messages.configuration') !!}</strong></h2>
						    	<div class="row">
									<div class="col-sm-4">
										<div class="box-info">
											<h2><strong>{!! trans('messages.add_new') !!}</strong> {!! trans('messages.currency') !!} </h2>
											{!! Form::open(['route' => 'currency.store','class'=>'currency-form','id' => 'currency-form','data-table-refresh' => 'currency-table']) !!}
												@include('currency._form')
											{!! Form::close() !!}
										</div>
									</div>
									<div class="col-sm-8">
										<div class="box-info full">
											<h2><strong>{!! trans('messages.list_all').'</strong> '.trans('messages.currency') !!} </h2>
											<div class="table-responsive">
												<table data-sortable class="table table-hover table-striped ajax-table show-table" id="currency-table" data-source="/currency/lists">
													<thead>
														<tr>
															<th>{!! trans('messages.name') !!}</th>
															<th>{!! trans('messages.symbol') !!}</th>
															<th>{!! trans('messages.position') !!}</th>
															<th>{!! trans('messages.decimal') !!}</th>
															<th>{!! trans('messages.default') !!}</th>
															<th data-sortable="false">{!! trans('messages.option') !!}</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
										</div>
										<div class="box-info">
											<h2><strong>Note</strong></h2>
											<div class="the-notes success" style="text-align:justify;">
												Choose default currency carefully, do not change default currency after making any transaction. Your calculation may go wrong if you change default currency after making transaction.
											</div>
										</div>
									</div>
								</div>
						    </div>
						  </div>
					    </div> 						 
                                        </div>
                                    </div> </div>

	@stop
