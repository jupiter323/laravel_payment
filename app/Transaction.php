<?php
namespace App;
use Eloquent;

class Transaction extends Eloquent {

	protected $fillable = [
							'amount',
							'currency_id'
						];
	protected $primaryKey = 'id';
	protected $table = 'transactions';

    public function currency()
    {
        return $this->belongsTo('App\Currency');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function expenseCategory()
    {
        return $this->belongsTo('App\ExpenseCategory');
    }

    public function incomeCategory()
    {
        return $this->belongsTo('App\IncomeCategory');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    public function account()
    {
        return $this->belongsTo('App\Account','account_id');
    }

    public function fromAccount()
    {
        return $this->belongsTo('App\Account','from_account_id');
    }

    public function customer()
    {
        return $this->belongsTo('App\User','customer_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo('App\PaymentMethod');
    }
}
