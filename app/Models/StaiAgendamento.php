<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

class StaiAgendamento extends Model
{
    use HasFactory;
	use SoftDeletes;

	protected $table = 'stai_agendamentos';

	protected $fillable = [
		'nome',
	];
}
