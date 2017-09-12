				<div class="row">
				  <div class="col-md-6">  
					  <div class="form-group">
					    {!! Form::label('subject',trans('messages.subject'),[])!!}
						{!! Form::input('text','subject','',['class'=>'form-control','placeholder'=>'Subject'])!!}
					  </div>
				  </div>
				  <div class="col-md-6">  
					  <div class="form-group">
					    {!! Form::label('sender',trans('messages.sender'),[])!!}
						{!! Form::input('text','sender','',['class'=>'form-control','placeholder'=>'From'])!!}
					  </div>
				  </div>
				</div>
				<div class="row">
				  <div class="col-md-6">  
					  <div class="form-group">
					    {!! Form::label('inclusion',trans('messages.inclusion'),[])!!}
					    {!! Form::textarea('inclusion','',['size' => '30x3', 'class' => 'form-control', 'placeholder' => 'Inclusion'])!!}
					    <span class="countdown"></span>
					  </div>
				  </div>
				  <div class="col-md-6">
					  <div class="form-group">
					    {!! Form::label('exclusion',trans('messages.exclusion'),[])!!}
					    {!! Form::textarea('exclusion','',['size' => '30x3', 'class' => 'form-control', 'placeholder' => 'Exclusion'])!!}
					    <span class="countdown"></span>
					  </div>
				  </div>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label>
							{!! Form::radio('audience', 'customer', 'checked',['class' => 'icheck']).' '.trans('messages.customer') !!}
						</label>
						<label>
							{!! Form::radio('audience', 'staff', '',['class' => 'icheck']).' '.trans('messages.staff') !!}
						</label>
						<label>
							{!! Form::radio('audience', 'all', '',['class' => 'icheck']).' '.trans('messages.all') !!}
						</label>
					</div>
				</div>
				<div class="form-group">
				    {!! Form::textarea('body',$body,['size' => '30x3', 'class' => 'form-control summernote', 'placeholder' => 'Body'])!!}
				</div>
				<div class="form-group">
	                <input type="file" class="btn btn-default" name="attachments" id="attachments" value="{!! trans('messages.select').' '.trans('messages.attachment') !!}">
	            </div>
			  		{!! Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
