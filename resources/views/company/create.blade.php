<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.add_new').' '.trans('messages.company') !!}</h4>
	</div>
	<div class="modal-body">
					{!! Form::open(['route' => 'company.store','role' => 'form', 'class'=>'company-form','id' => 'company-form']) !!}
						@include('company._form')
					{!! Form::close() !!}
				<div class="clear"></div>
	</div>
