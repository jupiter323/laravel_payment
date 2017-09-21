	@if(count($taxations))
		@foreach($taxations as $taxation)
		<tr>
			<td>{{$taxation->name}}</td>
			<td>{{round($taxation->value,5)}}</td>
			<td>{{$taxation->description}}</td>
			<td>{!! ($taxation->is_default) ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>' !!}</td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/taxation/{{$taxation->id}}/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="{{trans('messages.edit')}}"></i></a>
					{!! delete_form(['taxation.destroy',$taxation->id],['table-refresh' => 'taxation-table'])!!}
				</div>
			</td>
		</tr>
		@endforeach
	@else
		<tr><td colspan="5">{{trans('messages.no_data_found')}}</td></tr>
	@endif