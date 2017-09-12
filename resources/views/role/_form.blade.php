			<div class="form-group">
			    {!! Form::label('name',trans('messages.role').' '.trans('messages.name'),[])!!}
				{!! Form::input('text','name',isset($role->name) ? toWord($role->name) : '',['class'=>'form-control','placeholder'=>trans('messages.role').' '.trans('messages.name')])!!}
			</div>
			<div class="form-group">
			    {!! Form::label('description',trans('messages.description'),[])!!}
			    {!! Form::textarea('description',isset($role->description) ? $role->description : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.description'),"data-show-counter" => 1,'data-autoresize' => 1])!!}
			    <span class="countdown"></span>
			</div>
			{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}