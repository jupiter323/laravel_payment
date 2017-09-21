	@if(count($invoices))
		@foreach($invoices as $invoice)
		<tr>
			<td>{{$invoice->invoice_prefix.getInvoiceNumber($invoice)}}</td>
			<td>{{$invoice->Customer->full_name}}</td>
			<td>{{currency($invoice->total,1,$invoice->currency_id)}}</td>
			<td>{{showDate($invoice->date)}}</td>
			<td>{{showDate($invoice->due_date_detail)}}</td>
			<td>
				@include('invoice.status',compact('invoice','size'))
			</td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="/invoice/{{$invoice->uuid}}" class="btn btn-xs btn-default"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="{{trans('messages.view')}}"></i></a>
				</div>
			</td>
		</tr>
		@endforeach
	@else
		<tr><td colspan="7">{{trans('messages.no_data_found')}}</td></tr>
	@endif