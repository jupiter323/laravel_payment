@extends('layouts.app')

@section('content')
    @if(!Entrust::hasRole(config('constant.default_customer_role')))
        @if(defaultRole())
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="box-info">
                                <div class="icon-box">
                                    <span class="fa-stack">
                                      <i class="fa fa-circle fa-stack-2x info"></i>
                                      <i class="fa fa-users fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="text-box">
                                    <h3 class="show-count">{{\App\User::whereHas('roles',function($query){
                                        $query->where('name',config('constant.default_customer_role'));
                                    })->count()}}</h3>
                                    <p>{{trans('messages.customer')}}</p>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="box-info">
                                <div class="icon-box">
                                    <span class="fa-stack">
                                      <i class="fa fa-circle fa-stack-2x success"></i>
                                      <i class="fa fa-list-alt fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="text-box">
                                    <h3 class="show-count">{{\App\Invoice::count()}}</h3>
                                    <p>{{trans('messages.invoice')}}</p>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="box-info">
                                <div class="icon-box">
                                    <span class="fa-stack">
                                      <i class="fa fa-circle fa-stack-2x warning"></i>
                                      <i class="fa fa-folder fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="text-box">
                                    <h3 class="show-count">{{\App\Quotation::count()}}</h3>
                                    <p>{{trans('messages.quotation')}}</p>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="box-info">
                                <div class="icon-box">
                                    <span class="fa-stack">
                                      <i class="fa fa-circle fa-stack-2x danger"></i>
                                      <i class="fa fa-random fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="text-box">
                                    <h3 class="show-count">{{\App\Transaction::count()}}</h3>
                                    <p>{{trans('messages.transaction')}}</p>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box-info full">
                        <h2><strong>{{trans('messages.account')}}</strong></h2>
                        <div class="additional-btn">
                            <a href="/account" class="btn btn-xs btn-primary">{{trans('messages.view')}}</a>
                        </div>
                        <div class="table-responsive">
                            <table data-sortable class="table table-hover table-striped ajax-table show-table" id="account-summary-table" data-source="/account/summary">
                                <thead>
                                    <tr>
                                        <th>{!! trans('messages.name') !!}</th>
                                        <th>{!! trans('messages.type') !!}</th>
                                        <th>{!! trans('messages.last').' '.trans('messages.transaction') !!}</th>
                                        <th>{!! trans('messages.balance') !!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="box-info">
                    <div id="invoice-payment-status-graph" style="height:300px;"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box-info">
                    <div id="quotation-status-graph" style="height:300px;"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="box-info">
                    <div id="monthly-income-expense" style="height:300px;"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box-info full">
                    <ul class="nav nav-tabs nav-justified tab-list">
                      <li><a href="#recent-invoice-tab" data-toggle="tab"><i class="fa fa-star"></i> {!! trans('messages.recent').' '.trans('messages.invoice') !!}</a></li>
                      <li><a href="#unpaid-invoice-tab" data-toggle="tab"><i class="fa fa-times"></i> {!! trans('messages.unpaid').' '.trans('messages.invoice') !!}</a></li>
                      <li><a href="#partially-paid-invoice-tab" data-toggle="tab"><i class="fa fa-battery-half"></i> {!! trans('messages.partially_paid').' '.trans('messages.invoice') !!}</a></li>
                      <li><a href="#overdue-invoice-tab" data-toggle="tab"><i class="fa fa-fire"></i> {!! trans('messages.overdue').' '.trans('messages.invoice') !!}</a></li>
                      <li><a href="#recurring-invoice-tab" data-toggle="tab"><i class="fa fa-repeat"></i> {!! trans('messages.recurring').' '.trans('messages.invoice') !!}</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane animated fadeInRight" id="recent-invoice-tab">
                            <div class="user-profile-content custom-scrollbar">
                                <div class="table-responsive">
                                    <table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="recent-invoice-table" data-source="/invoice/fetch" data-extra="&type=recent">
                                        <thead>
                                            <tr>
                                                <th>{!! trans('messages.number') !!}</th>
                                                <th>{!! trans('messages.customer') !!}</th>
                                                <th>{!! trans('messages.amount') !!}</th>
                                                <th>{!! trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.due').' '.trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.status') !!}</th>
                                                <th data-sortable="false">{!! trans('messages.option') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane animated fadeInRight" id="unpaid-invoice-tab">
                            <div class="user-profile-content custom-scrollbar">
                                <div class="table-responsive">
                                    <table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="unpaid-invoice-table" data-source="/invoice/fetch" data-extra="&type=unpaid">
                                        <thead>
                                            <tr>
                                                <th>{!! trans('messages.number') !!}</th>
                                                <th>{!! trans('messages.customer') !!}</th>
                                                <th>{!! trans('messages.amount') !!}</th>
                                                <th>{!! trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.due').' '.trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.status') !!}</th>
                                                <th data-sortable="false">{!! trans('messages.option') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane animated fadeInRight" id="partially-paid-invoice-tab">
                            <div class="user-profile-content custom-scrollbar">
                                <div class="table-responsive">
                                    <table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="partially-paid-invoice-table" data-source="/invoice/fetch" data-extra="&type=partially_paid">
                                        <thead>
                                            <tr>
                                                <th>{!! trans('messages.number') !!}</th>
                                                <th>{!! trans('messages.customer') !!}</th>
                                                <th>{!! trans('messages.amount') !!}</th>
                                                <th>{!! trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.due').' '.trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.status') !!}</th>
                                                <th data-sortable="false">{!! trans('messages.option') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane animated fadeInRight" id="overdue-invoice-tab">
                            <div class="user-profile-content custom-scrollbar">
                                <div class="table-responsive">
                                    <table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="overdue-invoice-table" data-source="/invoice/fetch" data-extra="&type=overdue">
                                        <thead>
                                            <tr>
                                                <th>{!! trans('messages.number') !!}</th>
                                                <th>{!! trans('messages.customer') !!}</th>
                                                <th>{!! trans('messages.amount') !!}</th>
                                                <th>{!! trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.due').' '.trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.status') !!}</th>
                                                <th data-sortable="false">{!! trans('messages.option') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane animated fadeInRight" id="recurring-invoice-tab">
                            <div class="user-profile-content custom-scrollbar">
                                <div class="table-responsive">
                                    <table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="recurring-invoice-table" data-source="/invoice/fetch" data-extra="&type=recurring">
                                        <thead>
                                            <tr>
                                                <th>{!! trans('messages.number') !!}</th>
                                                <th>{!! trans('messages.customer') !!}</th>
                                                <th>{!! trans('messages.amount') !!}</th>
                                                <th>{!! trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.due').' '.trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.status') !!}</th>
                                                <th data-sortable="false">{!! trans('messages.option') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box-info full">
                    <ul class="nav nav-tabs nav-justified tab-list">
                      <li><a href="#recent-quotation-tab" data-toggle="tab"><i class="fa fa-star"></i> {!! trans('messages.recent').' '.trans('messages.quotation') !!}</a></li>
                      <li><a href="#accepted-quotation-tab" data-toggle="tab"><i class="fa fa-thumbs-up"></i> {!! trans('messages.quotation_accepted').' '.trans('messages.quotation') !!}</a></li>
                      <li><a href="#expired-quotation-tab" data-toggle="tab"><i class="fa fa-thumbs-down"></i> {!! trans('messages.expired').' '.trans('messages.quotation') !!}</a></li>
                      <li><a href="#recent-income-tab" data-toggle="tab"><i class="fa fa-arrow-down"></i> {!! trans('messages.recent').' '.trans('messages.income') !!}</a></li>
                      <li><a href="#recent-expense-tab" data-toggle="tab"><i class="fa fa-arrow-up"></i> {!! trans('messages.recent').' '.trans('messages.expense') !!}</a></li>
                      <li><a href="#recent-account-transfer-tab" data-toggle="tab"><i class="fa fa-random"></i> {!! trans('messages.recent').' '.trans('messages.transfer') !!}</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane animated fadeInRight" id="recent-quotation-tab">
                            <div class="user-profile-content custom-scrollbar">
                                <div class="table-responsive">
                                    <table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="recent-quotation-table" data-source="/quotation/fetch" data-extra="&type=recent">
                                        <thead>
                                            <tr>
                                                <th>{!! trans('messages.number') !!}</th>
                                                <th>{!! trans('messages.customer') !!}</th>
                                                <th>{!! trans('messages.amount') !!}</th>
                                                <th>{!! trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.expiry').' '.trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.status') !!}</th>
                                                <th data-sortable="false">{!! trans('messages.option') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane animated fadeInRight" id="accepted-quotation-tab">
                            <div class="user-profile-content custom-scrollbar">
                                <div class="table-responsive">
                                    <table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="accepted-quotation-table" data-source="/quotation/fetch" data-extra="&type=accepted">
                                        <thead>
                                            <tr>
                                                <th>{!! trans('messages.number') !!}</th>
                                                <th>{!! trans('messages.customer') !!}</th>
                                                <th>{!! trans('messages.amount') !!}</th>
                                                <th>{!! trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.expiry').' '.trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.status') !!}</th>
                                                <th data-sortable="false">{!! trans('messages.option') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane animated fadeInRight" id="expired-quotation-tab">
                            <div class="user-profile-content custom-scrollbar">
                                <div class="table-responsive">
                                    <table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="expired-quotation-table" data-source="/quotation/fetch" data-extra="&type=expired">
                                        <thead>
                                            <tr>
                                                <th>{!! trans('messages.number') !!}</th>
                                                <th>{!! trans('messages.customer') !!}</th>
                                                <th>{!! trans('messages.amount') !!}</th>
                                                <th>{!! trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.expiry').' '.trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.status') !!}</th>
                                                <th data-sortable="false">{!! trans('messages.option') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane animated fadeInRight" id="recent-income-tab">
                            <div class="user-profile-content custom-scrollbar">
                                <div class="table-responsive">
                                    <table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="income-transaction-table" data-source="/transaction/fetch" data-extra="&type=income">
                                        <thead>
                                            <tr>
                                                <th>{!! trans('messages.token') !!}</th>
                                                <th>{!! trans('messages.amount') !!}</th>
                                                <th>{!! trans('messages.method') !!}</th>
                                                <th>{!! trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.option') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane animated fadeInRight" id="recent-expense-tab">
                            <div class="user-profile-content custom-scrollbar">
                                <div class="table-responsive">
                                    <table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="expense-transaction-table" data-source="/transaction/fetch" data-extra="&type=expense">
                                        <thead>
                                            <tr>
                                                <th>{!! trans('messages.token') !!}</th>
                                                <th>{!! trans('messages.amount') !!}</th>
                                                <th>{!! trans('messages.method') !!}</th>
                                                <th>{!! trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.option') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane animated fadeInRight" id="recent-account-transfer-tab">
                            <div class="user-profile-content custom-scrollbar">
                                <div class="table-responsive">
                                    <table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="account-transfer-transaction-table" data-source="/transaction/fetch" data-extra="&type=account_transfer">
                                        <thead>
                                            <tr>
                                                <th>{!! trans('messages.token') !!}</th>
                                                <th>{!! trans('messages.amount') !!}</th>
                                                <th>{!! trans('messages.method') !!}</th>
                                                <th>{!! trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.option') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @include('announcement.home');
            <div class="col-sm-6">
                <div class="box-info">
                    <h2><strong>{!! trans('messages.company').' '.trans('messages.hierarchy') !!}</strong></h2>
                    <div class="custom-scrollbar" >
                        <h4><strong>{!! Auth::user()->full_name.' : '.Auth::user()->designation_with_department.', <small>'.trans('messages.no_of_subordinates').' : '.$child_staff_count !!}</small>
                        </strong></h4>
                        {!! createLineTreeView($tree,Auth::user()->Profile->designation_id) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="box-info">
                    <h2>
                        <strong>{{trans('messages.calendar')}}</strong>
                    </h2>
                    <div id="render_calendar">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @if(config('config.enable_group_chat'))
                <div class="box-info">
                    <h2>
                        <strong>{{trans('messages.group')}}</strong> {{trans('messages.chat')}}
                    </h2>
                    <div id="chat-box" class="chat-widget custom-scrollbar">
                        <div id="chat-messages" data-chat-refresh="{{config('config.enable_chat_refresh')}}" data-chat-refresh-duration="{{ config('config.chat_refresh_duration') }}"></div>
                    </div>
                    {!! Form::open(['route' => 'chat.store','role' => 'form', 'class'=>'chat-form input-chat','id' => 'chat-form','data-refresh' => 'chat-messages']) !!}
                    {!! Form::input('text','message','',['class'=>'form-control','data-autoresize' => 1,'placeholder' => 'Type your message here..'])!!}
                    {!! Form::close() !!}
                </div>
                @endif
                <div class="box-info">
                    <h2>
                        <strong>{{trans('messages.celebration')}}</strong>
                    </h2>
                    <div id="chat-box" class="chat-widget custom-scrollbar">
                        @if(count($celebrations))
                        <ul class="media-list">
                        @foreach($celebrations as $celebration)
                          <li class="media">
                            <a class="pull-left" href="#">
                              {!! getAvatar($celebration['id'],55) !!}
                            </a>
                            <div class="media-body success">
                              <p class="media-heading"><i class="fa fa-{{ $celebration['icon'] }} icon" style="margin-right:10px;"></i> {{ $celebration['title'] }} ({!! $celebration['number'] !!})</p>
                              <p style="margin-bottom:5px;"><strong>{!! $celebration['name'] !!}</strong></p>
                            </div>
                          </li>
                        @endforeach
                        </ul>
                        @else
                            @include('global.notification',['message' => trans('messages.no_data_found'),'type' =>'danger'])</div>
                        @endif  
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="box-info">
                            <div class="icon-box">
                                <span class="fa-stack">
                                  <i class="fa fa-circle fa-stack-2x success"></i>
                                  <i class="fa fa-list-alt fa-stack-1x fa-inverse"></i>
                                </span>
                            </div>
                            <div class="text-box">
                                <h3 class="show-count">{{\App\Invoice::whereCustomerId(Auth::user()->id)->count()}}</h3>
                                <p>{{trans('messages.invoice')}}</p>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="box-info">
                            <div class="icon-box">
                                <span class="fa-stack">
                                  <i class="fa fa-circle fa-stack-2x warning"></i>
                                  <i class="fa fa-folder fa-stack-1x fa-inverse"></i>
                                </span>
                            </div>
                            <div class="text-box">
                                <h3 class="show-count">{{\App\Quotation::whereCustomerId(Auth::user()->id)->count()}}</h3>
                                <p>{{trans('messages.quotation')}}</p>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="box-info">
                            <div class="icon-box">
                                <span class="fa-stack">
                                  <i class="fa fa-circle fa-stack-2x danger"></i>
                                  <i class="fa fa-random fa-stack-1x fa-inverse"></i>
                                </span>
                            </div>
                            <div class="text-box">
                                <h3 class="show-count">{{\App\Transaction::whereCustomerId(Auth::user()->id)->count()}}</h3>
                                <p>{{trans('messages.transaction')}}</p>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
            @include('announcement.home')
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box-info full">
                    <ul class="nav nav-tabs nav-justified tab-list">
                      <li><a href="#recent-invoice-tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {!! trans('messages.recent').' '.trans('messages.invoice') !!}</a></li>
                      <li><a href="#recent-quotation-tab" data-toggle="tab"><i class="fa fa-folder"></i> {!! trans('messages.recent').' '.trans('messages.quotation') !!}</a></li>
                      <li><a href="#recent-transaction-tab" data-toggle="tab"><i class="fa fa-money"></i> {!! trans('messages.recent').' '.trans('messages.transaction') !!}</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane animated fadeInRight" id="recent-invoice-tab">
                            <div class="user-profile-content custom-scrollbar">
                                <div class="table-responsive">
                                    <table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="customer-invoice-table" data-source="/invoice/fetch" data-extra="&type=customer">
                                        <thead>
                                            <tr>
                                                <th>{!! trans('messages.number') !!}</th>
                                                <th>{!! trans('messages.customer') !!}</th>
                                                <th>{!! trans('messages.amount') !!}</th>
                                                <th>{!! trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.due').' '.trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.status') !!}</th>
                                                <th data-sortable="false">{!! trans('messages.option') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane animated fadeInRight" id="recent-quotation-tab">
                            <div class="user-profile-content custom-scrollbar">
                                <div class="table-responsive">
                                    <table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="customer-quotation-table" data-source="/quotation/fetch" data-extra="&type=customer">
                                        <thead>
                                            <tr>
                                                <th>{!! trans('messages.number') !!}</th>
                                                <th>{!! trans('messages.customer') !!}</th>
                                                <th>{!! trans('messages.amount') !!}</th>
                                                <th>{!! trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.due').' '.trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.status') !!}</th>
                                                <th data-sortable="false">{!! trans('messages.option') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane animated fadeInRight" id="recent-transaction-tab">
                            <div class="user-profile-content custom-scrollbar">
                                <div class="table-responsive">
                                    <table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="customer-transaction-table" data-source="/transaction/fetch" data-extra="&type=customer">
                                        <thead>
                                            <tr>
                                                <th>{!! trans('messages.token') !!}</th>
                                                <th>{!! trans('messages.amount') !!}</th>
                                                <th>{!! trans('messages.method') !!}</th>
                                                <th>{!! trans('messages.date') !!}</th>
                                                <th>{!! trans('messages.option') !!}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('right_sidebar')
    <h4><strong>{{trans('messages.title')}}</strong></h4>
      <div class="custom-scrollbar" style="margin: 25px 10px 100px 10px;max-height: 75%;">
      </div>
@endsection
