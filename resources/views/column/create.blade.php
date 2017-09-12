<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.add_new').' '.trans('messages.column') !!}</h4>
	</div>
	<div class="modal-body">
					{!! Form::open(['route' => 'column.store','role' => 'form', 'class'=>'custom-field-form','id' => 'custom-field-form','data-disable-enter-submission' => '1']) !!}
                                        	@include('column._form')
 					 
				        {!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
	
					{!! Form::close() !!}
				<div class="clear"></div>
	</div>
