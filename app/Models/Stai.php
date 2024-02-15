<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stai extends Model
{
    use HasFactory;

	protected $fillable = [
		'nome',
		'link'
	];

	public function editais()
	{
		return $this->hasMany(StaiEditais::class);
	}
}
