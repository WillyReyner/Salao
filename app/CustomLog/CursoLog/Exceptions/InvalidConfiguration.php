<?php

namespace App\CustomLog\CursoLog\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Model;
use App\CustomLog\CursoLog\Contracts\Activity;

class InvalidConfiguration extends Exception
{
    public static function modelIsNotValid(string $className): self
    {
        return new static("The given model class `{$className}` does not implement `".Activity::class.'` or it does not extend `'.Model::class.'`');
    }
}
