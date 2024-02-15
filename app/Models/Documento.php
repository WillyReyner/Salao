<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Documento extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'nome',
        'caminho',
        'tipo',
        'versao',
        'situacao',
        'data_publicacao',
        'edital_id',
        'created_by',
        'updated_by',
    ];

    public function edital(){
        return $this->belongsTo(Edital::class, 'edital_id', 'id');
    }
    public function criadoPor(){
        return $this->belongsTo(User::class, 'created_by', 'id');
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
