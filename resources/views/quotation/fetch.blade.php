	@if(count($quotations))
		@foreach($quotations as $quotation)
		<tr>
			<td>{{$quotation->quotation_prefix.getQuotationNumber($quotation)}}</td>
			<td>{{$quotation->Customer->full_name}}</td>
			<td>{{currency($quotation->total,1,$quotation->currency_id)}}</td>
			<td>{{showDate($quotation->date)}}</td>
			<td>{{showDate($quotation->expiry_date)}}</td>
			<td>
				@include('quotation.status',compact('quotation','size'))
			</td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="/quotation/{{$quotation->uuid}}" class="btn btn-xs btn-default"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="{{trans('messages.view')}}"></i></a>
				</div>
			</td>
		</tr>
		@endforeach
	@else
		<tr><td colspan="7">{{trans('messages.no_data_found')}}</td></tr>
	@endif