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

						 <div class="tab-pane animated fadeInRight" id="menu-tab">
						    <div class="user-profile-content-wm">
						    	<h2><strong>{{ trans('messages.menu') }}</strong> {{ trans('messages.configuration') }}</h2>
						    	{!! Form::open(['route' => 'configuration.menu','role' => 'form', 'class'=>'config-menu-form','id' => 'config-menu-form','data-draggable' => 1,'data-no-form-clear' => 1,'data-sidebar' => 1]) !!}
								<div class="draggable-container">
									<?php $i = 0; ?>
									@foreach(\App\Menu::orderBy('order')->orderBy('id')->get() as $menu_item)
										<?php $i++; ?>
									  <div class="draggable" data-name="{{$menu_item->name}}" data-index="{{$i}}">
									    <p><input type="checkbox" class="icheck" name="{{$menu_item->name}}-visible" value="1" {{($menu_item->visible) ? 'checked' : ''}}> <span style="margin-left:50px;">{{toWord($menu_item->name)}}</span></p>
									  </div>
									@endforeach
								</div>
								{!! Form::hidden('config_type','menu')!!}
			  					{!! Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
								{!! Form::close() !!}
						    </div>
						  </div>
					    </div> 						 
                                        </div>
                                    </div> </div>

	@stop
