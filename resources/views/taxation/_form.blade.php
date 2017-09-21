
			  <div class="form-group">
			    {!! Form::label('name',trans('messages.taxation').' '.trans('messages.name'),[])!!}
				{!! Form::input('text','name',isset($taxation->name) ? $taxation->name : '',['class'=>'form-control','placeholder'=>trans('messages.taxation').' '.trans('messages.name')])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('value',trans('messages.taxation').' '.trans('messages.value'),[])!!}
				{!! Form::input('number','value',isset($taxation->value) ? round($taxation->value,2) : '',['class'=>'form-control','placeholder'=>trans('messages.taxation').' '.trans('messages.value'),'step' => '.05'])!!}
			  </div>
			  <div class="form-group">
			    {!! Form::label('description',trans('messages.description'),[])!!}
			    {!! Form::textarea('description',isset($taxation->description) ? $taxation->description : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.description'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1])!!}
			    <span class="countdown"></span>
			  </div>
			  <div class="form-group">
			  {!! Form::label('is_default',trans('messages.default'),['class' => 'control-label '])!!}
	                <div class="checkbox">
	                	<input name="is_default" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" {{ (isset($taxation) && $taxation->is_default) ? 'checked' : '' }} data-off-value="0">
	                </div>
			  </div>
			  {!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
			  	
