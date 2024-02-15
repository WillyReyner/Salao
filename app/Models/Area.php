<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

	protected $table = 'areas';

	protected $fillable = [
		'nome',
		'situacao',
		'created_at',
		'updated_at'
	];

	public function area_subareas()
	{
		return $this->hasMany(AreaSubarea::class, 'area_id');
	}

	public function turmas()
	{
		return $this->hasMany(Turma::class, 'area_id');
	}

	public function criadoPor()
	{
		return $this->belongsTo(User::class, 'created_by');
	}

	public function modificadoPor()
	{
		return $this->belongsTo(User::class, 'updated_by');
	}

	public function scopeSearch($query, $request)
	{
		if ($request->search) {
			$query->where(function ($query) use ($request) {
				$query->where('nome', 'like', '%' . $request->search . '%');
			});
		}
		return $query;
	}

}
