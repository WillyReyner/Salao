<?php

namespace App\CustomLog\CursoLog;

use Illuminate\Database\Eloquent\Model;
use App\CustomLog\CursoLog\Contracts\Activity;
use App\CustomLog\CursoLog\Contracts\Activity as ActivityContract;
use App\CustomLog\CursoLog\Exceptions\InvalidConfiguration;
use App\CustomLog\CursoLog\Models\Activity as ActivityModel;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ActivitylogServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
        ->name('laravel-activitylog')
        ->hasConfigFile('activitylog')
        ->hasMigrations([
            'create_activity_log_table',
            'add_event_column_to_activity_log_table',
            'add_batch_uuid_column_to_activity_log_table',
        ])
        ->hasCommand(CleanCursoActivitylogCommand::class);
    }

    public function registeringPackage()
    {
        $this->app->bind(ActivityLogger::class);

        $this->app->scoped(LogBatch::class);

        $this->app->scoped(CauserResolver::class);

        $this->app->scoped(ActivityLogStatus::class);
    }

    public static function determineActivityModel(): string
    {
        $activityModel = config('activitylog_curso.activity_model') ?? ActivityModel::class;

        if (! is_a($activityModel, Activity::class, true)
            || ! is_a($activityModel, Model::class, true)) {
            throw InvalidConfiguration::modelIsNotValid($activityModel);
        }

        return $activityModel;
    }

    public static function getActivityModelInstance(): ActivityContract
    {
        $activityModelClassName = self::determineActivityModel();

        return new $activityModelClassName();
    }
}
