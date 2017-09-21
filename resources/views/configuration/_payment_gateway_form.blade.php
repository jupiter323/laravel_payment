
								  <div class="form-group">
								    {!! Form::label('enable_customer_payment',trans('messages.enable').' '.trans('messages.customer').' '.trans('messages.payment'),['class' => 'control-label '])!!}
					                <div class="checkbox">
					                	<input name="enable_customer_payment" type="checkbox" class="switch-input enable-show-hide" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" {{ (config('config.enable_customer_payment') == 1) ? 'checked' : '' }} data-off-value="0">
					                </div>
					              </div>
					              <div id="enable_customer_payment_field">
					              	<div class="col-md-6">
								    	<h2><strong>Paypal </strong>{!!trans('messages.configuration') !!}</h2>
							    		{!! Form::label('enable_paypal_payment','Paypal Payment',['class' => 'control-label '])!!}
						                <div class="checkbox">
						                	<input name="enable_paypal_payment" type="checkbox" class="switch-input enable-show-hide" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" {{ (config('config.enable_paypal_payment') == 1) ? 'checked' : '' }} data-off-value="0">
						                </div>
						                <div id="enable_paypal_payment_field">
						                	{!! Form::label('paypal_mode','Paypal Mode',[])!!}
						                	<div class="checkbox">
							                	<input name="paypal_mode" type="checkbox" class="switch-input" data-size="mini" data-on-text="Live" data-off-text="Sandbox" value="1" {{ (config('config.paypal_mode') == 1) ? 'checked' : '' }} data-off-value="0">
							                </div>
							                <div class="form-group">
											    {!! Form::label('paypal_client_id','Client Id',[])!!}
												{!! Form::input('text','paypal_client_id',(config('config.paypal_client_id')) ? config('config.hidden_value') : '',['class'=>'form-control','placeholder'=>'Client Id'])!!}
											</div>
							                <div class="form-group">
											    {!! Form::label('paypal_secret','Secret',[])!!}
												{!! Form::input('text','paypal_secret',(config('config.paypal_secret')) ? config('config.hidden_value') : '',['class'=>'form-control','placeholder'=>'Secret'])!!}
											</div>
						                </div>
					                </div>
					                <div class="col-md-6">
								    	<h2><strong>Stripe </strong>{!!trans('messages.configuration') !!}</h2>
							    		{!! Form::label('enable_stripe_payment','Stripe Payment',['class' => 'control-label '])!!}
						                <div class="checkbox">
						                	<input name="enable_stripe_payment" type="checkbox" class="switch-input enable-show-hide" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" {{ (config('config.enable_stripe_payment') == 1) ? 'checked' : '' }} data-off-value="0">
						                </div>
						                <div id="enable_stripe_payment_field">
						                	{!! Form::label('stripe_mode','Stripe Mode',[])!!}
						                	<div class="checkbox">
							                	<input name="stripe_mode" type="checkbox" class="switch-input" data-size="mini" data-on-text="Live" data-off-text="Test" value="1" {{ (config('config.stripe_mode') == 1) ? 'checked' : '' }} data-off-value="0">
							                </div>
							                <div class="form-group">
											    {!! Form::label('stripe_publishable_key','Publishable Key',[])!!}
												{!! Form::input('text','stripe_publishable_key',(config('config.stripe_publishable_key')) ? config('config.hidden_value') : '',['class'=>'form-control','placeholder'=>'Client Id'])!!}
											</div>
							                <div class="form-group">
											    {!! Form::label('stripe_private_key','Private Key',[])!!}
												{!! Form::input('text','stripe_private_key',(config('config.stripe_private_key')) ? config('config.hidden_value') : '',['class'=>'form-control','placeholder'=>'Secret'])!!}
											</div>
						                </div>
						            </div>
						            <div class="col-md-6">
								    	<h2><strong>2 Checkout </strong>{!!trans('messages.configuration') !!}</h2>
							    		{!! Form::label('enable_tco_payment','2 Checkout Payment',['class' => 'control-label '])!!}
						                <div class="checkbox">
						                	<input name="enable_tco_payment" type="checkbox" class="switch-input enable-show-hide" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" {{ (config('config.enable_tco_payment') == 1) ? 'checked' : '' }} data-off-value="0">
						                </div>
						                <div id="enable_tco_payment_field">
						                	{!! Form::label('tco_mode','2 Checkout Mode',[])!!}
						                	<div class="checkbox">
							                	<input name="tco_mode" type="checkbox" class="switch-input" data-size="mini" data-on-text="Live" data-off-text="Sandbox" value="1" {{ (config('config.tco_mode') == 1) ? 'checked' : '' }} data-off-value="0">
							                </div>
							                <div class="form-group">
											    {!! Form::label('tco_publishable_key','Publishable Key',[])!!}
												{!! Form::input('text','tco_publishable_key',(config('config.tco_publishable_key')) ? config('config.hidden_value') : '',['class'=>'form-control','placeholder'=>'Client Id'])!!}
											</div>
							                <div class="form-group">
											    {!! Form::label('tco_private_key','Private Key',[])!!}
												{!! Form::input('text','tco_private_key',(config('config.tco_private_key')) ? config('config.hidden_value') : '',['class'=>'form-control','placeholder'=>'Secret'])!!}
											</div>
							                <div class="form-group">
											    {!! Form::label('tco_seller_id','Seller Id',[])!!}
												{!! Form::input('text','tco_seller_id',(config('config.tco_seller_id')) ? config('config.hidden_value') : '',['class'=>'form-control','placeholder'=>'Secret'])!!}
											</div>
						                </div>
						            </div>
						            <div class="col-md-6">
								    	<h2><strong>PayUMoney </strong>{!!trans('messages.configuration') !!}</h2>
							    		{!! Form::label('enable_payumoney_payment','PayUMoney Payment',['class' => 'control-label '])!!}
						                <div class="checkbox">
						                	<input name="enable_payumoney_payment" type="checkbox" class="switch-input enable-show-hide" data-size="mini" data-on-text="Yes" data-off-text="No" value="1" {{ (config('config.enable_payumoney_payment') == 1) ? 'checked' : '' }} data-off-value="0">
						                </div>
						                <div id="enable_payumoney_payment_field">
						                	{!! Form::label('payumoney_mode','PayUMoney Mode',[])!!}
						                	<div class="checkbox">
							                	<input name="payumoney_mode" type="checkbox" class="switch-input" data-size="mini" data-on-text="Live" data-off-text="Test" value="1" {{ (config('config.payumoney_mode') == 1) ? 'checked' : '' }} data-off-value="0">
							                </div>
							                <div class="form-group">
											    {!! Form::label('payumoney_key','Key',[])!!}
												{!! Form::input('text','payumoney_key',(config('config.payumoney_key')) ? config('config.hidden_value') : '',['class'=>'form-control','placeholder'=>'Client Id'])!!}
											</div>
							                <div class="form-group">
											    {!! Form::label('payumoney_salt','Salt',[])!!}
												{!! Form::input('text','payumoney_salt',(config('config.payumoney_salt')) ? config('config.hidden_value') : '',['class'=>'form-control','placeholder'=>'Secret'])!!}
											</div>
						                </div>
						            </div>
							      </div>
							    <div class="clear"></div>
							    <input type="hidden" name="config_type" readonly value="payment_gateway">
							    {!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}