	@if(count($emails))
		@foreach($emails as $email)
		<tr>
			<td>{{$email->to_address}}
			<td>{{$email->subject}}
			<td>{{showDateTime($email->created_at)}}</td>
			<td>
				<div class="btn-group btn-group-xs">
					<a href="#" data-href="/email/{{$email->id}}" class="btn btn-xs btn-default" data-toggle="modal" data-target="#myModal"> <i class="fa fa-arrow-circle-right" data-toggle="tooltip" title="{{trans('messages.view')}}"></i></a>
				</div>
			</td>
		</tr>
		@endforeach
	@else
		<tr><td colspan="4">{{trans('messages.no_data_found')}}</td></tr>
	@endif