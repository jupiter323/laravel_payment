
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.coupon') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($coupon,['method' => 'PATCH','route' => ['coupon.update',$coupon] ,'class' => 'coupon-edit-form','id' => 'coupon-edit-form']) !!}
			@include('coupon._form', ['buttonText' => trans('messages.update')])
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>