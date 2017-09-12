
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.customer').' '.trans('messages.group') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($customer_group,['method' => 'PATCH','route' => ['customer-group.update',$customer_group->id] ,'class' => 'customer-group-edit-form','id' => 'customer-group-edit-form','data-table-refresh' => 'customer-group-table']) !!}
			@include('customer_group._form', ['buttonText' => trans('messages.update')])
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>
