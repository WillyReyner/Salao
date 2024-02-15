<?php

use App\CustomLog\EditalLog\ActivityLogger;
use App\CustomLog\EditalLog\ActivityLogStatus;

if (! function_exists('activity')) {
    function activity(string $logName = null): ActivityLogger
    {
        $defaultLogName = config('activitylog_edital.default_log_name');

        $logStatus = app(ActivityLogStatus::class);

        return app(ActivityLogger::class)
            ->useLog($logName ?? $defaultLogName)
            ->setLogStatus($logStatus);
    }
}
