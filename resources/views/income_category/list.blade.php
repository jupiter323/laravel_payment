	@if(count($income_categories))
		@foreach($income_categories as $income_category)
		<tr>
			<td>{{$income_category->name}}</td>
			<td>{{$income_category->description}}</td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/income-category/{{$income_category->id}}/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="{{trans('messages.edit')}}"></i></a>
					{!! delete_form(['income-category.destroy',$income_category->id],['table-refresh' => 'income-category-table'])!!}
				</div>
			</td>
		</tr>
		@endforeach
	@else
		<tr><td colspan="5">{{trans('messages.no_data_found')}}</td></tr>
	@endif