<?php

namespace App\Http\Controllers;

use App\Models\StaiAgendamento;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaiAgendamentoController extends Controller
{

    public function index()
    {
		$staiAgendamento = StaiAgendamento::all();
	    return Inertia::render('Painel/Stai/Agendamentos/Index', [
		    'staiAgendamento' => $staiAgendamento
	    ]);
    }

    public function create()
    {

		return Inertia::render('Painel/Stai/Agendamentos/Novo', ['']);
    }

    public function store(Request $request)
    {
	    $request->validate([
		    'nome' => 'required',
		    'inputs' => 'required'
	    ], [
		    'required' => 'O campo é obrigatório',
	    ]);

        return Inertia::render('Painel/Stai/Agendamentos/Index', ['']);
    }

    public function show($id)
    {
        return Inertia::render('Painel/Stai/Agendamentos/Detalhes', ['']);

    }

    public function edit(Request $request, $id)
    {
        return Inertia::render('Painel/Stai/Agendamentos/Editar', ['']);
    }

    public function update(Request $request, StaiAgendamento $staiAgendamento)
    {
	    $request->validate([
		    'nome' => 'required',
		    'inputs' => 'required'
	    ], [
		    'required' => 'O campo é obrigatório',
	    ]);
        return Inertia::render('Painel/Stai/Agendamentos/Index', ['']);
    }

    public function destroy(StaiAgendamento $staiAgendamento)
    {
        //
    }
}
