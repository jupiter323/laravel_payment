
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.account') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($account,['method' => 'PATCH','route' => ['account.update',$account] ,'class' => 'account-edit-form','id' => 'account-edit-form']) !!}
			@include('account._form', ['buttonText' => trans('messages.update')])
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>