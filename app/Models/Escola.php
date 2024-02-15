<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Escola extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'nome',
        'situacao',
        'rede',
        'ficha',
        'endereco_completo',
        'contato',
        'municipio_id',
        'user_id',
        'created_by',
        'updated_by',
    ];

    public function municipio(){
        return $this->belongsTo(Municipio::class, 'municipio_id', 'id');
    }

    public function criadoPor(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function editais(){
        return $this->hasMany(Edital::class, 'escola_id', 'id');
    }

    public function modificadoPor(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function responsaveis()
    {
        return $this->hasMany(EscolaResponsavel::class, 'escola_id', 'id');
    }

    public function turmas(){
        return $this->hasManyThrough(Turma::class, Edital::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
