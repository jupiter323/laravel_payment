			<div class="col-sm-6">
                   <div class="form-group">
			    {!! Form::label('name',trans('messages.commercial').' '.trans('messages.data'),[])!!}
				{!! Form::input('text','name',(isset($company) ? $company->name : ''),['class'=>'form-control','placeholder'=>trans('messages.commercial').' '.trans('messages.name')])!!}
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
{!! Form::select('tax_regimen', $taxregimen,(isset($company) ? $company->tax_regimen: ''),['class'=>'form-control show-tick','title'=>trans('messages.tax_regimen')])!!}
</div>

                       <div class="form-group">
			    {!! Form::label('name',trans('messages.tax_certificate'),[])!!}
                        <div class="row">
                      <!-- <div class="col-xs-3">{!! Form::label('name',trans('messages.private'),[])!!}</div>-->
                         <div class="col-xs-12">
			<!--{!! Form::input('file','private',(isset($company) ? $company->private: ''),['class'=>'form-control','placeholder'=>trans('messages.private')])!!}-->
@include('upload.index',['module' => 'company','upload_button' => trans('messages.private'),'module_id' => isset($company) ? $company->private: ''])




			  </div>
                     </div>
                 </div>

                            <div class="form-group">	
 <div class="row">
<!-- <div class="col-xs-3">{!! Form::label('name',trans('messages.public'),[])!!}</div>-->
                         <div class="col-xs-12">		    
				<!--{!! Form::input('file','public',(isset($company) ? $company->public: ''),['class'=>'form-control btn btn-primary btn-sm','placeholder'=>trans('messages.public')])!!}-->

@include('upload.index',['module' => 'company','upload_button' => trans('messages.public'),'module_id' => isset($company) ? $company->public: ''])


			  </div>
                 </div>
                 </div>


 <div class="form-group">
  <div class="row">	
<div class="col-xs-3">{!! Form::label('name',trans('messages.pass'),[])!!}</div>
                         <div class="col-xs-9">		    		    
				{!! Form::input('password','pass',(isset($company) ? $company->pass: ''),['class'=>'form-control','placeholder'=>trans('messages.pass')])!!}
			  </div>
                 </div>
                 </div>
			  
			  <div class="form-group">
			     {!! Form::label('name',trans('messages.contact').' '.trans('messages.data'),[])!!}
				{!! Form::input('text','website',(isset($company) ? $company->website : ''),['class'=>'form-control','placeholder'=>trans('messages.website')])!!}
			  </div>
			  <div class="form-group">
			   
				{!! Form::input('text','email',(isset($company) ? $company->email : ''),['class'=>'form-control','placeholder'=>trans('messages.email')])!!}
			  </div>
			  <div class="form-group">
			   
				{!! Form::input('text','phone',(isset($company) ? $company->phone : ''),['class'=>'form-control','placeholder'=>trans('messages.phone')])!!}
			  </div>



			  <div class="form-group">
			     {!! Form::label('name',trans('messages.logo'),[])!!}
                                    <div class="row">
                                        <div class="col-xs-6">{!! Form::label('name',trans('messages.logo_for_app'),[])!!}</div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                              <input type="file" class="btn btn-default file-input" name="logo" id="logo" data-buttonText="{!! trans('messages.select').' '.trans('messages.logo_for_app') !!}">




                                            </div>
                                        </div>
                                    </div>

 <div class="row">
           <div class="col-xs-6">{!! Form::label('name',trans('messages.logo_for_mail'),[])!!}</div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="file" class="btn btn-default file-input" name="email_logo" id="email_logo" data-buttonText="{!! trans('messages.select').' '.trans('messages.logo_for_mail') !!}">
                                            </div>
                                        </div>
                                    </div>
                                    
                               </div>
</div>
			<div class="col-sm-6">
				<div class="form-group">
				    {!! Form::label('address',trans('messages.address'),[])!!}

<div class="form-group">

					{!! Form::select('country_id', config('country'),(isset($company) ? $company->country_id : ''),['class'=>'form-control show-tick','title'=>trans('messages.country')])!!}
</div>


<div class="row">
						<div class="col-xs-5">
						{!! Form::input('text','ext_num',(isset($company) ? $company->ext_num: ''),['class'=>'form-control','placeholder'=>trans('messages.ext_num')])!!}
						</div>
						<div class="col-xs-4">
						{!! Form::input('text','int_num',(isset($company) ? $company->int_num: ''),['class'=>'form-control','placeholder'=>trans('messages.int_num')])!!}
						</div>
						<div class="col-xs-3">
						{!! Form::input('text','zipcode',(isset($company) ? $company->zipcode : ''),['class'=>'form-control','placeholder'=>trans('messages.zipcode')])!!}
						</div>
					</div>
					<br />
<div class="form-group">
{!! Form::input('text','state',(isset($company) ? $company->state : ''),['class'=>'form-control','placeholder'=>trans('messages.state')])!!}
</div>

<div class="form-group">
{!! Form::input('text','city',(isset($company) ? $company->city : ''),['class'=>'form-control','placeholder'=>trans('messages.city')])!!}
</div>
<div class="form-group">
{!! Form::input('text','address_line_2',(isset($company) ? $company->address_line_2 : ''),['class'=>'form-control','placeholder'=>trans('messages.location')])!!}
</div>	
<div class="form-group">
					{!! Form::select('neighboorhood', $neighbourhood,(isset($company) ? $company->neighboorhood: ''),['class'=>'form-control show-tick','title'=>trans('messages.neighboorhood')])!!}
</div>
					{!! Form::input('text','address_line_1',(isset($company) ? $company->address_line_1 : ''),['class'=>'form-control','placeholder'=>trans('messages.street')])!!}
					
					
					<br />
					







		</div>
				{{ getCustomFields('company-form',$custom_field_values) }}
			  	{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
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
