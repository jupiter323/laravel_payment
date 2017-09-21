
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.add_new').' '.trans('messages.taxation') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::open(['route' => 'taxation.store','class'=>'taxation-form','id' => 'taxation-form','data-table-refresh' => 'taxation-table']) !!}
			@include('taxation._form')
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>
