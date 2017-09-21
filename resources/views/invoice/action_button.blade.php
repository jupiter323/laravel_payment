
@if(!Entrust::hasRole(config('constant.default_customer_role')))
	<div class="btn-group">
		<a href="/invoice/{{$invoice->uuid}}/edit" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> {{trans('messages.edit')}}</a>

		@if(!$invoice->is_cancelled)
			<a data-toggle="collapse" data-target="#recurring-detail" class="btn btn-sm btn-danger"><i class="fa fa-repeat"></i> {{trans('messages.recurring')}}</a>
			<a data-toggle="collapse" data-target="#payment-detail" class="btn btn-sm btn-success"><i class="fa fa-money"></i> {{trans('messages.payment')}}</a>
		@endif
		<a href="/invoice/{{$invoice->uuid}}/preview" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-print"></i> {{trans('messages.print')}}</a>
		<a href="/invoice/{{$invoice->uuid}}/pdf" class="btn btn-sm btn-info"><i class="fa fa-file-pdf-o"></i> {{trans('messages.pdf')}}</a>
		
		@if($invoice->is_cancelled)
			<a href="#" data-ajax="1" data-extra="&invoice_id={{$invoice->id}}" data-source="/invoice/undo/cancel" data-refresh="load-invoice-action-button,load-invoice-status" class="click-alert-message btn btn-sm btn-default"><i class="fa fa-undo"></i> {{trans('messages.undo').' '.trans('messages.cancel').' '.trans('messages.invoice')}}</a>
		@endif
	</div>

	@if(!$invoice->is_cancelled)
		<div class="btn-group">
			<div class="btn-group">
				<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-envelope"></i> {{trans('messages.send').' '.trans('messages.email')}} <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#" data-ajax="1" data-extra="&invoice_id={{$invoice->id}}&email=send-invoice" data-source="/invoice/email" data-refresh="load-invoice-action-button,load-invoice-status" class="click-alert-message">{{trans('messages.send').' '.trans('messages.invoice')}}</a></li>
					@if($invoice->payment_status != 'paid' && $invoice->status == 'sent')
						<li><a href="#" data-ajax="1" data-extra="&invoice_id={{$invoice->id}}&email=invoice-payment-reminder" data-source="/invoice/email" data-refresh="load-invoice-action-button" class="click-alert-message">{{trans('messages.invoice').' '.trans('messages.payment').' '.trans('messages.reminder')}}</a></li>
						@if($invoice->due_date_detail)
							<li><a href="#" data-ajax="1" data-extra="&invoice_id={{$invoice->id}}&email=invoice-overdue" data-source="/invoice/email" data-refresh="load-invoice-action-button" class="click-alert-message">{{trans('messages.invoice').' 
						'.trans('messages.overdue')}}</a></li>
						@endif
					@endif
					<li class="divider"></li>
					<li><a href="#" data-href="/invoice/{{$invoice->uuid}}/custom-email" data-toggle="modal" data-target="#myModal">{{trans('messages.custom').' '.trans('messages.invoice').' '.trans('messages.email')}}</a></li>
				</ul>
			</div>
			<div class="btn-group">
				<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-toggle-right"></i> {{trans('messages.more')}} <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					@if($invoice->status == 'draft')
						<li><a href="#" data-ajax="1" data-extra="&invoice_id={{$invoice->id}}" data-source="/invoice/mark-as-sent" data-refresh="load-invoice-action-button,load-invoice-status" class="click-alert-message"><i class="fa fa-send"></i> {{trans('messages.mark').' '.trans('messages.invoice_sent')}}</a></li>
					@endif
					<li><a href="#" data-ajax="1" data-extra="&invoice_id={{$invoice->id}}" data-source="/invoice/cancel" data-refresh="load-invoice-action-button,load-invoice-status" class="click-alert-message">
					<i class="fa fa-times"></i> {{trans('messages.cancel').' '.trans('messages.invoice')}}</a></li>
					<li><a href="#" data-ajax="1" data-extra="&invoice_id={{$invoice->id}}" data-source="/invoice/copy" class="click-alert-message"><i class="fa fa-copy"></i> {{trans('messages.copy').' '.trans('messages.invoice')}}</a></li>
					@if($invoice->enable_partial_payment)
						<li><a href="#" data-ajax="1" data-extra="&invoice_id={{$invoice->id}}&action=disable" data-source="/invoice/partial-payment" class="click-alert-message" data-refresh="load-invoice-action-button"><i class="fa fa-money"></i> {{trans('messages.disable').' '.trans('messages.partial').' '.trans('messages.payment')}}</a></li>
					@else
						<li><a href="#" data-ajax="1" data-extra="&invoice_id={{$invoice->id}}&action=enable" data-source="/invoice/partial-payment" class="click-alert-message" data-refresh="load-invoice-action-button"><i class="fa fa-money"></i> {{trans('messages.enable').' '.trans('messages.partial').' '.trans('messages.payment')}}</a></li>
					@endif
				</ul>
			</div>
		</div>
	@endif


	@if($invoice->is_recurring)
	<span class="label label-sm label-danger"><i class="fa fa-repeat"></i> {{trans('messages.recurring')}}</span>
	@endif

	<span class="pull-right">
		<a data-toggle="collapse" data-target="#email-detail" class="btn btn-sm btn-success"><i class="fa fa-envelope"></i> {{trans('messages.email').' '.trans('messages.log')}}</a>
		<a href="/invoice/create" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> {{trans('messages.new').' '.trans('messages.invoice')}}</a>
		{!! delete_form(['invoice.destroy',$invoice->id],['label' => trans('messages.delete'),'size' => 'sm','redirect' => '/invoice']) !!}
	</span>
@elseif(Entrust::hasRole(config('constant.default_customer_role')) && config('config.enable_customer_payment'))
	<div class="btn-group">
		<a data-toggle="collapse" data-target="#customer-payment-detail"  class="btn btn-sm btn-primary"><i class="fa fa-money"></i> {{trans('messages.payment')}} </a>
	</div>
@endif