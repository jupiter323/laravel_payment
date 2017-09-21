
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.payment').' '.trans('messages.method') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($payment_method,['method' => 'PATCH','route' => ['payment-method.update',$payment_method->id] ,'class' => 'payment-method-edit-form','id' => 'payment-method-edit-form','data-table-refresh' => 'payment-method-table']) !!}
			@include('payment_method._form', ['buttonText' => trans('messages.update')])
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>
