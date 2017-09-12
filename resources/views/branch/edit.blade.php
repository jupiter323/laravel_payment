	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.branch') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($branch,['method' => 'PATCH','route' => ['branch.update',$branch] ,'class' => 'branch-edit-form','id' => 'branch-edit-form']) !!}
			@include('branch._form', ['buttonText' => trans('messages.update')])
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>