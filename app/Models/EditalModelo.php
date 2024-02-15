<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EditalModelo extends Model
{
    use HasFactory, softDeletes;
	protected $table = 'edital_modelo';

	protected $fillable = [
		'nome',
	];
}
