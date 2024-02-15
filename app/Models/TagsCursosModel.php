<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TagsCursosModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tags_cursos';

    protected $fillable = [
        'tag_id',
        'curso_id'
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
