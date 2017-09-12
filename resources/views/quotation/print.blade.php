<!DOCTYPE html>
<html>
<head>
	<title>{!! config('config.application_name') ? : config('constants.default_title') !!}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
						@if($quotation->reference_number)
						<tr>
							<th>{{trans('messages.reference').' '.trans('messages.number')}}</th><td>{{$quotation->reference_number}}</td>
						</tr>
						@endif
						<tr>
							<th>{{trans('messages.quotation').' '.trans('messages.number')}}</th><td>{{$quotation->quotation_prefix.getQuotationNumber($quotation)}}</td>
						</tr>
						<tr>
							<th>{{trans('messages.quotation').' '.trans('messages.date')}}</th><td>{{showDate($quotation->date)}}</td>
						</tr>
						<tr>
							<th>{{trans('messages.expiry').' '.trans('messages.date')}}</th><td>{{showDate($quotation->expiry_date)}}</td>
						</tr>
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
					</td>
					<td style="text-align:right;width:60%;">
						<p style="font-size:14px;"><span style="font-size:16px; font-weight: bold;">{{$quotation->Customer->full_name}}</span><br />
			            {!! trans('messages.email').' : '.$quotation->Customer->email.' <br />'!!}
			            {!! ($quotation->Customer->Profile->phone) ? (trans('messages.phone').' : '.$quotation->Customer->Profile->phone.' <br />') : ''!!}
			            {!! ($quotation->Customer->Profile->address_line_1) ? ($quotation->Customer->Profile->address_line_1.' <br />') : ''!!}
			            {!! ($quotation->Customer->Profile->address_line_2) ? ($quotation->Customer->Profile->address_line_2.' <br />') : ''!!}
			            {!! ($quotation->Customer->Profile->city) ? ($quotation->Customer->Profile->city.' <br />') : ''!!}
			            {!! ($quotation->Customer->Profile->state) ? ($quotation->Customer->Profile->state.' <br />') : ''!!}
			            {!! ($quotation->Customer->Profile->zipcode) ? ($quotation->Customer->Profile->zipcode.' <br />') : ''!!}
			            {!! ($quotation->Customer->Profile->country_id) ? config('country.'.$quotation->Customer->Profile->country_id) : ''!!}
			            </p>
					</td>
				</tr>
			</table>
			<div style="margin:5px 0px;">&nbsp;</div>
		    <div style="font-size: 14px;">
		    	<strong>{!!trans('messages.subject').':</strong> '.$quotation->subject!!}
		  	</div>
		    <div style="font-size: 12px;">
		    	{!!$quotation->description!!}
		    </div>
		    <table class="fancy-detail">
		        <thead>
		            <tr>
		                <th> # </th>
		                <th> {{trans('messages.item')}} </th>
		                <th> {{trans('messages.description')}} </th>
		                @if($quotation->item_type != 'amount_only')
		                <th style="text-align: right;"> {{trans('messages.quantity')}} </th>
		                @endif
		                <th style="text-align: right;"> {{trans('messages.unit').' '.trans('messages.price')}} </th>
		                @if($quotation->line_item_discount)
		                <th style="text-align: right;"> {{trans('messages.discount')}} </th>
		                @endif
		                @if($quotation->line_item_tax)
		                <th style="text-align: right;"> {{trans('messages.tax')}} </th>
		                @endif
		                <th style="width:150px;text-align: right;"> {{trans('messages.amount')}} </th>
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
		                	<td style="text-align: right;"> {{round($quotation_item->item_quantity,config('config.item_quantity_decimal_place'))}} </td>
		                @endif
		                <td style="text-align: right;"> {{currency($quotation_item->unit_price,1,$quotation->Currency->id)}} </td>
		                @if($quotation->line_item_discount)
		                	<td style="text-align: right;"> {{
		                	($quotation_item->item_discount_type) ? currency($quotation_item->item_discount,1,$quotation->Currency->id) : (round($quotation_item->item_discount,config('config.item_discount_decimal_place')).' %')
		                	}} </td>
		                @endif
		                @if($quotation->line_item_tax)
		                	<td style="text-align: right;"> {{round($quotation_item->item_tax,config('config.item_tax_decimal_place')).' %'}} </td>
		                @endif
		                <td style="text-align: right;"> {{currency($quotation_item->item_amount,1,$quotation->Currency->id)}} </td>
		            </tr>
		            <?php $i++; ?>
		            @endforeach
		        </tbody>
		    </table>
		    <table cellpadding="0" cellspacing="0" border="0" style="width: 100%;">
		    	<tr>
		    		<td style="width:60%;vertical-align: top;">
		    			@if($quotation->tnc)
							<h2>{{trans('messages.tnc')}}</h2>
							<p style="font-size: 13px;">{{$quotation->tnc}}</p>
						@endif
		    			@if($quotation->customer_note)
							<h2>{{trans('messages.customer').' '.trans('messages.note')}}</h2>
							<p style="font-size: 13px;">{{$quotation->customer_note}}</p>
						@endif
		    		</td>
		    		<td style="width:40%;vertical-align: top;">
		    			<table class="fancy-detail" style="width:100%;">
							@if($quotation->subtotal_discount && $quotation->subtotal_discount_amount > 0)
							<tr>
								<td>{{trans('messages.discount')}}</td>
								<td style="width:150px; text-align: right;">{{currency($quotation->subtotal_discount_amount,1,$quotation->Currency->id)}}</td>
							</tr>
							@endif
							@if($quotation->subtotal_tax && $quotation->subtotal_tax_amount > 0)
							<tr>
								<td>{{trans('messages.tax')}}</td>
								<td style="width:150px; text-align: right;">{{currency($quotation->subtotal_tax_amount,1,$quotation->Currency->id)}}</td>
							</tr>
							@endif
							@if($quotation->subtotal_shipping_and_handling && $quotation->subtotal_shipping_and_handling_amount > 0)
							<tr>
								<td>{{trans('messages.shipping_and_handling')}}</td>
								<td style="width:150px; text-align: right;">{{currency($quotation->subtotal_shipping_and_handling_amount,1,$quotation->Currency->id)}}</td>
							</tr>
							@endif
							<tr>
								<td style="font-size:16px; font-weight: bold;">{{trans('messages.grand').' '.trans('messages.total')}}</td>
								<td style="width:150px; text-align: right;font-size:16px; font-weight: bold;">{{currency($quotation->total,1,$quotation->Currency->id)}}</td>
							</tr>
							<tr>
								<td colspan="2" style="font-weight:bold; text-align: right;font-size:16px;">{{inWords(round($quotation->total,$quotation->Currency->decimal_place)).' '.$quotation->Currency->name}}</td>
							</tr>
						</table>
		    		</td>
		    	</tr>
		    </table>
	    </div>
	</div>
</body>
</html>

