                <div class="row">
                    <div class="col-sm-6">
                       
                        <?php if($type == 'staff'): ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo Form::label('role_id',trans('messages.role'),[]); ?>

                                    <?php echo Form::select('role_id', $roles,'',['class'=>'form-control show-tick']); ?>

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo Form::label('designation_id',trans('messages.designation'),[]); ?>

                                    <?php echo Form::select('designation_id', $designations,'',['class'=>'form-control show-tick','title' => trans('messages.select_one')]); ?>

                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                            <div class="form-group">
                                <?php echo Form::label('company_id',trans('messages.company'),[]); ?>

                                <?php echo Form::select('company_id', $companies,'',['class'=>'form-control show-tick','title' => trans('messages.select_one')]); ?>

                            </div>
                            <div class="form-group">
                                <?php echo Form::label('customer_group_id',trans('messages.group'),[]); ?>

                                <?php echo Form::select('customer_group_id[]', $customer_groups,'',['class'=>'form-control show-tick','multiple' => 'multiple','data-actions-box' => "true"]); ?>

                            </div>
                        <?php endif; ?>
                   


<div class="form-group">
			    <?php echo Form::label('name',trans('messages.commercial').' '.trans('messages.data'),[]); ?>

				<!--<?php echo Form::input('text','name',(isset($company) ? $company->name : ''),['class'=>'form-control','placeholder'=>trans('messages.commercial').' '.trans('messages.name')]); ?>-->
			  </div>

                     <div class="form-group">			    
				<?php echo Form::input('text','internal_alias',(isset($company) ? $company->internal_alias: ''),['class'=>'form-control','placeholder'=>trans('messages.internal')]); ?>

			  </div>


 <div class="form-group">
			    <?php echo Form::label('name',trans('messages.tax_info'),[]); ?>

				<?php echo Form::input('text','tax_reg_name',(isset($company) ? $company->tax_reg_name: ''),['class'=>'form-control','placeholder'=>trans('messages.tax_reg').' '.trans('messages.name')]); ?>

			  </div>

                     <div class="form-group">			    
				<?php echo Form::input('text','tax_id',(isset($company) ? $company->tax_id: ''),['class'=>'form-control','placeholder'=>trans('messages.tax_id')]); ?>

			  </div>


<div class="form-group">			    
<?php echo Form::select('business_type',$business_type,(isset($company) ? $company->business_type: ''),['class'=>'form-control show-tick','id'=>'business_type','title'=>trans('messages.business_type')]); ?>

</div>
 
<div class="form-group">			    
				<?php echo Form::input('text','national_id',(isset($company) ? $company->national_id: ''),['class'=>'form-control','id'=>'national','placeholder'=>trans('messages.national_id'),'style'=>'display:none']); ?>

			  </div>




  <div class="form-group">
			     <?php echo Form::label('name',trans('messages.email').' '.trans('messages.data'),[]); ?>

				<?php echo Form::input('text','contact_name',(isset($company) ? $company->contact_name: ''),['class'=>'form-control','placeholder'=>trans('messages.contact').' '.trans('messages.name')]); ?>  
			  </div>

                       <div class="row">                            
                            <div class="col-sm-4">
                                <div class="form-group">
                                   
                                    <input type="text" class="form-control text-input" name="username" placeholder="<?php echo e(trans('messages.username')); ?>">
                                </div>
                            </div>


