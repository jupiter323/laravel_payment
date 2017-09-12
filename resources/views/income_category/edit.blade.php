
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.income').' '.trans('messages.category') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($income_category,['method' => 'PATCH','route' => ['income-category.update',$income_category->id] ,'class' => 'income-category-edit-form','id' => 'income-category-edit-form','data-table-refresh' => 'income-category-table']) !!}
			@include('income_category._form', ['buttonText' => trans('messages.update')])
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>
