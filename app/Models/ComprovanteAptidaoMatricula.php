<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
class ComprovanteAptidaoMatricula extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    
    protected $table = 'comprovante_aptidao_matricula';

    protected $fillable = [
        'caminho',
        'situacao',
        'tipo_arquivo_id',
        'nome_arquivo',
        'inscricao_id',
        'link',
        'status',
        'created_by',
        'updated_by',
    ];
    
    public function tipoArquivo(){
        return $this->belongsTo(TipoArquivo::class, 'tipo_arquivo_id', 'id');
    }
    public function inscricao(){
        return $this->belongsTo(Inscricao::class, 'inscricao_id', 'id');
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