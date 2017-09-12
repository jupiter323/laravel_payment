	@if(count($transactions))
		@foreach($transactions as $transaction)
		<tr>
			<td>{{$transaction->token}}</td>
			<td>{{currency($transaction->amount,1,$transaction->currency_id)}}</td>
			<td>{{($transaction->source) ? : ($transaction->PaymentMethod ? $transaction->PaymentMethod->name : '-')}}</td>
			<td>{{showDate($transaction->created_at)}}</td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/transaction/{{$transaction->token}}" class="btn btn-xs btn-default" data-target="#myModal" data-toggle="modal"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="{{trans('messages.view')}}"></i></a>
				</div>
			</td>
		</tr>
		@endforeach
	@else
		<tr><td colspan="7">{{trans('messages.no_data_found')}}</td></tr>
	@endif