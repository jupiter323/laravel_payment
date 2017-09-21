	@if(count($invoice_transactions))
		@foreach($invoice_transactions as $transaction)
		<tr>
			@if(!Entrust::hasRole(config('constant.default_customer_role')))
				<td>{{($transaction->account_id) ? $transaction->Account->name : '-'}}</td>
			@endif
			<td>{{showDate($transaction->date)}}</td>
			<td>{{currency(getAmountWithoutDiscount($transaction->amount,$transaction->coupont_discount),1,$transaction->Currency->id)}}</td>
			<td>{{($transaction->payment_method_id) ? $transaction->PaymentMethod->name : (($transaction->source) ? toWord($transaction->source) : '')}}</td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/invoice-transaction/{{$transaction->id}}/show" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="{{trans('messages.view')}}"></i></a>

					@if(!Entrust::hasRole(config('constant.default_customer_role')) && $transaction->source == null)
						<a href="#" data-href="/invoice-transaction/{{$transaction->id}}/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="{{trans('messages.edit')}}"></i></a>
						{!! delete_form(['transaction.destroy',$transaction->id],['table-refresh' => 'invoice-payment-table','refresh-content' => 'load-invoice-status'])!!}
					@endif

					@if(!Entrust::hasRole(config('constant.default_customer_role')) && $transaction->source != null)
						<a href="#" data-href="/invoice-transaction/{{$transaction->id}}/withdraw" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-download" data-toggle="tooltip" title="{{trans('messages.withdraw').' '.trans('messages.payment')}}"></i></a>
					@endif
				</div>
			</td>
		</tr>
		@endforeach
		<tr>
			<th>{{trans('messages.total').' '.trans('messages.paid')}}</th>
			<th colspan="4">{{currency($total_paid,1,$transaction->Currency->id)}}</th>
		</tr>
		<tr>
			<th>{{trans('messages.balance')}}</th>
			<th colspan="4">{{currency(($invoice->total-$total_paid),1,$transaction->Currency->id)}}</th>
		</tr>
	@else
		<tr><td colspan="5">{{trans('messages.no_data_found')}}</td></tr>
	@endif