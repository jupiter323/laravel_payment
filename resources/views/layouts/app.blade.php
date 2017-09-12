@include('layouts.head')
    <body class="tooltips">
        <div class="container">
            <div class="logo-brand header sidebar rows">
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
                <div class="logo">
                   <!-- <h1><a href="/">{{config('config.application_name')}}</a></h1>-->
@foreach($companys as $company)
                  <img src="/{{ $company['logo'] }}" alt="{{config('config.application_name')}}" style="width:120px;">

                   <!-- <img src="/{{config('config.company_logo')}}" alt="{{config('config.application_name')}}" style="width:120px;">-->
@endforeach


                </div>
            </div>

            @include('layouts.sidebar')

            <div class="right content-page">

                @include('layouts.header')

                <div class="body content rows scroll-y">

                    @yield('breadcrumb')

                    @include('global.message')
                    
                    @yield('content')

                    @include('layouts.footer')

                </div>

            </div>

            @if($right_sidebar)
                <div class="col-xs-7 col-sm-3 col-md-3 sidebar sidebar-right sidebar-animate">
                    @yield('right_sidebar')
                </div>
            @endif
            
        <img id="loading-img" src="/images/loading.gif" />

        <div class="overlay"></div>
        <div class="modal fade-scale" id="myModal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                </div>
            </div>
        </div>

    </div>

    @include('layouts.foot')