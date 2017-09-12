	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.add_new').' '.trans('messages.shipment').' '.trans('messages.address') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::open(['route' => 'shipment.store','class'=>'shipment_address-form','id' => 'shipment_address-form','data-table-refresh' => 'shipment_address-table']) !!}
			@include('shipment_address._form')
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>
