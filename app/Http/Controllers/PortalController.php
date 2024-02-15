<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Turma;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PortalController extends Controller
{
    public function index()
    {
		$turmas = Turma::with('edital', 'escola', 'curso', 'inscricoes', 'tipo_arquivos')
			->where('situacao', 'Ativo')
			->get();

		$curso = Curso::paginate(10);
	    return Inertia::render('Portal/Index', [
		    'cursos' => $curso,
		    'turmas' => $turmas,
	    ]);
    }
}
