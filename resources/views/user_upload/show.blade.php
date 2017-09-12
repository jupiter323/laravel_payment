
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.customer').' '.trans('messages.upload').' '.trans('messages.log') !!} ({{ trans('messages.upload_rejected').' '.trans('messages.customer') }})</h4>
	</div>
	<div class="modal-body">
		@if(count($user_upload_fails))
			<div class="table-responsive">
				<table class="table table-stripped table-hover table-bordered">
					<thead>
						<tr>
							<th>{{trans('messages.first').' '.trans('messages.date')}}</th>
							<th>{{trans('messages.last').' '.trans('messages.date')}}</th>
							<th>{{trans('messages.username')}}</th>
							<th>{{trans('messages.email')}}</th>
							<th>{{trans('messages.password')}}</th>
							<th>{{trans('messages.date_of_birth')}}</th>
							<th>{{trans('messages.date_of_anniversary')}}</th>
							<th>{{trans('messages.phone')}}</th>
							<th>{{trans('messages.error')}}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($user_upload_fails as $user_upload_fail)
							<tr>
								<td>{{$user_upload_fail->first_name}}</td>
								<td>{{$user_upload_fail->last_name}}</td>
								<td>{{$user_upload_fail->username}}</td>
								<td>{{$user_upload_fail->email}}</td>
								<td>{{$user_upload_fail->password}}</td>
								<td>{{$user_upload_fail->date_of_birth}}</td>
								<td>{{$user_upload_fail->date_of_anniversary}}</td>
								<td>{{$user_upload_fail->phone}}</td>
								<td>{{toWord($user_upload_fail->error)}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		@else
			@include('global.notification',['message' => trans('messages.no_data_found'),'type' => 'danger'])
		@endif
	</div>