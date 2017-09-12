
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.campaign').' '.trans('messages.detail') !!}</h4>
	</div>
	<div class="modal-body">
		<div class="row">	
			<div class="col-md-4">
				<h4>{{trans('messages.recipients')}}</h4>
				<div class="custom-scrollbar">
					@foreach(explode(',',$campaign->recipients) as $recipient)
						{{$recipient}} <br />
					@endforeach
				</div>
			</div>	
			<div class="col-md-4">
				<h4>{{trans('messages.inclusion')}}</h4>
				<div class="custom-scrollbar">
					@foreach(explode(',',$campaign->inclusion) as $inclusion)
						{{$inclusion}} <br />
					@endforeach
				</div>
			</div>	
			<div class="col-md-4">
				<h4>{{trans('messages.exclusion')}}</h4>
				<div class="custom-scrollbar">
					@foreach(explode(',',$campaign->exclusion) as $exclusion)
						{{$exclusion}} <br />
					@endforeach
				</div>
			</div>
		</div>

		<hr />
		{!! $campaign->body !!}
		<div class="clear"></div>
	</div>