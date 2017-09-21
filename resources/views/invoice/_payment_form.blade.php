		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
				    {!! Form::label('account_id',trans('messages.account'),[])!!}
					{!! Form::select('account_id', $accounts, isset($transaction) ? $transaction->account_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					{!! Form::label('income_category_id',trans('messages.income').' '.trans('messages.category'),[])!!}
					{!! Form::select('income_category_id', $income_categories, isset($transaction) ? $transaction->income_category_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
				    {!! Form::label('payment_method_id',trans('messages.payment').' '.trans('messages.method'),[])!!}
					{!! Form::select('payment_method_id', $payment_methods, isset($transaction) ? $transaction->payment_method_id : '',['class'=>'form-control show-tick','title'=>trans('messages.select_one')])!!}
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					{!! Form::label('tags',trans('messages.tags'),[])!!}
					{!! Form::input('text','tags',isset($transaction) ? $transaction->tags : '',['class'=>'form-control','placeholder'=>trans('messages.tags'),'data-role' => 'tagsinput'])!!}
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
				    {!! Form::label('amount',trans('messages.amount'),[])!!}
					<div class="input-group">
						<span class="input-group-addon">{{$invoice->Currency->symbol}}</span>
						{!! Form::input('text','amount',isset($transaction) ? round($transaction->amount,$transaction->Currency->decimal_place) : '',['class'=>'form-control','placeholder'=>trans('messages.amount')])!!}
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					{!! Form::label('date',trans('messages.date'),[])!!}
					{!! Form::input('text','date',isset($transaction) ? $transaction->date : date('Y-m-d'),['class'=>'form-control datepicker','placeholder'=>trans('messages.date'),'readonly' => 'true'])!!}
				</div>
			</div>
		</div>
		@include('upload.index',['module' => 'invoice-payment','upload_button' => trans('messages.upload').' '.trans('messages.file'),'module_id' => isset($transaction) ? $transaction->id : ''])
		<div class="form-group">
		    {!! Form::label('description',trans('messages.description'),[])!!}
		    {!! Form::textarea('description',isset($transaction->description) ? $transaction->description : '',['size' => '30x3', 'class' => 'form-control', 'placeholder' => trans('messages.description'),"data-show-counter" => 1,"data-limit" => config('config.textarea_limit'),'data-autoresize' => 1])!!}
		    <span class="countdown"></span>
		</div>
        <div class="form-group">
            <input name="send_invoice_payment_confirmation_email" type="checkbox" class="switch-input" data-size="mini" data-on-text="Yes" data-off-text="No" value="1"> {{trans('messages.send').' '.trans('messages.invoice').' '.trans('messages.payment').' '.trans('messages.confirmation')}}
        </div>
		{{ getCustomFields('income-form',$custom_field_values) }}
		{!! Form::submit(isset($buttonText) ? $buttonText : trans('messages.save'),['class' => 'btn btn-primary pull-right']) !!}