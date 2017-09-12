
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h4 class="modal-title">{!! trans('messages.edit').' '.trans('messages.processing_fee') !!}</h4>
	</div>
	<div class="modal-body">
		{!! Form::model($transaction,['method' => 'POST','route' => ['invoice.withdraw',$transaction] ,'class' => 'invoice-payment-withdraw-form','id' => 'invoice-payment-withdraw-form','files' => true,'data-table-refresh' => 'invoice-payment-table','data-refresh' => 'load-invoice-status']) !!}
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
					    {!! Form::label('processing_fee',trans('messages.processing_fee'),[])!!}
						<div class="input-group">
							<span class="input-group-addon">{{$invoice->Currency->symbol}}</span>
							{!! Form::input('text','processing_fee',isset($transaction) ? round($transaction->processing_fee,$transaction->Currency->decimal_place) : '',['class'=>'form-control','placeholder'=>trans('messages.processing_fee')])!!}
						</div>
					</div>
				</div>
				<div class="col-md-6">
					@if($default_currency->id != $transaction->currency_id)
						<div class="form-group">
							<label class="conversion_rate">{{trans('messages.conversion').' '.trans('messages.rate')}}</label>
							<div class="input-group">
								<span class="input-group-addon">1 {{$default_currency->detail}} = </span>
								{!! Form::input('text','conversion_rate',(isset($transaction) && round($transaction->conversion_rate)) ? $transaction->conversion_rate : $conversion_rate ,['class'=>'form-control','placeholder'=>trans('messages.conversion').' '.trans('messages.rate')])!!}
								<span class="input-group-addon">{{$transaction->Currency->detail}} </span>
							</div>
						</div>
					@endif
				</div>
				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('account_id',trans('messages.account'),[])!!}
						{!! Form::select('account_id', $accounts, isset($transaction) ? $transaction->account_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('payment_method_id',trans('messages.payment').' '.trans('messages.method'),[])!!}
						{!! Form::select('payment_method_id', $payment_methods, isset($transaction) ? $transaction->payment_method_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('income_categories',trans('messages.category'),[])!!}
						{!! Form::select('income_category_id', $income_categories, isset($transaction) ? $transaction->income_category_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						{!! Form::label('date',trans('messages.date'),[])!!}
						{!! Form::input('text','date',isset($transaction) ? $transaction->date : date('Y-m-d'),['class'=>'form-control datepicker','placeholder'=>trans('messages.date'),'readonly' => 'true'])!!}
					</div>
				</div>
			</div>
			<div class="form-group">
			    {!! Form::label('withdraw_remarks',trans('messages.remarks'),[])!!}
			    {!! Form::textarea('withdraw_remarks',isset($transaction) ? $transaction->withdraw_remarks : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.remarks'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1])!!}
			    <span class="countdown"></span>
			</div>
			<div class="form-group">
            	{!! Form::submit(trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}
            </div>
		{!! Form::close() !!}
		<div class="clear"></div>
	</div>