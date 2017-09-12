                <div class="row">
                    <div class="col-sm-6">
                       
                        @if($type == 'staff')
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('role_id',trans('messages.role'),[])!!}
                                    {!! Form::select('role_id', $roles,'',['class'=>'form-control show-tick'])!!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('designation_id',trans('messages.designation'),[])!!}
                                    {!! Form::select('designation_id', $designations,'',['class'=>'form-control show-tick','title' => trans('messages.select_one')])!!}
                                </div>
                            </div>
                        </div>
                        @else
                            <div class="form-group">
                                {!! Form::label('company_id',trans('messages.company'),[])!!}
                                {!! Form::select('company_id', $companies,'',['class'=>'form-control show-tick','title' => trans('messages.select_one')])!!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('customer_group_id',trans('messages.group'),[])!!}
                                {!! Form::select('customer_group_id[]', $customer_groups,'',['class'=>'form-control show-tick','multiple' => 'multiple','data-actions-box' => "true"])!!}
                            </div>
                        @endif
                   


<div class="form-group">
			    {!! Form::label('name',trans('messages.commercial').' '.trans('messages.data'),[])!!}
				<!--{!! Form::input('text','name',(isset($company) ? $company->name : ''),['class'=>'form-control','placeholder'=>trans('messages.commercial').' '.trans('messages.name')])!!}-->
			  </div>

                     <div class="form-group">			    
				{!! Form::input('text','internal_alias',(isset($company) ? $company->internal_alias: ''),['class'=>'form-control','placeholder'=>trans('messages.internal')])!!}
			  </div>


 <div class="form-group">
			    {!! Form::label('name',trans('messages.tax_info'),[])!!}
				{!! Form::input('text','tax_reg_name',(isset($company) ? $company->tax_reg_name: ''),['class'=>'form-control','placeholder'=>trans('messages.tax_reg').' '.trans('messages.name')])!!}
			  </div>

                     <div class="form-group">			    
				{!! Form::input('text','tax_id',(isset($company) ? $company->tax_id: ''),['class'=>'form-control','placeholder'=>trans('messages.tax_id')])!!}
			  </div>


<div class="form-group">			    
{!! Form::select('business_type',$business_type,(isset($company) ? $company->business_type: ''),['class'=>'form-control show-tick','id'=>'business_type','title'=>trans('messages.business_type')])!!}
</div>
 
<div class="form-group">			    
				{!! Form::input('text','national_id',(isset($company) ? $company->national_id: ''),['class'=>'form-control','id'=>'national','placeholder'=>trans('messages.national_id'),'style'=>'display:none'])!!}
			  </div>




  <div class="form-group">
			     {!! Form::label('name',trans('messages.email').' '.trans('messages.data'),[])!!}
				{!! Form::input('text','contact_name',(isset($company) ? $company->contact_name: ''),['class'=>'form-control','placeholder'=>trans('messages.contact').' '.trans('messages.name')])!!}  
			  </div>

                       <div class="row">                            
                            <div class="col-sm-4">
                                <div class="form-group">
                                   
                                    <input type="text" class="form-control text-input" name="username" placeholder="{{trans('messages.username')}}">
                                </div>
                            </div>


<div class="col-sm-4">
                                <div class="form-group">
                                   
                                    <input type="text" class="form-control text-input" name="first_name" placeholder="{{trans('messages.first').' '.trans('messages.name')}}">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                   
                                    <input type="text" class="form-control text-input" name="last_name" placeholder="{{trans('messages.last').' '.trans('messages.name')}}">
                                </div>
                            </div>
                        </div>
 <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                  
                                    <input type="password" class="form-control text-input @if(config('config.enable_password_strength_meter')) password-strength @endif" name="password" placeholder="{{trans('messages.password')}}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    
                                    <input type="password" class="form-control text-input" name="password_confirmation" placeholder="{{trans('messages.confirm').' '.trans('messages.password')}}">
                                </div>
                            </div>
                        </div>

                         <div class="form-group">			   
				{!! Form::input('text','position',(isset($company) ? $company->position: ''),['class'=>'form-control','placeholder'=>trans('messages.position')])!!}
			  </div>

			  <div class="form-group">
			   
				{!! Form::input('text','email',(isset($company) ? $company->email : ''),['class'=>'form-control','placeholder'=>trans('messages.email')])!!}
			  </div>
			 
 </div>    



      <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('address',trans('messages.address'),[])!!}
 <div class="form-group">
 {!! Form::select('country_id', config('country'),(isset($company) ? $company->country_id : ''),['class'=>'form-control show-tick','title'=>trans('messages.country')])!!}
