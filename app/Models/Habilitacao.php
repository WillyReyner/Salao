<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Habilitacao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'habilitacao';

    protected $fillable = [
        'nome',
        'situacao'
    ];

    public function criadoPor()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function modificadoPor()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
