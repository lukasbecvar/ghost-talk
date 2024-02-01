<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Class ClearSessionsCommand
 *
 * This command removes session files from the storage/framework/sessions/ directory.
 * It is intended to be run via the console using the "session:clear" signature.
 *
 * @package App\Console\Commands
 */
class ClearSessionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'session:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove session files in storage/framework/sessions/';

    /**
     * Execute the console command.
     *
     * @return void
     */
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

            // delete session files
            File::delete(...$files);
        }

        $this->info('Session cleared successfully.');
    }
}
