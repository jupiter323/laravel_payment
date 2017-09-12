		<div class="col-md-6">	
			<div class="row">
				<div class="col-sm-6">
				  <div class="form-group">
				    {!! Form::label('account_id',trans('messages.account'),[])!!}
					{!! Form::select('account_id', $accounts, isset($transaction) ? $transaction->account_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
				  </div>
				</div>
				<div class="col-sm-6">
				  <div class="form-group">
				  	@if($type == 'income')
					    {!! Form::label('income_category_id',trans('messages.income').' '.trans('messages.category'),[])!!}
					    {!! Form::select('income_category_id', $income_categories, isset($transaction) ? $transaction->income_category_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
				    @elseif($type == 'expense')
				    	{!! Form::label('expense_category_id',trans('messages.expense').' '.trans('messages.category'),[])!!}
				    	{!! Form::select('expense_category_id', $expense_categories, isset($transaction) ? $transaction->expense_category_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
				    @elseif($type == 'account-transfer')
				    	{!! Form::label('from_account_id',trans('messages.from').' '.trans('messages.account'),[])!!}
						{!! Form::select('from_account_id', $accounts, isset($transaction) ? $transaction->from_account_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
				    @endif
				  </div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
				  <div class="form-group">
				    {!! Form::label('payment_method_id',trans('messages.payment').' '.trans('messages.method'),[])!!}
					{!! Form::select('payment_method_id', $payment_methods, isset($transaction) ? $transaction->payment_method_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
				  </div>
				</div>
				<div class="col-sm-6">
				  <div class="form-group">
				  	@if($type == 'income')
					    {!! Form::label('customer_id',trans('messages.payer'),[])!!}
					    {!! Form::select('customer_id', $customers, isset($transaction) ? $transaction->customer_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
				    @elseif($type == 'expense')
				    	{!! Form::label('customer_id',trans('messages.payee'),[])!!}
				    	{!! Form::select('customer_id', $customers, isset($transaction) ? $transaction->customer_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
				    @endif
				  </div>
				</div>
			</div>
			<div class="form-group">
			    {!! Form::label('tags',trans('messages.tags'),[])!!}
				{!! Form::input('text','tags',isset($transaction) ? $transaction->tags : '',['class'=>'form-control','placeholder'=>trans('messages.tags'),'data-role' => 'tagsinput'])!!}
			</div>
			<div class="form-group">
				@include('upload.index',['module' => $type,'upload_button' => trans('messages.upload').' '.trans('messages.file'),'module_id' => isset($transaction) ? $transaction->id : ''])
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group">
				{!! Form::label('amount',trans('messages.amount'),['class' => 'control-label'])!!}
				<div class="row">
					<div class="col-md-4">
						{!! Form::select('currency_id', $currencies, isset($transaction) ? $transaction->currency_id : (($default_currency) ? $default_currency->id : ''),['class'=>'form-control show-tick','id' => 'currency-conversion','title'=>trans('messages.select_one'),'data-currency-date' => isset($transaction) ? $transaction->date : date('Y-m-d'),'data-currency-id' => isset($transaction) ? $transaction->currency_id : (($default_currency) ? $default_currency->id : '')])!!}
					</div>
					<div class="col-md-8">
						{!! Form::input('text','amount',isset($transaction) ? round($transaction->amount,$transaction->Currency->decimal_place) : '',['class'=>'form-control','placeholder'=>trans('messages.amount')])!!}
					</div>
					<div class="col-md-8">
						<div id="currency-conversion-field">
							@if(isset($transaction) && $transaction->currency_id != $default_currency->id)
								<div class="form-group">
									<label class="conversion_rate">{{trans('messages.conversion').' '.trans('messages.rate')}}</label>
									<div class="input-group">
										<span class="input-group-addon">1 {{$default_currency->detail}} = </span>
										{!! Form::input('text','conversion_rate',isset($transaction) ? round($transaction->conversion_rate,5) : '',['class'=>'form-control','placeholder'=>trans('messages.conversion').' '.trans('messages.rate')])!!}
										<span class="input-group-addon">{{$transaction->Currency->detail}} </span>
									</div>
								</div>
							@endif
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('date',trans('messages.date'),[])!!}
						{!! Form::input('text','date',isset($transaction) ? $transaction->date : date('Y-m-d'),['class'=>'form-control datepicker','id' => 'currency-date','placeholder'=>trans('messages.date'),'readonly' => 'true','data-currency-date' => isset($transaction) ? $transaction->date : date('Y-m-d'),'data-currency-id' => isset($transaction) ? $transaction->currency_id : (($default_currency) ? $default_currency->id : '')])!!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('reference_number',trans('messages.reference').' '.trans('messages.number'),[])!!}
						{!! Form::input('text','reference_number',isset($transaction) ? $transaction->reference_number : (config('config.random_transaction_reference_number') ? strtoupper(randomString(8)) : '' ),['class'=>'form-control','placeholder'=>trans('messages.reference').' '.trans('messages.number')])!!}
					</div>
				</div>
			</div>
			<div class="form-group">
			    {!! Form::label('description',trans('messages.description'),[])!!}
			    {!! Form::textarea('description',isset($transaction->description) ? $transaction->description : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.description'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1])!!}
			    <span class="countdown"></span>
			</div>
		</div>
		<div class="col-md-12">
			{{ getCustomFields($type.'-form',$custom_field_values) }}
			{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
		</div>
		
