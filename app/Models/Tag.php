<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'nome',
        'situacao',
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
