<?php

namespace App\Managers;

use App\Models\Log;

class LogManager 
{
    public function saveLog(string $name, string $value): void
    {
        // init log entity
        $log = new Log();

        try {
            // value character shortifiy
            if (mb_strlen($value) >= 200) {
                $value = mb_substr($value, 0, 200 - 3).'...';
            }

            // set log item values
            $log->setName($name);
            $log->setValue($value);
            $log->setStatus('non-readed');

            // save log to database
            $log->save();
        } catch(\Exception $e) {
            if ($_ENV['APP_DEBUG'] == 'true') {
                die('error to save log: '.$e->getMessage());
            } else {
                die('unexpected error please contact admin on: '.$_ENV['CONTACT_EMAIL']);
            }
        }
    }

    public function setReaded(string $id): void
    {
        if ($id == '*') {
            Log::where('status', 'non-readed')->update(['status' => 'readed']);
        } else {
            Log::where('id', $id)->update(['status' => 'readed']);
        }
    }

    public function getLogsWhereStatus(string $status): object
    {
        return Log::where('status', $status)->get();
    }
}
