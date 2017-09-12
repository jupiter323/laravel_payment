
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.expense').' '.trans('messages.category') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($expense_category,['method' => 'PATCH','route' => ['expense-category.update',$expense_category->id] ,'class' => 'expense-category-edit-form','id' => 'expense-category-edit-form','data-table-refresh' => 'expense-category-table']) !!}
			@include('expense_category._form', ['buttonText' => trans('messages.update')])
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>
