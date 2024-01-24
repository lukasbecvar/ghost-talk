<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearSessionsCommand extends Command
{
    protected $signature = 'session:clear';
    protected $description = 'Remove session files in storage/framework/sessions/';

    public function handle(): void
    {
        // get all files in session directory
        $files = File::glob(storage_path('framework/sessions/*'));

        // exclude the .gitignore file
        $files = array_filter($files, function ($file) {
            return basename($file) !== '.gitignore';
        });

        // check if sessions is not empty
        if (count($files) > 0) {
            File::delete(...$files);
        }

        $this->info('Session cleared successfully.');
    }
}
