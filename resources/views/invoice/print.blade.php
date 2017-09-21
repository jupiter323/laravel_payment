<!DOCTYPE html>
<html>
<head>
	<title>{!! config('config.application_name') ? : config('constants.default_title') !!}</title>
	<meta charset="utf-8" /> 
	@if(isset($action_type) && $action_type == 'print')
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	@endif
	<style>
	@if(isset($action_type) && $action_type == 'print')
		*{font-family:'Open Sans','Verdana'}
	@else
		*{font-family:'Helvetica';}
	@endif
	body{width:auto; max-width:800px;margin:0 auto;,font-size:12px;}
	h2{font-size: 16px;font-weight: bold;}
	table.table-head th{font-size: 14px; font-weight: bold;text-align: right;}
	table.table-head td{font-size: 12px;text-align: right;}

	table.fancy-detail {  font-size:12px; border-collapse: collapse;  width:100%;  margin:0 auto;}
	table.fancy-detail th{  background:#E3E3E3; border: 1px #2e2e2e solid;  padding: 0.5em;  padding-left:10px; vertical-align:top;text-align: left;}
	table.fancy-detail th, table.fancy-detail td  {  padding: 0.5em;  padding-left:10px; border:1px solid #2e2e2e;text-align: left;}
	table.fancy-detail caption {  margin-left: inherit;  margin-right: inherit;}
	table.fancy-detail tr:hover{}

	</style>
</head>
<body>
	<div style="background-color: #F5F5F5; padding:5px;">
		<div style="padding:10px;background: #ffffff;">
			<table border="0" style="width:100%;margin-top: 20px;">
			<tr>
				<td style="width:40%;vertical-align: top;">
					{!! getCompanyLogo()  !!}
				</td>
				<td style="width:60%;vertical-align: top;">
					<table align="right" class="table-head">
						@if($invoice->reference_number)
						<tr>
							<th>{{trans('messages.reference').' '.trans('messages.number')}}</th><td>{{$invoice->reference_number}}</td>
						</tr>
						@endif
						<tr>
							<th>{{trans('messages.invoice').' '.trans('messages.number')}}</th><td>{{$invoice->invoice_prefix.getInvoiceNumber($invoice)}}</td>
						</tr>
						<tr>
							<th>{{trans('messages.invoice').' '.trans('messages.date')}}</th><td>{{showDate($invoice->date)}}</td>
						</tr>
						@if($invoice->due_date != 'no_due_date')
						<tr>
							<th>{{trans('messages.due').' '.trans('messages.date')}}</th><td>{{showDate($invoice->due_date_detail)}}</td>
						</tr>
						@endif
					</table>
				</td>
			</tr>
			</table>
			<table border="0" style="width:100%;">
				<tr>
					<td colspan="2"><hr></td>
				</tr>
				<tr>
					<td style="width:40%;">
			            <p style="font-size:14px;"><span style="font-size:16px; font-weight: bold;">{{config('config.company_name')}}</span><br />
			            {!! (config('config.company_email')) ? (trans('messages.email').' : '.config('config.company_email').' <br />') : ''!!}
			            {!! (config('config.company_phone')) ? (trans('messages.phone').' : '.config('config.company_phone').' <br />') : ''!!}
			            {!! config('config.company_address_line_1') ? (config('config.company_address_line_1').' <br />') : ''!!}
		            	{!! config('config.company_address_line_2') ? (config('config.company_address_line_2').' <br />') : ''!!}
		            	{!! config('config.company_city') ? (config('config.company_city').' <br />') : ''!!}
		            	{!! config('config.company_state') ? (config('config.company_state').' <br />') : ''!!}
		            	{!! config('config.company_zipcode') ? (config('config.company_zipcode').' <br />') : ''!!}
		            	{!! config('config.company_country_id') ? config('country.'.config('config.company_country_id')) : ''!!}
			            </p>
			            <span style="font-size:18px; font-weight:bold; padding:5px; border:4px solid {{$invoice_color}};color:{{$invoice_color}};">{{trans('messages.'.$invoice->payment_status)}}</span>
					</td>
					<td style="text-align:right;width:60%;">
						<p style="font-size:14px;"><span style="font-size:16px; font-weight: bold;">{{$invoice->Customer->full_name}}</span><br />
			            {!! trans('messages.email').' : '.$invoice->Customer->email.' <br />'!!}
			            {!! ($invoice->Customer->Profile->phone) ? (trans('messages.phone').' : '.$invoice->Customer->Profile->phone.' <br />') : ''!!}
			            {!! ($invoice->Customer->Profile->address_line_1) ? ($invoice->Customer->Profile->address_line_1.' <br />') : ''!!}
			            {!! ($invoice->Customer->Profile->address_line_2) ? ($invoice->Customer->Profile->address_line_2.' <br />') : ''!!}
			            {!! ($invoice->Customer->Profile->city) ? ($invoice->Customer->Profile->city.' <br />') : ''!!}
			            {!! ($invoice->Customer->Profile->state) ? ($invoice->Customer->Profile->state.' <br />') : ''!!}
			            {!! ($invoice->Customer->Profile->zipcode) ? ($invoice->Customer->Profile->zipcode.' <br />') : ''!!}
			            {!! ($invoice->Customer->Profile->country_id) ? config('country.'.$invoice->Customer->Profile->country_id) : ''!!}
			            </p>
					</td>
				</tr>
			</table>
			<div style="margin:5px 0px;">&nbsp;</div>
		    <table class="fancy-detail">
		        <thead>
		            <tr>
		                <th> # </th>
		                <th> {{trans('messages.item')}} </th>
		                <th> {{trans('messages.description')}} </th>
		                @if($invoice->item_type != 'amount_only')
		                <th style="text-align: right;"> {{trans('messages.quantity')}} </th>
		                @endif
		                <th style="text-align: right;"> {{trans('messages.unit').' '.trans('messages.price')}} </th>
		                @if($invoice->line_item_discount)
		                <th style="text-align: right;"> {{trans('messages.discount')}} </th>
		                @endif
		                @if($invoice->line_item_tax)
		                <th style="text-align: right;"> {{trans('messages.tax')}} </th>
		                @endif
		                <th style="width:150px;text-align: right;"> {{trans('messages.amount')}} </th>
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
		                	<td style="text-align: right;"> {{round($invoice_item->item_quantity,config('config.item_quantity_decimal_place'))}} </td>
		                @endif
		                <td style="text-align: right;"> {{currency($invoice_item->unit_price,1,$invoice->Currency->id)}} </td>
		                @if($invoice->line_item_discount)
		                	<td style="text-align: right;"> {{
		                	($invoice_item->item_discount_type) ? currency($invoice_item->item_discount,1,$invoice->Currency->id) : (round($invoice_item->item_discount,config('config.item_discount_decimal_place')).' %')
		                	}} </td>
		                @endif
		                @if($invoice->line_item_tax)
		                	<td style="text-align: right;"> {{round($invoice_item->item_tax,config('config.item_tax_decimal_place')).' %'}} </td>
		                @endif
		                <td style="text-align: right;"> {{currency($invoice_item->item_amount,1,$invoice->Currency->id)}} </td>
		            </tr>
		            <?php $i++; ?>
		            @endforeach
		        </tbody>
		    </table>
		    <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
		    	<tr>
		    		<td style="width:60%;vertical-align: top;">
		    			@if($invoice->tnc)
							<h2>{{trans('messages.tnc')}}</h2>
							<p style="font-size: 13px;">{{$invoice->tnc}}</p>
						@endif
		    			@if($invoice->customer_note)
							<h2>{{trans('messages.customer').' '.trans('messages.note')}}</h2>
							<p style="font-size: 13px;">{{$invoice->customer_note}}</p>
						@endif
		    		</td>
		    		<td style="width:40%;vertical-align: top;">
		    			<table class="fancy-detail" style="width:100%;">
							@if($invoice->subtotal_discount && $invoice->subtotal_discount_amount > 0)
							<tr>
								<td>{{trans('messages.discount')}}</td>
								<td style="width:150px; text-align: right;">{{currency($invoice->subtotal_discount_amount,1,$invoice->Currency->id)}}</td>
							</tr>
							@endif
							@if($invoice->subtotal_tax && $invoice->subtotal_tax_amount > 0)
							<tr>
								<td>{{trans('messages.tax')}}</td>
								<td style="width:150px; text-align: right;">{{currency($invoice->subtotal_tax_amount,1,$invoice->Currency->id)}}</td>
							</tr>
							@endif
							@if($invoice->subtotal_shipping_and_handling && $invoice->subtotal_shipping_and_handling_amount > 0)
							<tr>
								<td>{{trans('messages.shipping_and_handling')}}</td>
								<td style="width:150px; text-align: right;">{{currency($invoice->subtotal_shipping_and_handling_amount,1,$invoice->Currency->id)}}</td>
							</tr>
							@endif
							<tr>
								<td style="font-size:16px; font-weight: bold;">{{trans('messages.grand').' '.trans('messages.total')}}</td>
								<td style="width:150px; text-align: right;font-size:16px; font-weight: bold;">{{currency($invoice->total,1,$invoice->Currency->id)}}</td>
							</tr>
							<tr>
								<td colspan="2" style="font-weight:bold; text-align: right;font-size:16px;">{{inWords(round($invoice->total,$invoice->Currency->decimal_place)).' '.$invoice->Currency->name}}</td>
							</tr>
						</table>
		    		</td>
		    	</tr>
		    </table>
	    </div>
	</div>
</body>
</html>

