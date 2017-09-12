				<div class="row">
					<div class="col-md-6">

 <div class="form-group">
					    {!! Form::label('form',trans('messages.form'),[])!!}
						{!! Form::select('form', config('custom_field'),'',['class'=>'form-control input-xlarge show-tick','title'=>trans('messages.select_one')])!!}
					  </div>
					    <div class="form-group">
					    {!! Form::label('title',trans('messages.column').' '.trans('messages.title'),[])!!}
						{!! Form::input('text','title','',['class'=>'form-control','placeholder'=>trans('messages.column').' '.trans('messages.title')])!!}
					  </div>

		  <div class="form-group">
					    {!! Form::label('type',trans('messages.type'),[])!!}
						{!! Form::select('type', [
							'text' => 'Text Box',
							'number' => 'Number',
							'email' => 'Email',
							'url' => 'URL',
							'date' => 'Date',
							'select' => 'Select Box',
							'radio' => 'Radio Button',
							'checkbox' => 'Check Box',
							'textarea' => 'Textarea'
							],'',['id' => 'type', 'class'=>'form-control input-xlarge show-tick','title'=>trans('messages.select_one')])!!}
					  </div>


 <div class="custom-field-option">
						<div class="form-group">
						    {!! Form::label('options',trans('messages.option'),[]) !!}
							{!! Form::input('text','options','',['class'=>'form-control','placeholder'=>trans('messages.option'),'data-role' => 'tagsinput']) !!}
						</div>


<div class="form-group">
					    {!! Form::label('title',trans('messages.default').' '.trans('messages.value'),[])!!}
						{!! Form::input('text','default_value','',['class'=>'form-control','placeholder'=>trans('messages.default').' '.trans('messages.value')])!!}
					  </div>
					  </div>


						</div>


<div class="col-md-6">
<div class="row">

<div class="col-sm-6">

 <div class="form-group">
  {!! Form::label('position',trans('messages.position'),[])!!}
						{!! Form::select('position', [
							'after' => 'After',
							'before' => 'Before'							
							],'',['id' => 'position', 'class'=>'form-control input-xlarge show-tick','title'=>trans('messages.select_one')])!!}
					  </div></div>
<div class="col-sm-6">
<div class="form-group">
  {!! Form::label('after_field',trans('messages.after').' '.trans('messages.field'),[])!!}
						{!! Form::select('after_field',$column,'',['id' => 'after_field', 'class'=>'form-control input-xlarge show-tick','title'=>trans('messages.select_one')])!!}
					  </div> </div></div>


<div class="row">

<div class="col-sm-6">

 <div class="form-group">
  {!! Form::label('minlength',trans('messages.minlength'),[])!!}
						{!! Form::input('number','minlength','',['class'=>'form-control','placeholder'=>'1','data-role' => 'tagsinput']) !!}
					  </div></div>
<div class="col-sm-6">
<div class="form-group">
  {!! Form::label('maxlength',trans('messages.maxlength'),[])!!}
						{!! Form::input('number','maxlength','',['class'=>'form-control','placeholder'=>'1','data-role' => 'tagsinput']) !!}
					  </div> </div></div>


					 


<div class="row">
<div class="col-sm-12">
				<div class="form-group">
		                <div class="checkbox">
		                <input name="is_required" type="checkbox" class="switch-input" data-size="mini" data-on-text="Required" data-off-text="Optional" value="1" checked>
		                </div>
		              </div>
 </div>
<div class="col-sm-12">


<div class="form-group">
		                <div class="checkbox">
		                <input name="active" type="checkbox" class="switch-input" data-size="mini" data-on-text="Visible" data-off-text="Invisible" value="1" checked>
		                </div>
		              </div></div></div>
			



</div>				</div>