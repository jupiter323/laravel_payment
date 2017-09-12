
		<div class="row">
			<div class="col-xs-12">
				<div class="box-info">
					<div class="invoice">
			            <div class="row invoice-logo">
			                <div class="col-xs-6 invoice-logo-space">
							    {!! getCompanyLogo()  !!}
			                </div>
			                <div class="col-xs-6">
			                    <p class="pull-right text-right" style="font-size:14px;"> 
			                    	{!!($quotation->reference_number) ? (trans('messages.reference').' '.trans('messages.number').' : <strong>'.$quotation->reference_number.'</strong>') : ''!!} <br /> 
			                    	{!!trans('messages.quotation').' '.trans('messages.date').' : <strong>'.showDate($quotation->date)!!}</strong> <br />
			                        <span class="muted"> {{trans('messages.quotation').' '.trans('messages.number')}} : <strong> {{$quotation->quotation_prefix.getQuotationNumber($quotation)}}</strong></span><br />
			                        <span class="muted">{{trans('messages.expiry').' '.trans('messages.date')}} : <strong>{{showDate($quotation->expiry_date)}}</strong></span>
			                    </p>
			                </div>
			            </div>
			            <hr/>
			            <div class="row">
			            	<div class="col-xs-12">
			                	<div class="pull-right" id="load-quotation-status" data-extra="&quotation_id={{$quotation->id}}" data-source="/quotation-status"></div>
			                </div>

			                <div class="col-xs-4">
			                    <h3>{{trans('messages.company').' '.trans('messages.detail')}}</h3>
			                    <ul class="list-unstyled">
			                        <li style="font-size:16px; font-weight:bold;"> {{config('config.company_name')}} </li>
			                        <li>{{trans('messages.email').' : '.config('config.company_email')}}</li>
			                        <li>{{trans('messages.phone').' : '.config('config.company_phone')}}</li>
			                        {!! config('config.company_address_line_1') ? ('<li>'.config('config.company_address_line_1').'</li>') : ''!!}
			                        {!! config('config.company_address_line_2') ? ('<li>'.config('config.company_address_line_2').'</li>') : ''!!}
			                        {!! config('config.company_city') ? ('<li>'.config('config.company_city').'</li>') : ''!!}
			                        {!! config('config.company_state') ? ('<li>'.config('config.company_state').'</li>') : ''!!}
			                        {!! config('config.company_zipcode') ? ('<li>'.config('config.company_zipcode').'</li>') : ''!!}
			                        {!! config('config.company_country_id') ? ('<li>'.config('country.'.config('config.company_country_id')).'</li>') : ''!!}
			                    </ul>
			                </div>
			                <div class="col-xs-4 invoice-payment">
			                </div>
			                <div class="col-xs-4">
			                    <h3 class="text-right">{{trans('messages.customer')}}</h3>
			                    <ul class="list-unstyled pull-right text-right">
			                        <li style="font-size:16px; font-weight:bold;"> {{$quotation->Customer->full_name}} </li>
			                        <li>{{trans('messages.email').' : '.$quotation->Customer->email}}</li>
			                        @if($quotation->Customer->Profile->phone)
			                        	<li>{{trans('messages.phone').' : '.$quotation->Customer->Profile->phone}}</li>
			                        @endif
			                        <li> {{$quotation->Customer->Profile->address_line_1}}
			                        {{isset($quotation->Customer->Profile->address_line_2) ? ($quotation->Customer->Profile->address_line_2) : ''}}</li>
			                        {!!isset($quotation->Customer->Profile->city) ? ('<li>'.$quotation->Customer->Profile->city.'</li>') : ''!!}
			                        {!!isset($quotation->Customer->Profile->state) ? ('<li>'.$quotation->Customer->Profile->state.'</li>') : ''!!}
			                        {!!isset($quotation->Customer->Profile->zipcode) ? ('<li>'.$quotation->Customer->Profile->zipcode.'</li>') : ''!!}
			                        {!!isset($quotation->Customer->Profile->country_id) ? ('<li>'.config('country.'.$quotation->Customer->Profile->country_id).'</li>') : ''!!}
			                    </ul>
			                </div>
			            </div>
			            <div class="row">
			            	<div class="col-xs-12">
			            		<h4><strong>{!!trans('messages.subject').':</strong> '.$quotation->subject!!}</h4>
			            		{!! $quotation->description !!}
			            		<div style="margin-bottom: 15px;"></div>
			            	</div>
			            </div>
			            <div class="row">
			                <div class="col-xs-12">
			                	<div class="table-responsive">
			                    <table class="table table-striped table-hover table-bordered">
			                        <thead>
			                            <tr>
			                                <th> # </th>
			                                <th> {{trans('messages.item')}} </th>
			                                <th> {{trans('messages.description')}} </th>
			                                @if($quotation->item_type != 'amount_only')
			                                <th> {{trans('messages.quantity')}} </th>
			                                @endif
			                                <th> {{trans('messages.unit').' '.trans('messages.price')}} </th>
			                                @if($quotation->line_item_discount)
			                                <th> {{trans('messages.discount')}} </th>
			                                @endif
			                                @if($quotation->line_item_tax)
			                                <th> {{trans('messages.tax')}} </th>
			                                @endif
			                                <th style="width:150px;" class="text-right"> {{trans('messages.amount')}} </th>
			                            </tr>
			                        </thead>
			                        <tbody>
			                        	<?php $i = 1; ?>
			                        	@foreach($quotation->QuotationItem as $quotation_item)
			                            <tr>
			                                <td> {{$i}} </td>
			                                <td> {{$quotation_item->item_name}} </td>
			                                <td> {{$quotation_item->item_description}} </td>
			                                @if($quotation->item_type != 'amount_only')
			                                	<td> {{round($quotation_item->item_quantity,config('config.item_quantity_decimal_place'))}} </td>
			                                @endif
			                                <td> {{currency($quotation_item->unit_price,1,$quotation->Currency->id)}} </td>
			                                @if($quotation->line_item_discount)
			                                	<td> {{
			                                	($quotation_item->item_discount_type) ? currency($quotation_item->item_discount,1,$quotation->Currency->id) : (round($quotation_item->item_discount,config('config.item_discount_decimal_place')).' %')
			                                	}} </td>
			                                @endif
			                                @if($quotation->line_item_tax)
			                                	<td> {{round($quotation_item->item_tax,config('config.item_tax_decimal_place')).' %'}} </td>
			                                @endif
			                                <td class="text-right"> {{currency($quotation_item->item_amount,1,$quotation->Currency->id)}} </td>
			                            </tr>
			                            <?php $i++; ?>
			                            @endforeach
			                        </tbody>
			                    </table>
			                    </div>
			                </div>
			            </div>
			            <div class="row">
			                <div class="col-xs-6">
			                    <div class="well" style="margin-top: 10px;">
			                        <address>
			                            <strong>{{trans('messages.tnc')}}</strong>
			                            <p>{{$quotation->tnc}}</p>
			                        </address>
			                    </div>
			                    <div class="well">
			                        <address>
			                            <strong>{{trans('messages.customer').' '.trans('messages.note')}}</strong>
			                            <p>{{$quotation->customer_note}}</p>
			                        </address>
			                    </div>
			                	@if($quotation->memo && !Entrust::hasRole(config('constant.default_customer_role')))
			                    <div class="well">
			                        <address>
			                            <strong>{{trans('messages.memo')}}</strong>
			                            <p>{{$quotation->memo}}</p>
			                        </address>
			                    </div>
			                    @endif
			                </div>
			                <div class="col-xs-2">
			                </div>
			                <div class="col-xs-4">
			                	<div class="table-responsive">
				                	<table class="table table-striped table-hover table-bordered">
				                		<tbody>
				                			@if($quotation->subtotal_discount && $quotation->subtotal_discount_amount > 0)
				                			<tr>
				                				<td>{{trans('messages.discount')}}</td>
				                				<td style="width:150px;" class="text-right">{{currency($quotation->subtotal_discount_amount,1,$quotation->Currency->id)}}</td>
				                			</tr>
				                			@endif
				                			@if($quotation->subtotal_tax && $quotation->subtotal_tax_amount > 0)
				                			<tr>
				                				<td>{{trans('messages.tax')}}</td>
				                				<td style="width:150px;" class="text-right">{{currency($quotation->subtotal_tax_amount,1,$quotation->Currency->id)}}</td>
				                			</tr>
				                			@endif
				                			@if($quotation->subtotal_shipping_and_handling && $quotation->subtotal_shipping_and_handling_amount > 0)
				                			<tr>
				                				<td>{{trans('messages.shipping_and_handling')}}</td>
				                				<td style="width:150px;" class="text-right">{{currency($quotation->subtotal_shipping_and_handling_amount,1,$quotation->Currency->id)}}</td>
				                			</tr>
				                			@endif
				                			<tr style="font-size:16px; font-weight: bold;">
				                				<td>{{trans('messages.grand').' '.trans('messages.total')}}</td>
				                				<td style="width:150px;" class="text-right">{{currency($quotation->total,1,$quotation->Currency->id)}}</td>
				                			</tr>
				                			<tfoot>
				                			<tr>
				                				<td colspan="2" style="font-weight:bold;" class="text-right"><strong>{{inWords(round($quotation->total,$quotation->Currency->decimal_place)).' '.$quotation->Currency->name}}</strong></td>
				                			</tr>
				                			</tfoot>
				                		</tbody>
				                	</table>
			                	</div>
			                </div>
			            </div>
			        </div>
			    </div>
        	</div>
        </div>
        <div class="row no-print">
          <div class="col-xs-12">
          	<div class="pull-right" style="margin-bottom: 20px;">
	            <a href="/quotation/{{$quotation->uuid}}/print" class="btn btn-primary"><i class="fa fa-print"></i> {{trans('messages.print')}}</a> 
	            <a href="/quotation/{{$quotation->uuid}}/pdf" class="btn btn-success"><i class="fa fa-file-pdf-o"></i> {{trans('messages.download').' '.trans('messages.pdf')}}</a> 
	        </div>
          </div>
        </div>