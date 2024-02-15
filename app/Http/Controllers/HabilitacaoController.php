<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Habilitacao;
use Illuminate\Http\Request;

class HabilitacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Index Habilitacao|Criar Habilitacao|Editar Habilitacao|Excluir Habilitacao|Importar Habilitacao|Exportar Habilitacao|Topbar Habilitacao',]);
    }

    public function index()
    {
        $habilitacao = Habilitacao::with('criadoPor', 'modificadoPor')->get();
        return Inertia::render('Painel/Habilitacao/Index', [
            'habilitacao' => $habilitacao
        ]);
    }

    public function create()
    {
        return Inertia::render('Painel/Habilitacao/Novo');
    }

    public function show($id)
    {
        $habilitacao = Habilitacao::find($id);
        
        return Inertia::render('Painel/Habilitacao/Detalhes', 
        ['habilitacao' => $habilitacao]);
    }

    public function edit(Request $request, $id)
    {
        $habilitacao = Habilitacao::find($id);
        
        return Inertia::render('Painel/Habilitacao/Editar', 
        ['habilitacao' => $habilitacao]);
    }

    public function store(Request $request) {

        $request->validate([
            'nome' => 'required'
        ], [
            'required' => 'O campo é obrigatório',
        ]);

        $Tag = Habilitacao::create([
            'nome' => $request->nome,
            'situacao' => 'Ativo',
            'created_by' => auth()->user()->id,
        ]);
        
        return redirect()->route('painel.habilitacao')->with('response', $Tag);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'nome' => 'required',
        ], [
            'required' => 'O campo é obrigatório',
        ]);

        $Tag = Habilitacao::find($id);
        $Tag->nome = $request->nome;

        $Tag->updated_by = auth()->user()->id;
        $Tag->save();

        return redirect()->route('painel.habilitacao')->with('response', $Tag);
    }

    public function destroy(Request $request) {

        $id = $request->id;

        $Tag = is_array($id) ? Habilitacao::destroy($id) : Habilitacao::findOrFail($id)->delete();

        return redirect()->route('painel.habilitacao')->with('response', $Tag);
    }
}
