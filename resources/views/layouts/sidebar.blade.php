        <div class="left side-menu">
            <div class="body rows scroll-y">
             <div class="sidebar-inner slimscroller">
<?php
$company=\App\Company::pluck('name','id')->all();
 ?>

<div class="row">
<div class="form-group">
<div class="col-sm-12" >					
<div class="btn-group col-sm-12" role="group" aria-label="Button group with nested dropdown" style="padding-left:0px;padding-right:0px;">
<div class="btn-group col-sm-10" style="padding-left:0px;padding-right:0px;">
{!! Form::select('id',$company,isset($company) ? $company: '',['class'=>'form-control show-tick','id'=>'company','title'=>trans('messages.company')])!!}</div>
<a class="btn btn-success btn-md col-sm-2" id="add-invoice-tax" data-toggle="modal" data-target="#myModal" data-href="/company/create" ><i class="fa fa-plus" aria-hidden="true"></i>
</a></div>
</div></div></div>


                   <!-- <div class="media">
                        <a class="pull-left" href="#">
                            {!!getAvatar(Auth::user()->id,60)!!}
                        </a>
                        <div class="media-body">
                            {{trans('messages.welcome')}},
                            <h4 class="media-heading"><strong>{{Auth::user()->full_name}}</strong></h4>-->
                            <!--<small>{{trans('messages.last_login').' '.Auth::user()->last_login}}
                            @if(Auth::user()->last_login_ip)
                            | {{trans('messages.from').' '.Auth::user()->last_login_ip}}
                            @endif
                            </small>-->
                        <!-- </div>
                    </div>-->

 
                    <div id="sidebar-menu">
                        <ul id="sidebar-menu-list">
                        </ul>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>



 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.0/jquery.js"></script>

<script>   
$('#company').on("change",function() {
$company_id=this.value;
console.log(this.value);
            $.ajax({
                url: '/customer-company',
                type: 'GET',
                data: { id: $company_id},
                dataType : 'json',
                success: function(resp)
                {     
                     console.log(resp);                  
                        window.location.reload();

                 }
                     
                
            });
       });
   
</script>