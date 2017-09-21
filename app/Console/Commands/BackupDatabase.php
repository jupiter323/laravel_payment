<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup Database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $default_timezone = config('config.timezone_id') ? config('timezone.'.config('config.timezone_id')) : 'Asia/Kolkata';
        date_default_timezone_set($default_timezone);
        include('app/Helper/Dumper.php');
        $data = backupDatabase();
        if($data['status'] == 'success'){
            $filename = $data['filename'];
            \App\Backup::create(['file' => $filename]);
        }
    }
}