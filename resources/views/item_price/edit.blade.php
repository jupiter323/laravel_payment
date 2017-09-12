
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.item').' '.trans('messages.price') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($item_price,['method' => 'PATCH','route' => ['item-price.update',$item_price] ,'class' => 'item-price-edit-form','id' => 'item-price-edit-form']) !!}
			@include('item_price._form', ['buttonText' => trans('messages.update')])
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>