<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaSubarea extends Model
{
    use HasFactory;
	use softDeletes;

	protected $table = 'subarea_area';

	protected $fillable = [
		'id',
		'subarea_id',
		'area_id',
		'created_at',
		'updated_at'
	];

	public function subareas()
	{
		return $this->belongsTo(SubArea::class, 'subarea_id');
	}

	public function turmas()
	{
		return $this->hasMany(Turma::class, 'area_subarea_id');
	}

	public function criadoPor()
	{
		return $this->belongsTo(User::class, 'created_by');
	}

	public function modificadoPor()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}
}
