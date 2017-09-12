		
		@if($default_currency->id != $currency->id)
			<div class="form-group">
				<label class="conversion_rate">{{trans('messages.conversion').' '.trans('messages.rate')}}</label>
				<div class="input-group">
					<span class="input-group-addon">1 {{$default_currency->detail}} = </span>
					{!! Form::input('text','conversion_rate',(($currency_conversions->where('currency_id',$currency->id)->count()) ? round($currency_conversions->where('currency_id',$currency->id)->first()->rate,5) : ((array_key_exists($default_currency->name,$conversions)) ? round($conversions[$default_currency->name],5) : '')),['class'=>'form-control','placeholder'=>trans('messages.conversion').' '.trans('messages.rate')])!!}
					<span class="input-group-addon">{{$currency->detail}} </span>
				</div>
			</div>
		@endif
		