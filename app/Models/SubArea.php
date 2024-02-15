<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubArea extends Model
{
    use HasFactory, softDeletes;

	protected $table = 'subareas';

	protected $fillable = [
		'id',
		'nome',
		'situacao',
		'created_by',
		'updated_by',
	];

	public function subarea()
	{
		return $this->hasMany(AreaSubarea::class, 'subarea_id');
	}
}
