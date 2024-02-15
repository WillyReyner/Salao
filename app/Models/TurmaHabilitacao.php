<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TurmaHabilitacao extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'turma_habilitacao';

    protected $fillable = [
        'turma_id',
        'habilitacao_id'
    ];

    public function criadoPor()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function habilitacao()
    {
        return $this->belongsTo(Habilitacao::class, 'habilitacao_id', 'id');
    }

    public function modificadoPor()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
