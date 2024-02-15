<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EditalDocumento extends Model
{
    use HasFactory;
    protected $table = 'edital_tipo_arquivo';

    protected $fillable = [
        'id',
        'edital_id',
        'tipo_arquivo_id'
    ];

    public function edital()
    {
        return $this->belongsTo(Edital::class);
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    public function tipo_arquivo()
    {
        return $this->belongsTo(TipoArquivo::class);
    }
}
