	@if(count($expense_categories))
		@foreach($expense_categories as $expense_category)
		<tr>
			<td>{{$expense_category->name}}</td>
			<td>{{$expense_category->description}}</td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/expense-category/{{$expense_category->id}}/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="{{trans('messages.edit')}}"></i></a>
					{!! delete_form(['expense-category.destroy',$expense_category->id],['table-refresh' => 'expense-category-table'])!!}
				</div>
			</td>
		</tr>
		@endforeach
	@else
		<tr><td colspan="5">{{trans('messages.no_data_found')}}</td></tr>
	@endif