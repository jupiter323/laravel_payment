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

						   <div class="tab-pane animated fadeInRight" id="invoice-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{!! trans('messages.invoice').' '.trans('messages.configuration') !!}</strong></h2>
						    	@include('configuration._invoice_form')
						    </div>
						  </div>
					    </div> 						 
                                        </div>
                                    </div> </div>

	@stop
