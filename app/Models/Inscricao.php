<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\CustomLog\InscricaoLog\LogOptions;
use App\CustomLog\InscricaoLog\Traits\LogsActivity;

class Inscricao extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'inscricoes';

    protected $fillable = [
        'nome_completo',
        'password',
        'cpf',
        'rede',
        'email',
        'arquivo',
        'email_confirmation',
        'raca',
        'outro_raca',
        'genero',
        'outro_genero',
        'telefone',
        'telefone_alternativo',
        'cep',
        'municipio',
        'estado', 
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'data_nascimento',
        'nome_mae',
        'escolaridade',
        'origem_escolar',
        'nis_pis',
        'programa_social',
        'outro_programa_social',
        'deficiencia',
        'outra_deficiencia',
        'como_conheceu',
        'outro_como_conheceu',
        'situacao',
        'lgpd',
        'documento',
        'tipo_documento',
        'habilitacao_id',
        'turma_id',
        'created_by',
        'updated_by',
    ];

    public function turma(){
        return $this->belongsTo(Turma::class, 'turma_id', 'id');
    }

    public function comprovantes(){
        return $this->hasMany(Comprovante::class, 'inscricao_id', 'id');
    }

    public function comprovantes_aptidao(){
        return $this->hasMany(ComprovanteAptidaoMatricula::class, 'inscricao_id', 'id');
    }

    public function habilitacao(){
        return $this->hasMany(Habilitacao::class, 'inscricao_id', 'id');
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
