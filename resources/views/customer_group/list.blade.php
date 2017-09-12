	@if(count($customer_groups))
		@foreach($customer_groups as $customer_group)
		<tr>
			<td>{{$customer_group->name}}</td>
			<td>{{$customer_group->description}}</td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/customer-group/{{$customer_group->id}}/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="{{trans('messages.edit')}}"></i></a>
					{!! delete_form(['customer-group.destroy',$customer_group->id],['table-refresh' => 'customer-group-table'])!!}
				</div>
			</td>
		</tr>
		@endforeach
	@else
		<tr><td colspan="5">{{trans('messages.no_data_found')}}</td></tr>
	@endif