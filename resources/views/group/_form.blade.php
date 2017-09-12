			<div class="col-sm-6">
			  <div class="form-group">
			    {!! Form::label('group_name',trans('messages.group').' '.trans('messages.name'),[])!!}
				{!! Form::input('text','group_name',(isset($company) ? $company->name : ''),['class'=>'form-control','placeholder'=>trans('messages.group').' '.trans('messages.name')])!!}
			  </div>
			
			
					
			</div>
				{{ getCustomFields('company-form',$custom_field_values) }}
			  	{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
			</div>
