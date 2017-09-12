
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.payment') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($transaction,['method' => 'POST','route' => ['invoice.update-payment',$transaction] ,'class' => 'invoice-payment-edit-form','id' => 'invoice-payment-edit-form','files' => true,'data-table-refresh' => 'invoice-payment-table','data-refresh' => 'load-invoice-status','data-file-upload' => '.file-uploader']) !!}
			@include('invoice._payment_form', ['buttonText' => trans('messages.update')])
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>