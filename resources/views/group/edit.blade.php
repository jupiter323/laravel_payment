
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.company') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($company,['method' => 'PATCH','route' => ['company.update',$company] ,'class' => 'company-edit-form','id' => 'company-edit-form']) !!}
			@include('company._form', ['buttonText' => trans('messages.update')])
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>