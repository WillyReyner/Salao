<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;

class Ticket extends Model
{
	use HasFactory, SoftDeletes;

	protected $table = 'tickets';

	protected $fillable = [
		'id',
		'tickets',
		'read',
		'created_by',
		'updated_by',
	];


	public function criadoPor()
	{
		return $this->belongsTo(User::class, 'created_by', 'id');
	}

	public function modificadoPor()
	{
		return $this->belongsTo(User::class, 'updated_by', 'id');
	}

	public function TickedNotification()
	{
		return $this->hasMany(TickedNotification::class, 'ticket_id', 'id');
	}

	public function getActivitylogOptions(): LogOptions
	{
		return LogOptions::defaults()
			->logFillable()
			->logOnlyDirty()
			->dontSubmitEmptyLogs();
	}
}
