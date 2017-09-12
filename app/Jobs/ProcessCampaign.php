<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessCampaign implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $campaign = \App\Campaign::find($this->id);
        $body = $campaign->body;
        $emails = explode(',',$campaign->recipients);

        foreach($emails as $email){
            \Mail::send('emails.email', compact('body'), function ($message) use($campaign,$email) {
              if($campaign->attachments){
                $file = config('constant.upload_path.attachments').$campaign->attachments;
                $message->attachData($file, $campaign->attachments);
              }
                $message->to($email)->subject($campaign->subject);
            });
        }
    }
}
