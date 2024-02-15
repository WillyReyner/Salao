<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EscolaResponsavel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'escola_responsaveis';

    protected $fillable = [
        'user_id',
        'escola_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function escola()
    {
        return $this->belongsTo(Escola::class);
    }
}
