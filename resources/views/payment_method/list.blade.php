	@if(count($payment_methods))
		@foreach($payment_methods as $payment_method)
		<tr>
			<td>{{$payment_method->name}}</td>
			<td>{{toWord($payment_method->type)}}</td>
			<td>{{$payment_method->description}}</td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/payment-method/{{$payment_method->id}}/edit" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-edit" data-toggle="tooltip" title="{{trans('messages.edit')}}"></i></a>
					{!! delete_form(['payment-method.destroy',$payment_method->id],['table-refresh' => 'payment-method-table'])!!}
				</div>
			</td>
		</tr>
		@endforeach
	@else
		<tr><td colspan="5">{{trans('messages.no_data_found')}}</td></tr>
	@endif