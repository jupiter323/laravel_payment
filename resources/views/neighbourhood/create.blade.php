<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.add_new').' '.trans('messages.neighbourhood') !!}</h4>
	</div>
	<div class="modal-body">
					{!! Form::open(['route' => 'neighbourhood.store','role' => 'form', 'class'=>'neighbourhood-form','id' => 'neighbourhood-form']) !!}
						@include('neighbourhood._form')
					{!! Form::close() !!}
				<div class="clear"></div>
	</div>
