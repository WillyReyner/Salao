<?php

namespace App\Http\Controllers;

use App\Models\Edital;
use App\Models\StaiEditais;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaiEditaisController extends Controller
{
    public function index()
    {
		$staiEditais = StaiEditais::all();
        return Inertia::render('Painel/Stai/Editais/Index',
	        ['staiEditais' => $staiEditais]);
    }

    public function create()
    {
        return Inertia::render('Painel/Stai/Editais/Novo', ['']);
    }

    public function store(Request $request)
    {
	    $request->validate([
		    'nome' => 'required',
		    'situacao' => 'required',
		    'data_publicacao' => 'required',
		    'data_fim_edital' => 'required',
		    'dt_inicio_inscricao' => 'required',
		    'dt_fim_inscricao' => 'required',
			'tipo' => 'required',
	    ], [
		    'required' => 'O campo é obrigatório',
	    ]);

	    $edital = StaiEditais::create([
		    'nome' => $request->nome,
		    'situacao' => $request->situacao,
		    'agendar_publicacao' => $request->agendar_publicacao,
		    'data_publicacao' => $request->data_publicacao,
		    'data_fim_edital' => $request->data_fim_edital,
		    'dt_inicio_inscricao' => $request->dt_inicio_inscricao,
		    'dt_fim_inscricao' => $request->dt_fim_inscricao,
			'tipo' => $request->tipo,
		    'created_by' => auth()->user()->id,
	    ]);

	    $edital->save();

        return Inertia::render('Painel/Stai/Editais/Index', ['']);
    }

    public function show($id)
    {
        return Inertia::render('Painel/Stai/Editais/Detalhes', ['']);
    }

    public function edit(Request $request, $id)
    {
        return Inertia::render('Painel/Stai/Editais/Editar', ['']);
    }

    public function update(Request $request, $id)
    {
	    $request->validate([
		    'nome' => 'required',
		    'inputs' => 'required'
	    ], [
		    'required' => 'O campo é obrigatório',
	    ]);
        return Inertia::render('Painel/Stai/Editais/Index', ['']);
    }

    public function destroy(StaiAgendamento $staiAgendamento)
    {
        //
    }

	public function autoupdate(Request $request, $id)
	{
		try {
			$edital = staiEditais::find($id);
			if (!$edital) {
				return response()->json(['message' => 'Edital não encontrado'], 404);
			}

			// Defina o estado do edital como "Expirado"
			$edital->situacao = 'Finalizado';
			$edital->save();
		} catch (\Exception $e) {
			return response()->json(['message' => 'Erro ao atualizar o edital'], 500);
		}
	}
}
