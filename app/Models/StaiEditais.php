<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaiEditais extends Model
{
    use HasFactory;
	use softDeletes;

	protected $table = 'stai_editais';

	protected $fillable = [
		'nome',
		'tipo',
		'situacao' ,
		'data_publicacao' ,
		'data_fim_edital' ,
		'dt_inicio_inscricao' ,
		'dt_fim_inscricao' ,
		'created_by',
		'updated_by',
	];
}
