<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TipoArquivo extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'tipo_arquivos';

    protected $fillable = [
        'id',
        'nome',
        'orientacao',
        'tipo_arquivo',
        'tipo_versao',
        'created_by',
        'updated_by',
    ];

    public function criadoPor(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function modificadoPor(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function editais() {
        return $this->belongsToMany(Edital::class);
    }

    public function turmas() {
        return $this->belongsToMany(Turma::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
