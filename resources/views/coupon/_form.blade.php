		<div class="col-md-6">
			<div class="row">
				<div class="col-md-6">
				  <div class="form-group">
				    {!! Form::label('code',trans('messages.coupon').' '.trans('messages.code'),[])!!}
					{!! Form::input('text','code',(isset($coupon) ? $coupon->code : ''),['class'=>'form-control','placeholder'=>trans('messages.coupon').' '.trans('messages.code')])!!}
				  </div>
				</div>
				<div class="col-md-6">
				  <div class="form-group">
				    {!! Form::label('discount',trans('messages.discount'),[])!!}
					{!! Form::input('number','discount',(isset($coupon) ? $coupon->discount : ''),['class'=>'form-control','placeholder'=>trans('messages.discount')])!!}
				  </div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('valid_day',trans('messages.day'),[])!!}
						{!! Form::select('valid_day[]',$week_days,$selected_days,['class'=>'form-control show-tick','multiple' => 'multiple','data-actions-box' => "true"])!!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
					{!! Form::label('maximum_use_count',trans('messages.maximum').' '.trans('messages.use'),[])!!}
					{!! Form::input('number','maximum_use_count',(isset($coupon) ? $coupon->maximum_use_count : ''),['class'=>'form-control','placeholder'=>trans('messages.maximum').' '.trans('messages.use')])!!}
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-6">
				  <div class="form-group">
				    {!! Form::label('valid_from',trans('messages.valid').' '.trans('messages.from'),[])!!}
					{!! Form::input('text','valid_from',(isset($coupon) ? $coupon->valid_from : ''),['class'=>'form-control datepicker','placeholder'=>trans('messages.valid').' '.trans('messages.from'),'readonly' => 'true'])!!}
				  </div>
				</div>
				<div class="col-md-6">
				  <div class="form-group">
				    {!! Form::label('valid_to',trans('messages.valid').' '.trans('messages.to'),[])!!}
					{!! Form::input('text','valid_to',(isset($coupon) ? $coupon->valid_to : ''),['class'=>'form-control datepicker','placeholder'=>trans('messages.valid').' '.trans('messages.to'),'readonly' => 'true'])!!}
				  </div>
				</div>
			</div>
			<div class="form-group">
				{!! Form::label('new_user',trans('messages.new').' '.trans('messages.user'),['class' => 'control-label '])!!}
				<div class="checkbox">
					<input name="new_user" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" {{ (isset($coupon) && $coupon->new_user == '1') ? 'checked' : '' }} data-off-value="0">
				</div>
			</div>
		</div>
		<div class="clear"></div>
		{{ getCustomFields('coupon-form',$custom_field_values) }}
		{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
		