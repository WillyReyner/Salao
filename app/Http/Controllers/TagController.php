<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Tag;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Index Tags|Criar Tags|Editar Tags|Excluir Tags|Importar Tags|Exportar Tags']);
    }

    public function index()
    {
        $tags = Tag::with('criadoPor', 'modificadoPor')->get();
        return Inertia::render('Painel/Tags/Index', [
            'tags' => $tags
        ]);
    }

    public function create()
    {
        return Inertia::render('Painel/Tags/Novo');
    }

    public function show($id)
    {
        $Tag = Tag::find($id);
        
        return Inertia::render('Painel/Tags/Detalhes', 
        ['Tag' => $Tag]);
    }

    public function edit(Request $request, $id)
    {
        $Tag = Tag::find($id);
        
        return Inertia::render('Painel/Tags/Editar', 
        ['Tag' => $Tag]);
    }

    public function store(Request $request) {

        $request->validate([
            'nome' => 'required',
	        'inputs' => 'required'
        ], [
            'required' => 'O campo é obrigatório',
        ]);

        $Tag = Tag::create([
            'nome' => $request->nome,
			'inputs' => $request->input('inputs'),
            'situacao' => 'Ativo',
            'created_by' => auth()->user()->id,
        ]);
        
        return redirect()->route('painel.tags')->with('response', $Tag);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'nome' => 'required',
        ], [
            'required' => 'O campo é obrigatório',
        ]);

        $Tag = Tag::find($id);
        $Tag->nome = $request->nome;

        $Tag->updated_by = auth()->user()->id;
        $Tag->save();

        return redirect()->route('painel.tags')->with('response', $Tag);
    }

    public function destroy(Request $request) {

        $id = $request->id;

        $Tag = is_array($id) ? Tag::destroy($id) : Tag::findOrFail($id)->delete();

        return redirect()->route('painel.tags')->with('response', $Tag);
    }
}
