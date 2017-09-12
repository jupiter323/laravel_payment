
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.'.$type) !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($transaction,['method' => 'PATCH','route' => ['transaction.update',$transaction] ,'class' => 'transaction-edit-form','id' => 'transaction-edit-form','data-disable-enter-submission' => 1,'data-file-upload' => '.file-uploader']) !!}
			@include('transaction._form', ['buttonText' => trans('messages.update')])
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>