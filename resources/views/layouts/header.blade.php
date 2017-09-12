            <div class="header content rows-content-header">
            
                <button class="button-menu-mobile show-sidebar">
                    <i class="fa fa-bars"></i>
                </button>
                
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <i class="fa fa-angle-double-down">
</i>
                            </button>
                        </div>
                        
                        @if($right_sidebar)
                            <a href="#" class="navbar-toggle toggle-right btn btn-sm" data-toggle="sidebar" data-target=".sidebar-right" style="margin-left:10px;">
                              <i class="fa fa-question-circle icon" data-toggle="tooltip" data-title="Help" data-placement="bottom" style="color:#000000;"></i>
                            </a>
                        @endif

<?php
if (Auth::check())
 {
 $id=Auth::user()->id;
 }   
$profiles=\App\Profile::where('user_id',$id)->get();
foreach ($profiles as $profile)
{
$company_id=$profile['company_id'];
$companys=\App\Company::where('id',$company_id)->get();
}
?>


                        <div class="navbar-collapse collapse">
                        
                            <ul class="nav navbar-nav">
@foreach($companys as $company)

<li><a href="" style="font-size:24px;text-transform:capitalize;">{{$company['name']}}
</a>
</li>
@endforeach

                                <li>
                                    @if(session('parent_login'))
                                        <a href="#" data-ajax="1" data-source="/login-return"><span class="label label-danger">{{trans('messages.login_back_as',['attribute' => \App\User::whereId(session('parent_login'))->first()->full_name])}}</span> </a>
                                    @endif
                                </li>
                            </ul>
                        
                            <ul class="nav navbar-nav navbar-right top-navbar">
                               
                                @if(Entrust::can('manage-todo') && config('config.enable_to_do'))
                                <li><a href="#" data-href="/todo" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-list-ul fa-lg icon" data-toggle="tooltip" title="{!! trans('messages.to_do') !!}" data-placement="bottom"></i></a></li>
                                @endif
                                @if(config('config.multilingual') && Entrust::can('change-localization'))
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-language fa-lg icon" data-toggle="tooltip" title="{!! trans('messages.localization') !!}" data-placement="bottom"></i> </a>
                                    <ul class="dropdown-menu animated half flipInX">
                                        <li class="active"><a href="#" style="color:white;cursor:default;">{!! config('localization.'.session('localization').'.localization').' ('.session('localization').')' !!}</a></li>
                                        @foreach(config('localization') as $key => $localization)
                                            @if(session('localization') != $key)
                                            <li><a href="/change-localization/{{$key}}">{!! $localization['localization']." (".$key.")" !!}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                                @endif

                              
                                <li >
                           
                            {!!getAvatar(Auth::user()->id,40)!!}
                           </li>
                                <li class="dropdown">
                           
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{trans('messages.greeting')}}, <strong>{{Auth::user()->full_name}}</strong> <i class="fa fa-chevron-down i-xs"></i></a>
                                    <ul class="dropdown-menu animated half flipInX">
                                        @if(getMode() && defaultRole())
                                        <li><a href="#" data-href="/check-update" data-toggle='modal' data-target='#myModal'>{!! trans('messages.check').' '.trans('messages.update') !!}</a></li>
                                        <li><a href="/release-license">{!! trans('messages.release_license') !!}</a></li>
                                        @endif
                                        <li class="divider"></li>
                                        <li><a href="/profile"><i class="fa fa-user fa-fw"></i> {{trans('messages.profile')}}</a></li>
                                        <li><a href="#" data-href="/change-password" data-toggle="modal" data-target="#myModal"><i class="fa fa-key fa-fw"></i> {!! trans('messages.change').' '.trans('messages.password') !!}</a></li>
                                        <li><a href="#" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-fw"></i> {{trans('messages.logout')}}</a></li>

<li>
<a href="#" >
{{trans('messages.last_login').' '.Auth::user()->last_login}}
                            @if(Auth::user()->last_login_ip)
                            | {{trans('messages.from').' '.Auth::user()->last_login_ip}}
                            @endif</a>
                           
</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <form id="logout-form" action="/logout" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>