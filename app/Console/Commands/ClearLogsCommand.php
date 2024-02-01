<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Class ClearLogsCommand
 *
 * This command removes log files from the storage/logs/ directory.
 * It is intended to be run via the console using the "logs:clear" signature.
 *
 * @package App\Console\Commands
 */
class ClearLogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove log files in storage/logs/';

    /**
     * Execute the console command.
     *
     * @return void
     */
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
