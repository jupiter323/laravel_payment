			
<div class="col-sm-12">		 
<div class="col-sm-6">		 
 <div class="form-group">

				{!! Form::input('text','shipment_address',isset($shipment_address->shipment_address) ? $shipment_address->shipment_address: '',['class'=>'form-control','placeholder'=>trans('messages.shipment').' '.trans('messages.address')])!!}
			  </div>
<div class="form-group">

					{!! Form::select('country_id', config('country'),(isset($shipment_address) ? $shipment_address->country_id : ''),['class'=>'form-control show-tick','title'=>trans('messages.country')])!!}
</div>	
<div class="row">
						<div class="col-xs-5">
						{!! Form::input('text','ext_num',(isset($shipment_address) ? $shipment_address->ext_num: ''),['class'=>'form-control','placeholder'=>trans('messages.ext_num')])!!}
						</div>
						<div class="col-xs-4">
						{!! Form::input('text','int_num',(isset($shipment_address) ? $shipment_address->int_num: ''),['class'=>'form-control','placeholder'=>trans('messages.int_num')])!!}
						</div>
						<div class="col-xs-3">
						{!! Form::input('text','zipcode',(isset($shipment_address) ? $shipment_address->zipcode : ''),['class'=>'form-control','placeholder'=>trans('messages.zipcode')])!!}
						</div>
					</div>
					<br />
<div class="form-group">
{!! Form::input('text','state',(isset($shipment_address) ? $shipment_address->state : ''),['class'=>'form-control','placeholder'=>trans('messages.state')])!!}
</div></div>
<div class="col-sm-6">		 

<div class="form-group">
{!! Form::input('text','city',(isset($shipment_address) ? $shipment_address->city : ''),['class'=>'form-control','placeholder'=>trans('messages.city')])!!}
</div>


<div class="form-group">
					{!! Form::select('neighboorhood',  $neighbourhood,(isset($shipment_address) ? $shipment_address->neighboorhood: ''),['class'=>'form-control show-tick','title'=>trans('messages.neighboorhood')])!!}
</div>
					{!! Form::input('text','street',(isset($shipment_address) ? $shipment_address->street: ''),['class'=>'form-control','placeholder'=>trans('messages.street')])!!}
					
					
					<br />


</div>


	<div class="col-sm-6">


	</div>	 
	 
	 
			 			  
			  </div>



			  {!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
			  	
