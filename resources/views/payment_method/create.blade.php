	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.add_new').' '.trans('messages.payment').' '.trans('messages.method') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::open(['route' => 'payment-method.store','class'=>'payment_method-form','id' => 'payment_method-form','data-table-refresh' => 'payment_method-table']) !!}
			@include('payment_method._form')
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>
