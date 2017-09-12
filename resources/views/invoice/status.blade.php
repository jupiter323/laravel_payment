        @if($invoice->is_cancelled)
            <span class="label lb-{{$size}} label-danger">{{trans('messages.invoice_cancelled')}}</span>
        @elseif($invoice->status == 'draft')
            <span class="label lb-{{$size}} label-primary">{{trans('messages.invoice_draft')}}</span>
        @elseif($invoice->status == 'sent')
        	@if($invoice->payment_status == 'unpaid' || $invoice->payment_status == null)
        		<span class="label lb-{{$size}} label-danger">{{trans('messages.unpaid')}}</span>
        	@elseif($invoice->payment_status == 'partially_paid')
        		<span class="label lb-{{$size}} label-warning">{{trans('messages.partially_paid')}}</span>
        	@elseif($invoice->payment_status == 'paid')
        		<span class="label lb-{{$size}} label-success">{{trans('messages.paid')}}</span>
            @endif

        	@if($invoice->payment_status != 'paid' && $invoice->due_date != 'no_due_date' && $invoice->due_date_detail < date('Y-m-d'))
        		<span class="label lb-{{$size}} label-danger">{{trans('messages.overdue')}}</span>
            @endif
        @endif