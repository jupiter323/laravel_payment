@if(!Entrust::hasRole(config('constant.default_customer_role')))
	<div class="btn-group">
		<a href="/quotation/{{$quotation->uuid}}/edit" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> {{trans('messages.edit')}}</a>

		<a href="/quotation/{{$quotation->uuid}}/preview" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-print"></i> {{trans('messages.print')}}</a>
		<a href="/quotation/{{$quotation->uuid}}/pdf" class="btn btn-sm btn-info"><i class="fa fa-file-pdf-o"></i> {{trans('messages.pdf')}}</a>
		
		@if($quotation->is_cancelled)
			<a href="#" data-ajax="1" data-extra="&quotation_id={{$quotation->id}}" data-source="/quotation/undo/cancel" data-refresh="load-quotation-action-button,load-quotation-status" class="click-alert-message btn btn-sm btn-default"><i class="fa fa-undo"></i> {{trans('messages.undo').' '.trans('messages.cancel').' '.trans('messages.quotation')}}</a>
		@endif
		
		<a data-toggle="collapse" data-target="#quotation-discussion" class="btn btn-sm btn-primary"><i class="fa fa-chat"></i> {{trans('messages.discussion')}}</a>
	</div>

	@if(!$quotation->is_cancelled)
		<div class="btn-group">
			<div class="btn-group">
				<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-envelope"></i> {{trans('messages.send').' '.trans('messages.email')}} <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="#" data-ajax="1" data-extra="&quotation_id={{$quotation->id}}&email=send-quotation" data-source="/quotation/email" data-refresh="load-quotation-action-button" class="click-alert-message">{{trans('messages.send').' '.trans('messages.quotation')}}</a></li>
					@if($quotation->status != 'invoice' && $quotation->status != 'dead')
						<li><a href="#" data-ajax="1" data-extra="&quotation_id={{$quotation->id}}&email=quotation-reminder" data-source="/quotation/email" data-refresh="load-quotation-action-button" class="click-alert-message">{{trans('messages.quotation').' '.trans('messages.reminder')}}</a></li>
						@if($quotation->expiry_date < date('Y-m-d'))
							<li><a href="#" data-ajax="1" data-extra="&quotation_id={{$quotation->id}}&email=quotation-expired" data-source="/quotation/email" data-refresh="load-quotation-action-button" class="click-alert-message">{{trans('messages.quotation').' 
						'.trans('messages.expired')}}</a></li>
						@endif
					@endif
					<li class="divider"></li>
					<li><a href="#" data-href="/quotation/{{$quotation->uuid}}/custom-email" data-toggle="modal" data-target="#myModal">{{trans('messages.custom').' '.trans('messages.quotation').' '.trans('messages.email')}}</a></li>
				</ul>
			</div>
			<div class="btn-group">
				<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-toggle-right"></i> {{trans('messages.more')}} <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					@if($quotation->status == 'draft')
						<li><a href="#" data-ajax="1" data-extra="&quotation_id={{$quotation->id}}" data-source="/quotation/mark-as-sent" data-refresh="load-quotation-action-button,load-quotation-status" class="click-alert-message"><i class="fa fa-send"></i> {{trans('messages.mark').' '.trans('messages.invoice_sent')}}</a></li>
					@endif
					@if($quotation->expiry_date < date('Y-m-d') && $quotation->status == 'sent')
						<li><a href="#" data-ajax="1" data-extra="&quotation_id={{$quotation->id}}" data-source="/quotation/mark-as-dead" data-refresh="load-quotation-action-button,load-quotation-status" class="click-alert-message"><i class="fa fa-send"></i> {{trans('messages.mark').' '.trans('messages.as').' '.trans('messages.quotation_dead')}}</a></li>
					@endif
					@if(!$quotation->is_cancelled && ($quotation->status == 'sent' || $quotation->status == 'accepted'))
						<li><a href="#" data-ajax="1" data-extra="&quotation_id={{$quotation->id}}" data-source="/quotation/convert" data-refresh="load-quotation-action-button,load-quotation-status" class="click-alert-message">
						<i class="fa fa-list-alt"></i> {{trans('messages.convert').' '.trans('messages.into').' '.trans('messages.invoice')}}</a></li>
					@endif
					<li><a href="#" data-ajax="1" data-extra="&quotation_id={{$quotation->id}}" data-source="/quotation/cancel" data-refresh="load-quotation-action-button,load-quotation-status" class="click-alert-message">
					<i class="fa fa-times"></i> {{trans('messages.cancel').' '.trans('messages.quotation')}}</a></li>
					<li><a href="#" data-ajax="1" data-extra="&quotation_id={{$quotation->id}}" data-source="/quotation/copy" class="click-alert-message"><i class="fa fa-copy"></i> {{trans('messages.copy').' '.trans('messages.quotation')}}</a></li>
				</ul>
			</div>
		</div>
	@endif

	<span class="pull-right">
		<a data-toggle="collapse" data-target="#email-detail" class="btn btn-sm btn-success"><i class="fa fa-envelope"></i> {{trans('messages.email').' '.trans('messages.log')}}</a>
		<a href="/quotation/create" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> {{trans('messages.new').' '.trans('messages.quotation')}}</a>
		{!! delete_form(['quotation.destroy',$quotation->id],['label' => trans('messages.delete'),'size' => 'sm','redirect' => '/quotation']) !!}
	</span>
@else
	<div class="btn-group">
		@if($quotation->status == 'sent' || $quotation->status == 'rejected')
		<a href="#" data-ajax="1" data-extra="&quotation_id={{$quotation->id}}&action=accept" data-source="/quotation/customer-action" data-refresh="load-quotation-action-button,load-quotation-status" class="click-alert-message btn btn-success"><i class="fa fa-thumbs-up"></i> {{trans('messages.accept')}}</a>
		@endif

		@if($quotation->status == 'sent' || $quotation->status == 'accepted')
		<a href="#" data-ajax="1" data-extra="&quotation_id={{$quotation->id}}&action=reject" data-source="/quotation/customer-action" data-refresh="load-quotation-action-button,load-quotation-status" class="click-alert-message btn btn-danger"><i class="fa fa-thumbs-down"></i> {{trans('messages.reject')}}</a>
		@endif

		<a data-toggle="collapse" data-target="#quotation-discussion" class="btn btn-primary"><i class="fa fa-chat"></i> {{trans('messages.discussion')}}</a>
	</div>
@endif