<?php $__env->startSection('content'); ?>
    <?php if(!Entrust::hasRole(config('constant.default_customer_role'))): ?>
        <?php if(defaultRole()): ?>
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
                                    <h3 class="show-count"><?php echo e(\App\User::whereHas('roles',function($query){
                                        $query->where('name',config('constant.default_customer_role'));
                                    })->count()); ?></h3>
                                    <p><?php echo e(trans('messages.customer')); ?></p>
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
                                    <h3 class="show-count"><?php echo e(\App\Invoice::count()); ?></h3>
                                    <p><?php echo e(trans('messages.invoice')); ?></p>
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
                                    <h3 class="show-count"><?php echo e(\App\Quotation::count()); ?></h3>
                                    <p><?php echo e(trans('messages.quotation')); ?></p>
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
                                    <h3 class="show-count"><?php echo e(\App\Transaction::count()); ?></h3>
                                    <p><?php echo e(trans('messages.transaction')); ?></p>
                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box-info full">
                        <h2><strong><?php echo e(trans('messages.account')); ?></strong></h2>
                        <div class="additional-btn">
                            <a href="/account" class="btn btn-xs btn-primary"><?php echo e(trans('messages.view')); ?></a>
                        </div>
                        <div class="table-responsive">
                            <table data-sortable class="table table-hover table-striped ajax-table show-table" id="account-summary-table" data-source="/account/summary">
                                <thead>
                                    <tr>
                                        <th><?php echo trans('messages.name'); ?></th>
                                        <th><?php echo trans('messages.type'); ?></th>
                                        <th><?php echo trans('messages.last').' '.trans('messages.transaction'); ?></th>
                                        <th><?php echo trans('messages.balance'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

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
                      <li><a href="#recent-invoice-tab" data-toggle="tab"><i class="fa fa-star"></i> <?php echo trans('messages.recent').' '.trans('messages.invoice'); ?></a></li>
                      <li><a href="#unpaid-invoice-tab" data-toggle="tab"><i class="fa fa-times"></i> <?php echo trans('messages.unpaid').' '.trans('messages.invoice'); ?></a></li>
                      <li><a href="#partially-paid-invoice-tab" data-toggle="tab"><i class="fa fa-battery-half"></i> <?php echo trans('messages.partially_paid').' '.trans('messages.invoice'); ?></a></li>
                      <li><a href="#overdue-invoice-tab" data-toggle="tab"><i class="fa fa-fire"></i> <?php echo trans('messages.overdue').' '.trans('messages.invoice'); ?></a></li>
                      <li><a href="#recurring-invoice-tab" data-toggle="tab"><i class="fa fa-repeat"></i> <?php echo trans('messages.recurring').' '.trans('messages.invoice'); ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane animated fadeInRight" id="recent-invoice-tab">
                            <div class="user-profile-content custom-scrollbar">
                                <div class="table-responsive">
                                    <table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="recent-invoice-table" data-source="/invoice/fetch" data-extra="&type=recent">
                                        <thead>
                                            <tr>
                                                <th><?php echo trans('messages.number'); ?></th>
                                                <th><?php echo trans('messages.customer'); ?></th>
                                                <th><?php echo trans('messages.amount'); ?></th>
                                                <th><?php echo trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.due').' '.trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.status'); ?></th>
                                                <th data-sortable="false"><?php echo trans('messages.option'); ?></th>
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
                                                <th><?php echo trans('messages.number'); ?></th>
                                                <th><?php echo trans('messages.customer'); ?></th>
                                                <th><?php echo trans('messages.amount'); ?></th>
                                                <th><?php echo trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.due').' '.trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.status'); ?></th>
                                                <th data-sortable="false"><?php echo trans('messages.option'); ?></th>
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
                                                <th><?php echo trans('messages.number'); ?></th>
                                                <th><?php echo trans('messages.customer'); ?></th>
                                                <th><?php echo trans('messages.amount'); ?></th>
                                                <th><?php echo trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.due').' '.trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.status'); ?></th>
                                                <th data-sortable="false"><?php echo trans('messages.option'); ?></th>
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
                                                <th><?php echo trans('messages.number'); ?></th>
                                                <th><?php echo trans('messages.customer'); ?></th>
                                                <th><?php echo trans('messages.amount'); ?></th>
                                                <th><?php echo trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.due').' '.trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.status'); ?></th>
                                                <th data-sortable="false"><?php echo trans('messages.option'); ?></th>
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
                                                <th><?php echo trans('messages.number'); ?></th>
                                                <th><?php echo trans('messages.customer'); ?></th>
                                                <th><?php echo trans('messages.amount'); ?></th>
                                                <th><?php echo trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.due').' '.trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.status'); ?></th>
                                                <th data-sortable="false"><?php echo trans('messages.option'); ?></th>
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
                      <li><a href="#recent-quotation-tab" data-toggle="tab"><i class="fa fa-star"></i> <?php echo trans('messages.recent').' '.trans('messages.quotation'); ?></a></li>
                      <li><a href="#accepted-quotation-tab" data-toggle="tab"><i class="fa fa-thumbs-up"></i> <?php echo trans('messages.quotation_accepted').' '.trans('messages.quotation'); ?></a></li>
                      <li><a href="#expired-quotation-tab" data-toggle="tab"><i class="fa fa-thumbs-down"></i> <?php echo trans('messages.expired').' '.trans('messages.quotation'); ?></a></li>
                      <li><a href="#recent-income-tab" data-toggle="tab"><i class="fa fa-arrow-down"></i> <?php echo trans('messages.recent').' '.trans('messages.income'); ?></a></li>
                      <li><a href="#recent-expense-tab" data-toggle="tab"><i class="fa fa-arrow-up"></i> <?php echo trans('messages.recent').' '.trans('messages.expense'); ?></a></li>
                      <li><a href="#recent-account-transfer-tab" data-toggle="tab"><i class="fa fa-random"></i> <?php echo trans('messages.recent').' '.trans('messages.transfer'); ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane animated fadeInRight" id="recent-quotation-tab">
                            <div class="user-profile-content custom-scrollbar">
                                <div class="table-responsive">
                                    <table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="recent-quotation-table" data-source="/quotation/fetch" data-extra="&type=recent">
                                        <thead>
                                            <tr>
                                                <th><?php echo trans('messages.number'); ?></th>
                                                <th><?php echo trans('messages.customer'); ?></th>
                                                <th><?php echo trans('messages.amount'); ?></th>
                                                <th><?php echo trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.expiry').' '.trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.status'); ?></th>
                                                <th data-sortable="false"><?php echo trans('messages.option'); ?></th>
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
                                                <th><?php echo trans('messages.number'); ?></th>
                                                <th><?php echo trans('messages.customer'); ?></th>
                                                <th><?php echo trans('messages.amount'); ?></th>
                                                <th><?php echo trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.expiry').' '.trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.status'); ?></th>
                                                <th data-sortable="false"><?php echo trans('messages.option'); ?></th>
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
                                                <th><?php echo trans('messages.number'); ?></th>
                                                <th><?php echo trans('messages.customer'); ?></th>
                                                <th><?php echo trans('messages.amount'); ?></th>
                                                <th><?php echo trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.expiry').' '.trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.status'); ?></th>
                                                <th data-sortable="false"><?php echo trans('messages.option'); ?></th>
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
                                                <th><?php echo trans('messages.token'); ?></th>
                                                <th><?php echo trans('messages.amount'); ?></th>
                                                <th><?php echo trans('messages.method'); ?></th>
                                                <th><?php echo trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.option'); ?></th>
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
                                                <th><?php echo trans('messages.token'); ?></th>
                                                <th><?php echo trans('messages.amount'); ?></th>
                                                <th><?php echo trans('messages.method'); ?></th>
                                                <th><?php echo trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.option'); ?></th>
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
                                                <th><?php echo trans('messages.token'); ?></th>
                                                <th><?php echo trans('messages.amount'); ?></th>
                                                <th><?php echo trans('messages.method'); ?></th>
                                                <th><?php echo trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.option'); ?></th>
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
            <?php echo $__env->make('announcement.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>;
            <div class="col-sm-6">
                <div class="box-info">
                    <h2><strong><?php echo trans('messages.company').' '.trans('messages.hierarchy'); ?></strong></h2>
                    <div class="custom-scrollbar" >
                        <h4><strong><?php echo Auth::user()->full_name.' : '.Auth::user()->designation_with_department.', <small>'.trans('messages.no_of_subordinates').' : '.$child_staff_count; ?></small>
                        </strong></h4>
                        <?php echo createLineTreeView($tree,Auth::user()->Profile->designation_id); ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="box-info">
                    <h2>
                        <strong><?php echo e(trans('messages.calendar')); ?></strong>
                    </h2>
                    <div id="render_calendar">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <?php if(config('config.enable_group_chat')): ?>
                <div class="box-info">
                    <h2>
                        <strong><?php echo e(trans('messages.group')); ?></strong> <?php echo e(trans('messages.chat')); ?>

                    </h2>
                    <div id="chat-box" class="chat-widget custom-scrollbar">
                        <div id="chat-messages" data-chat-refresh="<?php echo e(config('config.enable_chat_refresh')); ?>" data-chat-refresh-duration="<?php echo e(config('config.chat_refresh_duration')); ?>"></div>
                    </div>
                    <?php echo Form::open(['route' => 'chat.store','role' => 'form', 'class'=>'chat-form input-chat','id' => 'chat-form','data-refresh' => 'chat-messages']); ?>

                    <?php echo Form::input('text','message','',['class'=>'form-control','data-autoresize' => 1,'placeholder' => 'Type your message here..']); ?>

                    <?php echo Form::close(); ?>

                </div>
                <?php endif; ?>
                <div class="box-info">
                    <h2>
                        <strong><?php echo e(trans('messages.celebration')); ?></strong>
                    </h2>
                    <div id="chat-box" class="chat-widget custom-scrollbar">
                        <?php if(count($celebrations)): ?>
                        <ul class="media-list">
                        <?php $__currentLoopData = $celebrations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $celebration): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li class="media">
                            <a class="pull-left" href="#">
                              <?php echo getAvatar($celebration['id'],55); ?>

                            </a>
                            <div class="media-body success">
                              <p class="media-heading"><i class="fa fa-<?php echo e($celebration['icon']); ?> icon" style="margin-right:10px;"></i> <?php echo e($celebration['title']); ?> (<?php echo $celebration['number']; ?>)</p>
                              <p style="margin-bottom:5px;"><strong><?php echo $celebration['name']; ?></strong></p>
                            </div>
                          </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php else: ?>
                            <?php echo $__env->make('global.notification',['message' => trans('messages.no_data_found'),'type' =>'danger'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?></div>
                        <?php endif; ?>  
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
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
                                <h3 class="show-count"><?php echo e(\App\Invoice::whereCustomerId(Auth::user()->id)->count()); ?></h3>
                                <p><?php echo e(trans('messages.invoice')); ?></p>
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
                                <h3 class="show-count"><?php echo e(\App\Quotation::whereCustomerId(Auth::user()->id)->count()); ?></h3>
                                <p><?php echo e(trans('messages.quotation')); ?></p>
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
                                <h3 class="show-count"><?php echo e(\App\Transaction::whereCustomerId(Auth::user()->id)->count()); ?></h3>
                                <p><?php echo e(trans('messages.transaction')); ?></p>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo $__env->make('announcement.home', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="box-info full">
                    <ul class="nav nav-tabs nav-justified tab-list">
                      <li><a href="#recent-invoice-tab" data-toggle="tab"><i class="fa fa-list-alt"></i> <?php echo trans('messages.recent').' '.trans('messages.invoice'); ?></a></li>
                      <li><a href="#recent-quotation-tab" data-toggle="tab"><i class="fa fa-folder"></i> <?php echo trans('messages.recent').' '.trans('messages.quotation'); ?></a></li>
                      <li><a href="#recent-transaction-tab" data-toggle="tab"><i class="fa fa-money"></i> <?php echo trans('messages.recent').' '.trans('messages.transaction'); ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane animated fadeInRight" id="recent-invoice-tab">
                            <div class="user-profile-content custom-scrollbar">
                                <div class="table-responsive">
                                    <table data-sortable class="table table-bordered table-hover table-striped ajax-table show-table" id="customer-invoice-table" data-source="/invoice/fetch" data-extra="&type=customer">
                                        <thead>
                                            <tr>
                                                <th><?php echo trans('messages.number'); ?></th>
                                                <th><?php echo trans('messages.customer'); ?></th>
                                                <th><?php echo trans('messages.amount'); ?></th>
                                                <th><?php echo trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.due').' '.trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.status'); ?></th>
                                                <th data-sortable="false"><?php echo trans('messages.option'); ?></th>
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
                                                <th><?php echo trans('messages.number'); ?></th>
                                                <th><?php echo trans('messages.customer'); ?></th>
                                                <th><?php echo trans('messages.amount'); ?></th>
                                                <th><?php echo trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.due').' '.trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.status'); ?></th>
                                                <th data-sortable="false"><?php echo trans('messages.option'); ?></th>
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
                                                <th><?php echo trans('messages.token'); ?></th>
                                                <th><?php echo trans('messages.amount'); ?></th>
                                                <th><?php echo trans('messages.method'); ?></th>
                                                <th><?php echo trans('messages.date'); ?></th>
                                                <th><?php echo trans('messages.option'); ?></th>
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
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('right_sidebar'); ?>
    <h4><strong><?php echo e(trans('messages.title')); ?></strong></h4>
      <div class="custom-scrollbar" style="margin: 25px 10px 100px 10px;max-height: 75%;">
      </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>