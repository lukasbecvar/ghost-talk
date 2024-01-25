<?php

namespace App\Managers;

use App\Models\Log;
use App\Utils\SecurityUtil;

class LogManager 
{
    private SecurityUtil $securityUtil;
    private ErrorManager $errorManager;

    public function __construct(SecurityUtil $securityUtil, ErrorManager $errorManager)
    {
        $this->securityUtil = $securityUtil;
        $this->errorManager = $errorManager;
    }

    public function saveLog(string $name, string $value): void
    {
        // init log entity
        $log = new Log();

        try {
            // escape log data
            $name = $this->securityUtil->escapeString($name);
            $value = $this->securityUtil->escapeString($value);
        
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
            $this->errorManager->handleError('error to save log: '.$e->getMessage(), 500);
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
