<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentacaoMatricula extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nome',
        'caminho',
        'situacao',
        'created_by',
        'updated_by',
    ];
}
