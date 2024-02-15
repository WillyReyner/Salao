<?php

namespace App\Models;

use App\Models\User;
use App\Models\Curso;
use App\Models\Edital;
use App\Models\Escola;
use App\Models\Inscricao;
use App\Models\TurmaDocumento;
use App\Models\TurmaHabilitacao;
use App\CustomLog\TurmaLog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\CustomLog\TurmaLog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Turma extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'edital_id',
        'curso_id',
        'nome',
        'situacao',
        'modalidade',
        'faixa_etaria',
        'vagas',
        'dias_semana',
        'turno',
        'hora_inicio',
        'hora_termino',
        'data_inicio',
        'created_by',
        'updated_by',

        'habilitacao',
        
        'teste_aptidao',
        'teste_aptidao_local_online',
        'teste_aptidao_local_presencial',
        'teste_aptidao_exigidos',
        'teste_aptidao_data_online',
        'teste_aptidao_data_presencial',
        'teste_aptidao_hora_presencial',
        'teste_aptidao_sala_presencial',
        'teste_aptidao_idade',
        'teste_aptidao_idade_minima',
        'teste_aptidao_escola_presencial',
    ];

    public function edital()
    {
        return $this->belongsTo(Edital::class, 'edital_id', 'id');
    }

    public function escola()
    {
        return $this->belongsTo(Escola::class, 'teste_aptidao_escola_presencial', 'id');
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id', 'id');
    }

    public function inscricoes()
    {
        return $this->hasMany(Inscricao::class, 'turma_id', 'id');
    }

    public function criadoPor()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function tipo_arquivos() {
        return $this->hasMany(TurmaDocumento::class, 'turma_id', 'id');
    }

    public function tipo_arquivos_habilitacao() {
        return $this->hasMany(TurmaHabilitacao::class, 'turma_id', 'id');
    }

    public function modificadoPor()
    {
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
