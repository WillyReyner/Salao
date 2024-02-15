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
        return response()->json([
            'tags' => $tags,
        ]);
    }

    public function create()
    {
        return Inertia::render('Painel/Tags/Novo');
    }

    public function edit(Request $request, $id)
    {
        $tags = Tag::find($id);
        
        return response()->json([
            'tags' => $tags,
        ]);
    }

    public function store(Request $request) {

        $request->validate([
            'nome' => 'required'
        ], [
            'required' => 'O campo é obrigatório',
        ]);

        $tags = Tag::create([
            'nome' => $request->nome,
            'situacao' => 'Ativo',
            'created_by' => auth()->user()->id,
        ]);

        return response()->json(['message' => 'Tag criada com sucesso', 'tags' => $tags], 201);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'nome' => 'required',
        ], [
            'required' => 'O campo é obrigatório',
        ]);

        $tags = Tag::find($id);
        $tags->nome = $request->nome;

        $tags->updated_by = auth()->user()->id;
        $tags->save();
        
        return response()->json(['message' => 'Tag atualizada com sucesso', 'tags' => $tags], 201);
    }

    public function destroy(Request $request) {

        $id = $request->id;

        $tags = is_array($id) ? Tag::destroy($id) : Tag::findOrFail($id)->delete();

        return response()->json(['message' => 'Tag excluida com sucesso', 'tags' => $tags], 201);
    }
}
