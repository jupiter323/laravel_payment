
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.taxation') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($taxation,['method' => 'PATCH','route' => ['taxation.update',$taxation->id] ,'class' => 'taxation-edit-form','id' => 'taxation-edit-form','data-table-refresh' => 'taxation-table']) !!}
			@include('taxation._form', ['buttonText' => trans('messages.update')])
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>
