
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.item') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($item,['method' => 'PATCH','route' => ['item.update',$item] ,'class' => 'item-edit-form','id' => 'item-edit-form']) !!}
			@include('item._form', ['buttonText' => trans('messages.update')])
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>