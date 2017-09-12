
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
			                    	{!!($invoice->reference_number) ? (trans('messages.reference').' '.trans('messages.number').' : <strong>'.$invoice->reference_number.'</strong>') : ''!!} <br /> 
			                    	{!!trans('messages.invoice').' '.trans('messages.date').' : <strong>'.showDate($invoice->date)!!}</strong> <br />
			                        <span class="muted"> {{trans('messages.invoice').' '.trans('messages.number')}} : <strong> {{$invoice->invoice_prefix.getInvoiceNumber($invoice)}}</strong></span>
			                        @if($invoice->due_date != 'no_due_date')
			                        <br />
			                        <span class="muted">{{trans('messages.due').' '.trans('messages.date')}} : <strong>{{showDate($invoice->due_date_detail)}}</strong></span>
			                        @endif			                        
			                    </p>
			                </div>
			            </div>
			            <hr/>
			            <div class="row">
			            	<div class="col-xs-12">
			                	<div class="pull-right" id="load-invoice-status" data-extra="&invoice_id={{$invoice->id}}" data-source="/invoice-status"></div>
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
			                        <li style="font-size:16px; font-weight:bold;"> {{$invoice->Customer->full_name}} </li>
			                        <li>{{trans('messages.email').' : '.$invoice->Customer->email}}</li>
			                        @if($invoice->Customer->Profile->phone)
			                        	<li>{{trans('messages.phone').' : '.$invoice->Customer->Profile->phone}}</li>
			                        @endif
			                        <li> {{$invoice->Customer->Profile->address_line_1}}
			                        {{isset($invoice->Customer->Profile->address_line_2) ? ($invoice->Customer->Profile->address_line_2) : ''}}</li>
			                        {!!isset($invoice->Customer->Profile->city) ? ('<li>'.$invoice->Customer->Profile->city.'</li>') : ''!!}
			                        {!!isset($invoice->Customer->Profile->state) ? ('<li>'.$invoice->Customer->Profile->state.'</li>') : ''!!}
			                        {!!isset($invoice->Customer->Profile->zipcode) ? ('<li>'.$invoice->Customer->Profile->zipcode.'</li>') : ''!!}
			                        {!!isset($invoice->Customer->Profile->country_id) ? ('<li>'.config('country.'.$invoice->Customer->Profile->country_id).'</li>') : ''!!}
			                    </ul>
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
			                                @if($invoice->item_type != 'amount_only')
			                                <th> {{trans('messages.quantity')}} </th>
			                                @endif
			                                <th> {{trans('messages.unit').' '.trans('messages.price')}} </th>
			                                @if($invoice->line_item_discount)
			                                <th> {{trans('messages.discount')}} </th>
			                                @endif
			                                @if($invoice->line_item_tax)
			                                <th> {{trans('messages.tax')}} </th>
			                                @endif
			                                <th style="width:150px;" class="text-right"> {{trans('messages.amount')}} </th>
			                            </tr>
			                        </thead>
			                        <tbody>
			                        	<?php $i = 1; ?>
			                        	@foreach($invoice->InvoiceItem as $invoice_item)
			                            <tr>
			                                <td> {{$i}} </td>
			                                <td> {{$invoice_item->item_name}} </td>
			                                <td> {{$invoice_item->item_description}} </td>
			                                @if($invoice->item_type != 'amount_only')
			                                	<td> {{round($invoice_item->item_quantity,config('config.item_quantity_decimal_place'))}} </td>
			                                @endif
			                                <td> {{currency($invoice_item->unit_price,1,$invoice->Currency->id)}} </td>
			                                @if($invoice->line_item_discount)
			                                	<td> {{
			                                	($invoice_item->item_discount_type) ? currency($invoice_item->item_discount,1,$invoice->Currency->id) : (round($invoice_item->item_discount,config('config.item_discount_decimal_place')).' %')
			                                	}} </td>
			                                @endif
			                                @if($invoice->line_item_tax)
			                                	<td> {{round($invoice_item->item_tax,config('config.item_tax_decimal_place')).' %'}} </td>
			                                @endif
			                                <td class="text-right"> {{currency($invoice_item->item_amount,1,$invoice->Currency->id)}} </td>
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
			                	
			                	@if($invoice->tnc)
			                    <div class="well" style="margin-top: 10px;">
			                        <address>
			                            <strong>{{trans('messages.tnc')}}</strong>
			                            <p>{{$invoice->tnc}}</p>
			                        </address>
			                    </div>
			                    @endif
			                	@if($invoice->customer_note)
			                    <div class="well">
			                        <address>
			                            <strong>{{trans('messages.customer').' '.trans('messages.note')}}</strong>
			                            <p>{{$invoice->customer_note}}</p>
			                        </address>
			                    </div>
			                    @endif
			                	@if($invoice->memo && !Entrust::hasRole(config('constant.default_customer_role')))
			                    <div class="well">
			                        <address>
			                            <strong>{{trans('messages.memo')}}</strong>
			                            <p>{{$invoice->memo}}</p>
			                        </address>
			                    </div>
			                    @endif

			                	@if(!isset($no_payment) && Auth::check() && Entrust::hasRole(config('constant.default_customer_role')))
			                		<h2><strong>{{trans('messages.payment')}}</strong></h2>
			                		<div class="table-responsive" style="margin-top: 10px;">
										<table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="invoice-payment-table" data-source="/invoice/payment/lists" data-extra="&invoice_id={{$invoice->id}}">
											<thead>
												<tr>
													<th>{!! trans('messages.date') !!}</th>
													<th>{!! trans('messages.amount') !!}</th>
													<th>{!! trans('messages.method') !!}</th>
													<th data-sortable="false" style="width:150px;">{!! trans('messages.option') !!}</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
									</div>
								@endif
			                </div>
			                <div class="col-xs-2">
			                </div>
			                <div class="col-xs-4">
			                	<div class="table-responsive">
				                	<table class="table table-striped table-hover table-bordered">
				                		<tbody>
				                			@if($invoice->subtotal_discount && $invoice->subtotal_discount_amount > 0)
				                			<tr>
				                				<td>{{trans('messages.discount')}}</td>
				                				<td style="width:150px;" class="text-right">{{($invoice->subtotal_discount_type) ? currency($invoice->subtotal_discount_amount,1,$invoice->Currency->id) : (round($invoice->subtotal_discount_amount,5).' %')}}</td>
				                			</tr>
				                			@endif
				                			@if($invoice->subtotal_tax && $invoice->subtotal_tax_amount > 0)
				                			<tr>
				                				<td>{{trans('messages.tax')}}</td>
				                				<td style="width:150px;" class="text-right">{{round($invoice->subtotal_tax_amount,5)}} %</td>
				                			</tr>
				                			@endif
				                			@if($invoice->subtotal_shipping_and_handling && $invoice->subtotal_shipping_and_handling_amount > 0)
				                			<tr>
				                				<td>{{trans('messages.shipping_and_handling')}}</td>
				                				<td style="width:150px;" class="text-right">{{currency($invoice->subtotal_shipping_and_handling_amount,1,$invoice->Currency->id)}}</td>
				                			</tr>
				                			@endif
				                			<tr style="font-size:16px; font-weight: bold;">
				                				<td>{{trans('messages.grand').' '.trans('messages.total')}}</td>
				                				<td style="width:150px;" class="text-right">{{currency($invoice->total,1,$invoice->Currency->id)}}</td>
				                			</tr>
				                			<tfoot>
				                			<tr>
				                				<td colspan="2" style="font-weight:bold;" class="text-right"><strong>{{inWords(round($invoice->total,$invoice->Currency->decimal_place)).' '.$invoice->Currency->name}}</strong></td>
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
	            <a href="/invoice/{{$invoice->uuid}}/print" class="btn btn-primary"><i class="fa fa-print"></i> {{trans('messages.print')}}</a> 
	            <a href="/invoice/{{$invoice->uuid}}/pdf" class="btn btn-success"><i class="fa fa-file-pdf-o"></i> {{trans('messages.download').' '.trans('messages.pdf')}}</a> 
	        </div>
          </div>
        </div>