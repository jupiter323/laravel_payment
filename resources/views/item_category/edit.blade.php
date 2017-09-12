
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.item').' '.trans('messages.category') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($item_category,['method' => 'PATCH','route' => ['item-category.update',$item_category->id] ,'class' => 'item-category-edit-form','id' => 'item-category-edit-form','data-table-refresh' => 'item-category-table']) !!}
			@include('item_category._form', ['buttonText' => trans('messages.update')])
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>
