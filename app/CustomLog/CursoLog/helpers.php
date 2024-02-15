<?php

use App\CustomLog\CursoLog\ActivityLogger;
use App\CustomLog\CursoLog\ActivityLogStatus;

if (! function_exists('activity')) {
    function activity(string $logName = null): ActivityLogger
    {
        $defaultLogName = config('activitylog_curso.default_log_name');

        $logStatus = app(ActivityLogStatus::class);

        return app(ActivityLogger::class)
            ->useLog($logName ?? $defaultLogName)
            ->setLogStatus($logStatus);
    }
}
