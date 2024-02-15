<?php

use App\CustomLog\InscricaoLog\ActivityLogger;
use App\CustomLog\InscricaoLog\ActivityLogStatus;

if (! function_exists('activity')) {
    function activity(string $logName = null): ActivityLogger
    {
        $defaultLogName = config('activitylog_inscricao.default_log_name');

        $logStatus = app(ActivityLogStatus::class);

        return app(ActivityLogger::class)
            ->useLog($logName ?? $defaultLogName)
            ->setLogStatus($logStatus);
    }
}
