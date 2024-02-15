<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\CustomLog\CursoLog\LogOptions;
use App\CustomLog\CursoLog\Traits\LogsActivity;

class Curso extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
	    'nome',
	    'id_curso_siga',
	    'escola_curso_siga',
	    'situacao',
	    'destaque',
	    'link_video_apresentacao',
	    'horas_curso',
	    'nivel',
	    'faixa_etaria',
	    'area',
	    'subarea',
	    'texto_site',
	    'des_texto_site',
	    'disciplina',
	    'des_disciplina',
	    'conteudo_programatico',
	    'des_conteudo',
	    'area_atuacao',
	    'des_area_atuacao',
	    'imagem,'
    ];

    public function criadoPor(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function tags()
    {
        return $this->hasMany(TagsCursosModel::class, 'curso_id', 'id');
    }

    public function turmas()
    {
        return $this->hasMany(Turma::class);
    }
    
    public function modificadoPor(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
