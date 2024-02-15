<?php

namespace App\CustomLog\CursoLog;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Database\Eloquent\Builder;

class CleanCursoActivitylogCommand extends Command
{
    use ConfirmableTrait;

    protected $signature = 'activitylog_curso:clean
                            {log? : (optional) The log name that will be cleaned.}
                            {--days= : (optional) Records older than this number of days will be cleaned.}
                            {--force : (optional) Force the operation to run when in production.}';

    protected $description = 'Clean up old records from the curso activity log.';

    public function handle()
    {
        if (! $this->confirmToProceed()) {
            return 1;
        }

        $this->comment('Cleaning curso activity log...');

        $log = $this->argument('log');

        $maxAgeInDays = $this->option('days') ?? config('activitylog_curso.delete_records_older_than_days');

        $cutOffDate = Carbon::now()->subDays($maxAgeInDays)->format('Y-m-d H:i:s');

        $activity = ActivitylogServiceProvider::getActivityModelInstance();

        $amountDeleted = $activity::query()
            ->where('created_at', '<', $cutOffDate)
            ->when($log !== null, function (Builder $query) use ($log) {
                $query->inLog($log);
            })
            ->delete();

        $this->info("Deleted {$amountDeleted} record(s) from the curso activity log.");

        $this->comment('All done!');
    }
}
