<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearLogsCommand extends Command
{
    protected $signature = 'logs:clear';
    protected $description = 'Remove log files in storage/logs/';

    public function handle(): void
    {
        // get all files in log directory
        $files = File::glob(storage_path('logs/*'));

        // exclude the .gitignore file
        $files = array_filter($files, function ($file) {
            return basename($file) !== '.gitignore';
        });

        // check if logs is not empty
        if (count($files) > 0) {

            // delete log files
            File::delete(...$files);
        }

        $this->info('Logs cleared successfully.');
    }
}
