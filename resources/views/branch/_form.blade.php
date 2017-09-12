			<div class="col-sm-6">

 <div class="form-group">
                                {!! Form::label('company_id',trans('messages.company'),[])!!}
                                {!! Form::select('company_id', $companies,'',['class'=>'form-control show-tick','title' => trans('messages.select_one')])!!}
                            </div>
                   <div class="form-group">
			    {!! Form::label('name',trans('messages.branch').' '.trans('messages.data'),[])!!}
				{!! Form::input('text','branch_name',(isset($branch) ? $branch->branch_name : ''),['class'=>'form-control','placeholder'=>trans('messages.branch').' '.trans('messages.name')])!!}
			  </div>

                     <div class="form-group">			    
				{!! Form::input('text','branch_code',(isset($branch) ? $branch->branch_code: ''),['class'=>'form-control','placeholder'=>trans('messages.branch_code')])!!}
			  </div>

			  
			 
<div class="form-group">
			   
				{!! Form::input('text','branch_main_officer_name',(isset($branch) ? $branch->branch_main_officer_name: ''),['class'=>'form-control','placeholder'=>trans('messages.main_branch_office')])!!}
			  </div>
			  <div class="form-group">
			   
				{!! Form::input('text','email',(isset($branch) ? $branch->email : ''),['class'=>'form-control','placeholder'=>trans('messages.email')])!!}
			  </div>
			  <div class="form-group">
			   
				{!! Form::input('text','phone',(isset($branch) ? $branch->phone : ''),['class'=>'form-control','placeholder'=>trans('messages.phone')])!!}
			  </div>
</div>


			 
			<div class="col-sm-6">
				<div class="form-group">
				    {!! Form::label('address',trans('messages.address'),[])!!}

<div class="form-group">

					{!! Form::select('country_id', config('country'),(isset($branch) ? $branch->country_id : ''),['class'=>'form-control show-tick','title'=>trans('messages.country')])!!}
</div>


<div class="row">
						<div class="col-xs-5">
						{!! Form::input('text','ext_num',(isset($branch) ? $branch->ext_num: ''),['class'=>'form-control','placeholder'=>trans('messages.ext_num')])!!}
						</div>
						<div class="col-xs-4">
						{!! Form::input('text','int_num',(isset($branch) ? $branch->int_num: ''),['class'=>'form-control','placeholder'=>trans('messages.int_num')])!!}
						</div>
						<div class="col-xs-3">
						{!! Form::input('text','zipcode',(isset($branch) ? $branch->zipcode : ''),['class'=>'form-control','placeholder'=>trans('messages.zipcode')])!!}
						</div>
					</div>
					<br />
<div class="form-group">
{!! Form::input('text','state',(isset($branch) ? $branch->state : ''),['class'=>'form-control','placeholder'=>trans('messages.state')])!!}
</div>

<div class="form-group">
{!! Form::input('text','city',(isset($branch) ? $branch->city : ''),['class'=>'form-control','placeholder'=>trans('messages.city')])!!}
</div>
<div class="form-group">
{!! Form::input('text','location',(isset($branch) ? $branch->location : ''),['class'=>'form-control','placeholder'=>trans('messages.location')])!!}
</div>	
<div class="form-group">
					{!! Form::select('neighboorhood', $neighbourhood,(isset($branch) ? $branch->neighboorhood: ''),['class'=>'form-control show-tick','title'=>trans('messages.neighboorhood')])!!}
</div>
					{!! Form::input('text','street',(isset($company) ? $company->street : ''),['class'=>'form-control','placeholder'=>trans('messages.street')])!!}
					
					
					<br />
					







		</div>
				{{ getCustomFields('company-form',$custom_field_values) }}
			  	{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
			</div>
