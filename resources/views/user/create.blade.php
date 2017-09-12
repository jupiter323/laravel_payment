         <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.add_new').' '.trans('messages.customers') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::open(['route' => 'register','role' => 'form', 'class'=>'user-form','id' => 'user-form']) !!}						@include('user._form')					{!! Form::close() !!}	
		<div class="clear"></div>
	</div>
