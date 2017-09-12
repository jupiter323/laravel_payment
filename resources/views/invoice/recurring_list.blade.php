	@if(count($invoice->RecurringInvoice) || $invoice->next_recurring_date)
		@foreach($invoice->RecurringInvoice as $recurring_invoice)
		<tr>
			<td>{{showDate($recurring_invoice->date)}}</td>
			<td>{{toWord($recurring_invoice->status)}}</td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="/invoice/{{$recurring_invoice->uuid}}" class="btn btn-xs btn-default"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="{{trans('messages.view')}}"></i></a>
				</div>
			</td>
		</tr>
		@endforeach
		@if($invoice->next_recurring_date)
			<tr>
			<td>{{showDate($invoice->next_recurring_date)}} ({{trans('pagination.next').' '.trans('messages.recurring').' '.trans('messages.date')}})</td>
			<td><span class="label label-info">{{trans('messages.pending')}}</span></td>
			<td>-</td>
		</tr>
		@endif
	@else
		<tr><td colspan="3">{{trans('messages.no_data_found')}}</td></tr>
	@endif