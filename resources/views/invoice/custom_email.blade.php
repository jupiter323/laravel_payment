
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.custom').' '.trans('messages.email') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($invoice,['method' => 'POST','route' => ['invoice.custom-email',$invoice->uuid] ,'class' => 'invoice-custom-email-form','id' => 'invoice-custom-email-form','data-invoice-id' => $invoice->id,'data-url' => '/template/content']) !!}
			<div class="form-group">
				{{trans('messages.customer')}} : {!! Form::label($invoice->Customer->full_name) !!}
			</div>
			<div class="form-group">
				{{trans('messages.email')}} : {!! Form::label($invoice->Customer->email) !!}
			</div>
			<div class="form-group">
                {!! Form::select('template_id', $templates,'',['class'=>'form-control show-tick','id'=>'template_id','title' => trans('messages.select_one')])!!}
            </div>
            <div class="form-group">
                {!! Form::input('text','subject','',['class'=>'form-control','placeholder'=>trans('messages.subject'),'id' => 'mail_subject']) !!}
            </div>
            <div class="form-group">
                {!! Form::textarea('body','',['size' => '30x3', 'class' => 'form-control summernote', 'id' => 'mail_body', 'placeholder' => trans('messages.body')])!!}
            </div>
            {!! Form::submit(trans('messages.send'),['class' => 'btn btn-primary pull-right']) !!}
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>