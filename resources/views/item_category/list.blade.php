	@if(count($item_categories))
		@foreach($item_categories as $item_category)
		<tr>
			<td>{{$item_category->name}}</td>
			<td>{{toWord($item_category->type)}}</td>
			<td>{{$item_category->description}}</td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/item-category/{{$item_category->id}}/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="{{trans('messages.edit')}}"></i></a>
					{!! delete_form(['item-category.destroy',$item_category->id],['table-refresh' => 'item-category-table'])!!}
				</div>
			</td>
		</tr>
		@endforeach
	@else
		<tr><td colspan="5">{{trans('messages.no_data_found')}}</td></tr>
	@endif