	@foreach($currencies as $currency)
		@if($currency->name != $default_currency->name)
		<div class="form-group">
			<div class="input-group">
				<span class="input-group-addon">1 {{$default_currency->detail}} = </span>
				{!! Form::input('text',$currency->id,(($currency_conversions->where('currency_id',$currency->id)->count()) ? round($currency_conversions->where('currency_id',$currency->id)->first()->rate,5) : ((array_key_exists($currency->name,$conversions)) ? $conversions[$currency->name] : '')),['class'=>'form-control','placeholder'=>trans('messages.conversion').' '.trans('messages.rate'),'style' => 'text-align:right;'])!!}
				<span class="input-group-addon">{{$currency->detail}} </span>
			</div>
		</div>
		@endif
	@endforeach

	@if(array_key_exists('date',$conversion_string))
		<div class="alert alert-success"><strong>{{trans('messages.conversion_rate_as_of').' '.showDate($conversion_string['date'])}}</strong></div>
	@else
		<div class="alert alert-danger"><strong>{{trans('messages.no_conversion_found')}}</strong></div>
	@endif
	{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}