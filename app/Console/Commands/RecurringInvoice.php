<?php

namespace App\Console\Commands;

use App\Invoice;
use PDF;
use Uuid;
use App\Config;
use Illuminate\Console\Command;

class RecurringInvoice extends Command
{
    use \App\Http\Controllers\BasicController;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recurring-invoice';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Recurring Invoices';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        setConfig(Config::all());
        $default_timezone = config('config.timezone_id') ? config('timezone.'.config('config.timezone_id')) : 'Asia/Kolkata';
        date_default_timezone_set($default_timezone);

        $recurring_invoices = Invoice::whereIsRecurring(1)->whereNextRecurringDate(date('Y-m-d'))->get();
        foreach($recurring_invoices as $recurring_invoice){
            $invoice = $recurring_invoice->replicate();
            $invoice->uuid = Uuid::generate();
            $invoice->invoice_number = getInvoiceNumber();
            $invoice->status = 'draft';
            $invoice->payment_status = 'unpaid';
            $invoice->is_recurring = 0;
            $invoice->recurring_frequency = 0;
            $invoice->next_recurring_date = null;
            $invoice->recurrence_upto = null;
            $invoice->recurring_invoice_id = $recurring_invoice->id;
            $invoice->save();

            $mail_data = $this->templateContent(['slug' => 'send-invoice','invoice' => $invoice]);
            if(count($mail_data)){
                $mail['email'] = $invoice->Customer->email;
                $mail['filename'] = 'Invoice_'.$invoice->invoice_prefix.getInvoiceNumber($invoice).'.pdf';
                $mail['subject'] = $mail_data['subject'];
                $body = $mail_data['body'];
                $invoice_color = '#C9302C';
                $action_type = 'pdf';
                $pdf = PDF::loadView('invoice.print', compact('invoice','invoice_color','action_type'));

                \Mail::send('emails.email', compact('body'), function ($message) use($pdf,$mail) {
                    $message->attachData($pdf->output(), $mail['filename']);
                    $message->to($mail['email'])->subject($mail['subject']);
                });
                $this->logEmail(array('to' => $mail['email'],'subject' => $mail['subject'],'body' => $body,'module' => 'invoice','module_id' =>$invoice->id));
            }

            foreach($recurring_invoice->InvoiceItem as $invoice_item){
                $new_invoice_item = $invoice_item->replicate();
                $new_invoice_item->invoice_id = $invoice->id;
                $new_invoice_item->item_key = randomString(40);
                $new_invoice_item->save();
            }

            $next_recurring_date = date('Y-m-d', strtotime($recurring_invoice->date. ' + '.$recurring_invoice->recurring_frequency.' days'));
            if($recurring_invoice->recurrence_upto > $next_recurring_date)
                $recurring_invoice->next_recurring_date = $next_recurring_date;
            else
                $recurring_invoice->next_recurring_date = null;
            $recurring_invoice->save();
        }
        
    }
}