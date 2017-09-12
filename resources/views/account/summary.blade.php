	@if(count($data))
		@foreach($data as $value)
		<tr>
			<td>{{$value['name']}}</td>
			<td>{{$value['type']}}</td>
			<td>{{$value['last_transaction_date']}}</td>
			<td>{{$value['balance']}}</td>
		</tr>
		@endforeach
	@else
		<tr><td colspan="4">{{trans('messages.no_data_found')}}</td></tr>
	@endif