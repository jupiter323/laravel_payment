        @if($quotation->is_cancelled)
            <span class="label lb-{{$size}} label-danger">{{trans('messages.invoice_cancelled')}}</span>
        @elseif($quotation->status == 'draft')
            <span class="label lb-{{$size}} label-primary">{{trans('messages.invoice_draft')}}</span>
        @elseif($quotation->status == 'sent' && $quotation->expiry_date > date('Y-m-d'))
            <span class="label lb-{{$size}} label-info">{{trans('messages.invoice_sent')}}</span>
        @elseif($quotation->status == 'sent' && $quotation->expiry_date < date('Y-m-d'))
            <span class="label lb-{{$size}} label-danger">{{trans('messages.expired')}}</span>
        @elseif($quotation->status == 'accepted')
            <span class="label lb-{{$size}} label-success">{{trans('messages.quotation_accepted')}}</span>
        @elseif($quotation->status == 'invoice')
            <span class="label lb-{{$size}} label-success">{{trans('messages.quotation_converted')}}</span>
        @elseif($quotation->status == 'rejected')
            <span class="label lb-{{$size}} label-danger">{{trans('messages.quotation_rejected')}}</span>
        @elseif($quotation->status == 'dead')
            <span class="label lb-{{$size}} label-danger">{{trans('messages.quotation_dead')}}</span>
        @endif
        