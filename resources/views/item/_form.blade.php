<div class="row">	
<div class="col-md-6">	
<div class="row">
<div class="col-xs-12">
			{!! Form::label('code',trans('messages.name'),[])!!}	
</div></div>		
			<div class="row">
                      <div class="col-xs-6">			
			{!! Form::input('text','name',isset($item) ? $item->name : '',['class'=>'form-control','placeholder'=>trans('messages.internal').' '.trans('messages.name')])!!}
			</div>
                   
                      <div class="col-xs-6">			
			{!! Form::input('text','tax_required_name',isset($item) ? $item->tax_required_name: '',['class'=>'form-control','placeholder'=>trans('messages.tax_required').' '.trans('messages.name')])!!}
			</div>
</div>
<div class="form-group">
<div class="row">
<div class="col-xs-12">
			{!! Form::label('code',trans('messages.item').' '.trans('messages.code'),[])!!}	
</div></div>

              <div class="row">

                      <div class="col-xs-4">
			{!! Form::input('text','code',isset($item) ? $item->code : '',['class'=>'form-control','placeholder'=>trans('messages.internal').' '.trans('messages.code')])!!}
</div>
 <div class="col-xs-4">
			
			{!! Form::input('text','customer_code',isset($item) ? $item->customer_code: '',['class'=>'form-control','placeholder'=>trans('messages.customer').' '.trans('messages.code')])!!}
			</div>
 <div class="col-xs-4">
			{!! Form::input('text','tax_required_code',isset($item) ? $item->tax_required_code: '',['class'=>'form-control','placeholder'=>trans('messages.tax_required').' '.trans('messages.code')])!!}
			</div>

</div></div>


<div class="row">
<div class="col-xs-12">
			{!! Form::label('code',trans('messages.description'),[])!!}	
</div></div>
<div class="row">

<div class="col-xs-6">				
				{!! Form::textarea('description',isset($item) ? $item->description : '',['size' => '30x4', 'class' => 'form-control', 'placeholder' => trans('messages.description'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit')])!!}
				<span class="countdown"></span>
			</div>


<div class="col-xs-6">				
				{!! Form::textarea('tax_required_desc',isset($item) ? $item->tax_required_desc: '',['size' => '30x4', 'class' => 'form-control', 'placeholder' => trans('messages.tax_required').' '.trans('messages.description'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit')])!!}
				<span class="countdown"></span>
			</div></div>



		</div>


<div class="col-md-6">
<div class="row">
<div class="col-xs-6">				
<div class="col-sm-12" style="padding-right:0px;padding-left:0px;">{!! Form::label('unit',trans('messages.unit'),['class' => 'control-label'])!!}
</div>
<div class="btn-group col-sm-12" role="group" aria-label="Button group with nested dropdown" style="padding-left:0px;padding-right:0px;">
<div class="btn-group col-sm-10" style="padding-left:0px;padding-right:0px;">
				{!! Form::select('unit', $unit, isset($item) ? $item->unit : '',['class'=>'form-control show-tick','title'=>trans('messages.unit')])!!}</div>

<a class="btn btn-success btn-md col-sm-2" id="add-invoice-tax" data-toggle="modal" data-target="#myModal" data-href=""><i class="fa fa-plus" aria-hidden="true"></i>
</a></div>
</div>


<div class="col-xs-6">			
<div class="col-sm-12" style="padding-right:0px;padding-left:0px;">{!! Form::label('currency_id',trans('messages.currency'),['class' => 'control-label'])!!}
</div>
<div class="btn-group col-sm-12" role="group" aria-label="Button group with nested dropdown" style="padding-left:0px;padding-right:0px;">
<div class="btn-group col-sm-10" style="padding-left:0px;padding-right:0px;">
				{!! Form::select('currency_id', $currencies , isset($item) ? $item->currency_id: '',['class'=>'form-control show-tick','title'=>trans('messages.currency')])!!}</div>

<a class="btn btn-success btn-md col-sm-2" id="add-invoice-tax" data-toggle="modal" data-target="#myModal" data-href="/currency/create" ><i class="fa fa-plus" aria-hidden="true"></i>
</a></div>
</div>
			</div>
			
			<div class="row">
<div class="col-xs-6">
			{!! Form::label('unit_price',trans('messages.price'),[])!!}
			{!! Form::input('numeric','unit_price',isset($item) ? $item->unit_price: '',['class'=>'form-control','placeholder'=>trans('messages.price')])!!}
			</div>	
<div class="col-xs-6">
			{!! Form::label('discount',trans('messages.discount').' (%)',[])!!}
			{!! Form::input('numeric','discount',isset($item) ? $item->discount : '',['class'=>'form-control','placeholder'=>trans('messages.discount')])!!}
			</div>	

		</div>

			
<div class="row">
<div class="form-group">
<div class="col-sm-12">
{!! Form::label('item_category_id',trans('messages.item').' '.trans('messages.category'),['class' => 'control-label'])!!}
</div>
<div class="col-sm-12">
<div class="btn-group col-sm-12" role="group" aria-label="Button group with nested dropdown" style="padding-left:0px;padding-right:0px;">
<div class="btn-group col-sm-10" style="padding-left:0px;padding-right:0px;">
				{!! Form::select('item_category_id', $currencies , isset($item) ? $item->item_category_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
</div>
<a class="btn btn-success btn-md col-sm-2" id="add-invoice-tax" data-toggle="modal" data-target="#myModal" data-href=""><i class="fa fa-plus" aria-hidden="true"></i>
</a></div>
</div></div></div>
		
<div class="row">
<div class="form-group">
<div class="col-sm-12">
{!! Form::label('taxation_id',trans('messages.taxation').' '.trans('messages.group'),['class' => 'control-label'])!!}
</div>
<div class="col-sm-12">
<div class="btn-group col-sm-12" role="group" aria-label="Button group with nested dropdown" style="padding-left:0px;padding-right:0px;">
<div class="btn-group col-sm-10" style="padding-left:0px;padding-right:0px;">
				{!! Form::select('taxation_id', $currencies , isset($item) ? $item->taxation_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
</div> 
<a class="btn btn-success btn-md col-sm-2" id="add-invoice-tax" data-toggle="modal" data-target="#myModal" data-href=""><i class="fa fa-plus" aria-hidden="true"></i></a>
</div></div>
</div></div>
</div>





	</div>
	{{ getCustomFields('item-form',$custom_field_values) }}
	{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
