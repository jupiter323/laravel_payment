	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.add_new').' '.trans('messages.doc_type') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::open(['route' => 'document.store','class'=>'document-form','id' => 'document-form','data-table-refresh' => 'document-table']) !!}
			@include('document._form')
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>
