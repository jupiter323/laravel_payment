				<div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('amount',trans('messages.amount'),[])!!}
                            {!! Form::input('number','amount','',['class'=>'form-control','placeholder'=>trans('messages.amount'),'id' => $gateway.'-payment-amount'])!!}
                            <span class="help-block" style="font-weight: bold;">{{trans('messages.balance').' 
                            '.trans('messages.amount').' : '.currency($balance,1,$invoice->currency_id)}}</span>
                            <span class="help-block" id="{{$gateway}}-payable-amount" data-invoice-id="{{$invoice->id}}"></span>
                        </div>
                    </div>
                    @if(config('config.enable_coupon'))
                        <div class="col-md-6">
                            <div class="form-group">
                                {!! Form::label('coupon',trans('messages.coupon'),[])!!}
                                {!! Form::input('text','coupon','',['class'=>'form-control','placeholder'=>trans('messages.coupon'),'id' => $gateway.'-payment-coupon'])!!}
                            </div>
                        </div>
                    @endif
                </div>
                @if($gateway == 'tco')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::input('number','','',['class'=>'form-control','placeholder'=> '16 Digit Card Number','autocomplete' => 'off','id' => 'ccNo'])!!}
                        </div>
                        <input id="token" name="token" type="hidden" value="" readonly>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                {!! Form::input('number','','',['class'=>'form-control','placeholder'=> 'MM','id' => 'expMonth'])!!}
                                </div>
                                <div class="col-md-4">
                                {!! Form::input('number','','',['class'=>'form-control','placeholder'=> 'YYYY','id' => 'expYear'])!!}
                                </div>
                                <div class="col-md-3 pull-right">
                                {!! Form::input('number','','',['class'=>'form-control','placeholder'=> 'CVC','id' => 'cvv'])!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @if($gateway == 'stripe')
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::input('number','','',['class'=>'form-control','placeholder'=> '16 Digit Card Number','data-stripe' => 'number'])!!}
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                {!! Form::input('number','','',['class'=>'form-control','placeholder'=> 'MM','data-stripe' => 'exp-month'])!!}
                                </div>
                                <div class="col-md-4">
                                {!! Form::input('number','','',['class'=>'form-control','placeholder'=> 'YYYY','data-stripe' => 'exp-year'])!!}
                                </div>
                                <div class="col-md-3 pull-right">
                                {!! Form::input('number','','',['class'=>'form-control','placeholder'=> 'CVC','data-stripe' => 'cvc'])!!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('phone',trans('messages.phone'),[])!!}
                            {!! Form::input('text','phone',($invoice->Customer) ? $invoice->Customer->Profile->phone : '',['class'=>'form-control','placeholder'=>trans('messages.phone')])!!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('address',trans('messages.address'),[])!!}
                            {!! Form::input('text','address_line_1',($invoice->Customer) ? $invoice->Customer->Profile->address_line_1 : '',['class'=>'form-control','placeholder'=>trans('messages.address_line_1')])!!}
                        </div>
                        <div class="form-group">
                            {!! Form::input('text','address_line_2',($invoice->Customer) ? $invoice->Customer->Profile->address_line_2 : '',['class'=>'form-control','placeholder'=>trans('messages.address_line_2')])!!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!! Form::label('city',"City",[])!!}
                            <div class="row">
                                <div class="col-sm-5">
                                    {!! Form::input('text','city',($invoice->Customer) ? $invoice->Customer->Profile->city : '',['class'=>'form-control','placeholder'=>trans('messages.city')])!!}
                                </div>
                                <div class="col-sm-4">
                                    {!! Form::input('text','state',($invoice->Customer) ? $invoice->Customer->Profile->state : '',['class'=>'form-control','placeholder'=>trans('messages.state')])!!}
                                </div>
                                <div class="col-sm-3">
                                    {!! Form::input('text','zipcode',($invoice->Customer) ? $invoice->Customer->Profile->zipcode : '',['class'=>'form-control','placeholder'=>trans('messages.zipcode')])!!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::select('country_id', [null => trans('messages.select_one')] + config('country'),($invoice->Customer) ? $invoice->Customer->Profile->country_id : '',['class'=>'form-control show-tick','title'=>trans('messages.country')])!!}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                {!! Form::submit(trans('messages.pay'),['class' => 'btn btn-primary pull-right']) !!}
                </div>