<div class="col-sm-4">
                                <div class="form-group">
                                   
                                    <input type="text" class="form-control text-input" name="first_name" placeholder="<?php echo e(trans('messages.first').' '.trans('messages.name')); ?>">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                   
                                    <input type="text" class="form-control text-input" name="last_name" placeholder="<?php echo e(trans('messages.last').' '.trans('messages.name')); ?>">
                                </div>
                            </div>
                        </div>
 <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                  
                                    <input type="password" class="form-control text-input <?php if(config('config.enable_password_strength_meter')): ?> password-strength <?php endif; ?>" name="password" placeholder="<?php echo e(trans('messages.password')); ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    
                                    <input type="password" class="form-control text-input" name="password_confirmation" placeholder="<?php echo e(trans('messages.confirm').' '.trans('messages.password')); ?>">
                                </div>
                            </div>
                        </div>

                         <div class="form-group">			   
				<?php echo Form::input('text','position',(isset($company) ? $company->position: ''),['class'=>'form-control','placeholder'=>trans('messages.position')]); ?>

			  </div>

			  <div class="form-group">
			   
				<?php echo Form::input('text','email',(isset($company) ? $company->email : ''),['class'=>'form-control','placeholder'=>trans('messages.email')]); ?>

			  </div>
			 
 </div>    



      <div class="col-sm-6">
                        <div class="form-group">
                            <?php echo Form::label('address',trans('messages.address'),[]); ?>

 <div class="form-group">
 <?php echo Form::select('country_id', config('country'),(isset($company) ? $company->country_id : ''),['class'=>'form-control show-tick','title'=>trans('messages.country')]); ?>

</div>
<div class="form-group">
<div class="row">
                                <div class="col-xs-5">
                                <?php echo Form::input('text','ext_num',(isset($company) ? $company->ext_num: ''),['class'=>'form-control','placeholder'=>trans('messages.ext_num')]); ?>

                                </div>
                                <div class="col-xs-4">
                                <?php echo Form::input('text','int_num',(isset($company) ? $company->int_num: ''),['class'=>'form-control','placeholder'=>trans('messages.int_num')]); ?>

                                </div>
                                <div class="col-xs-3">
                                <?php echo Form::input('text','zipcode',(isset($company) ? $company->zipcode : ''),['class'=>'form-control','id'=>'zip','placeholder'=>trans('messages.zipcode')]); ?>

                                </div>
                            </div>
</div>
<div class="form-group">
<?php echo Form::input('text','state',(isset($company) ? $company->state : ''),['class'=>'form-control','id'=>'state','placeholder'=>trans('messages.state')]); ?>

</div>

<div class="form-group">
<?php echo Form::input('text','city',(isset($company) ? $company->city : ''),['class'=>'form-control','id'=>'city','placeholder'=>trans('messages.city')]); ?>

</div>

<div class="form-group">
<?php echo Form::input('text','address_line_2',(isset($company) ? $company->address_line_2 : ''),['class'=>'form-control','placeholder'=>trans('messages.location')]); ?>

</div>	
<div class="form-group">
					<?php echo Form::select('neighboorhood',  $neighbourhood,(isset($company) ? $company->neighboorhood: ''),['class'=>'form-control show-tick','title'=>trans('messages.neighboorhood')]); ?>

</div>


                            <?php echo Form::input('text','address_line_1',(isset($company) ? $company->address_line_1 : ''),['class'=>'form-control','placeholder'=>trans('messages.street')]); ?>

                            <br />
                            
                            <br />
                            
                            <br />
                           
                        </div>




                        <?php echo e(getCustomFields('user-registration-form')); ?>

                        <?php if(Auth::check()): ?>
                        <div class="form-group">
                            <input name="send_welcome_email" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1"> <?php echo e(trans('messages.send')); ?> welcome email
                        </div>
                        <?php endif; ?>
                        <?php if(config('config.enable_tnc') && !Auth::check()): ?>
                        <div class="form-group">
                            <input name="tnc" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1"> I accept <a href="#" data-href="/terms-and-conditions" data-toggle="modal" data-target="#myModal">Terms & Conditions</a>.
                        </div>
                        <?php endif; ?>
                        <?php if(config('config.enable_recaptcha') && !Auth::check()): ?>
                        <div class="g-recaptcha" data-sitekey="<?php echo e(config('config.recaptcha_key')); ?>"></div>
                        <br />
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-lock"></i> <?php echo e(trans('messages.create').' '.trans('messages.account')); ?></button>
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