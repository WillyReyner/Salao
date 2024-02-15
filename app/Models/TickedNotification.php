<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TickedNotification extends Model
{
	use HasFactory, SoftDeletes;

	protected $table = 'ticket_destinations';

	protected $fillable = [
		'user_id',
		'ticket_id',
		'read'
	];

	public function ticket()
	{
		return $this->belongsTo(Ticket::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

}