</div>
<div class="form-group">
<div class="row">
                                <div class="col-xs-5">
                                {!! Form::input('text','ext_num',(isset($company) ? $company->ext_num: ''),['class'=>'form-control','placeholder'=>trans('messages.ext_num')])!!}
                                </div>
                                <div class="col-xs-4">
                                {!! Form::input('text','int_num',(isset($company) ? $company->int_num: ''),['class'=>'form-control','placeholder'=>trans('messages.int_num')])!!}
                                </div>
                                <div class="col-xs-3">
                                {!! Form::input('text','zipcode',(isset($company) ? $company->zipcode : ''),['class'=>'form-control','id'=>'zip','placeholder'=>trans('messages.zipcode')])!!}
                                </div>
                            </div>
</div>
<div class="form-group">
{!! Form::input('text','state',(isset($company) ? $company->state : ''),['class'=>'form-control','id'=>'state','placeholder'=>trans('messages.state')])!!}
</div>

<div class="form-group">
{!! Form::input('text','city',(isset($company) ? $company->city : ''),['class'=>'form-control','id'=>'city','placeholder'=>trans('messages.city')])!!}
</div>

<div class="form-group">
{!! Form::input('text','address_line_2',(isset($company) ? $company->address_line_2 : ''),['class'=>'form-control','placeholder'=>trans('messages.location')])!!}
</div>	
<div class="form-group">
					{!! Form::select('neighboorhood',  $neighbourhood,(isset($company) ? $company->neighboorhood: ''),['class'=>'form-control show-tick','title'=>trans('messages.neighboorhood')])!!}
</div>


                            {!! Form::input('text','address_line_1',(isset($company) ? $company->address_line_1 : ''),['class'=>'form-control','placeholder'=>trans('messages.street')])!!}
                            <br />
                            
                            <br />
                            
                            <br />
                           
                        </div>




                        {{ getCustomFields('user-registration-form') }}
                        @if(Auth::check())
                        <div class="form-group">
                            <input name="send_welcome_email" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1"> {{trans('messages.send')}} welcome email
                        </div>
                        @endif
                        @if(config('config.enable_tnc') && !Auth::check())
                        <div class="form-group">
                            <input name="tnc" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1"> I accept <a href="#" data-href="/terms-and-conditions" data-toggle="modal" data-target="#myModal">Terms & Conditions</a>.
                        </div>
                        @endif
                        @if(config('config.enable_recaptcha') && !Auth::check())
                        <div class="g-recaptcha" data-sitekey="{{config('config.recaptcha_key')}}"></div>
                        <br />
                        @endif
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-lock"></i> {{trans('messages.create').' '.trans('messages.account')}}</button>
                            </div>
                        </div>
                    </div>
                </div>

 
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.0/jquery.js"></script>


<script>
$('#zip').blur(function(){
  var zip = $(this).val();
  var city = '';
  var state = '';

  //make a request to the google geocode api
  $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+zip).success(function(response){
    //find the city and state
    var address_components = response.results[0].address_components;
    $.each(address_components, function(index, component){
      var types = component.types;
      $.each(types, function(index, type){
        if(type == 'locality') {
			
          city = component.long_name;
		//  alert(city);
        }
        if(type == 'administrative_area_level_1') {
          state = component.short_name;
		//  alert(state);
        }
      });
    });

    //pre-fill the city and state
    $('#city').val(city);
    $('#state').val(state);
  });
});
</script>


<script>
$(document).ready(function(){
    $('#business_type').on('change', function() {
      if ( this.value == '1')
      {
        $("#national").show();
      }
      else
      {
        $("#national").hide();
      }
    });
});

</script>