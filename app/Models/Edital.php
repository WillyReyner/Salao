<?php

namespace App\Models;

use App\CustomLog\EditalLog\LogOptions;
use App\CustomLog\EditalLog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Edital extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = "editais";

    protected $fillable = [
        'id',
        'nome',
        'numero_edital',
	    'area',
        'situacao',
        'documentos_matricula',
        'documentos_inscricao',
        'agendar_publicacao',
        'udepi',
        'contagem_editais',
        'dt_publicacao',
        'dt_fim_edital',
        'dt_inicio_inscricao',
        'dt_fim_inscricao',
        'escola_id',
        'municipio_id',
        'created_by',
        'updated_by',
    ];

    public function escola(){
        return $this->belongsTo(Escola::class, 'escola_id', 'id');
    }

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id', 'id');
    }

    public function criadoPor(){
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function modificadoPor(){
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function tipo_arquivos() {
        return $this->hasMany(EditalDocumento::class, 'edital_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
