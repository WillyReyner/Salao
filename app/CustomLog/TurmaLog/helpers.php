<?php

use App\CustomLog\TurmaLog\ActivityLogger;
use App\CustomLog\TurmaLog\ActivityLogStatus;

if (! function_exists('activity')) {
    function activity(string $logName = null): ActivityLogger
    {
        $defaultLogName = config('activitylog_turma.default_log_name');

        $logStatus = app(ActivityLogStatus::class);

        return app(ActivityLogger::class)
            ->useLog($logName ?? $defaultLogName)
            ->setLogStatus($logStatus);
    }
}
