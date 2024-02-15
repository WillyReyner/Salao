<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Curso;
use App\Models\Turma;
use Illuminate\Support\Facades\Storage;

class CursoApiController extends Controller
{

    public function index()
    {
        $turmas = Turma::get();
        $cursos = Curso::with('criadoPor', 'modificadoPor')->get();
        return response()->json([
            'cursos' => $cursos,
            'turmas' => $turmas
        ]);
    }

    public function create()
    {
        $turmas = Turma::all();
        return response()->json([
            'turmas' => $turmas
        ]);
    }

    public function edit($id)
    {
        $curso = Curso::find($id);
        $turmas = Turma::all();
        return response()->json([
            'curso' => $curso, 'turmas' => $turmas
        ]);
    }

    public function show($id)
    {
        $curso = Curso::find($id);
        $turmas = Turma::all();

        return response()->json([
            'curso' => $curso, 'turmas' => $turmas
        ]);
    }

    public function store(Request $request) {
        
        $request->validate([
            'nome' => 'required',
            'situacao' => 'required',
            'link_video_apresentacao' => 'required',
            'objetivos' => 'required',
            'conteudo_programatico' => 'required',
            'campo_atuacao' => 'required',
            'descricao' => 'required',
            'destaque' => 'required',
            'tag' => 'required'
        ], [
            'required' => 'O campo é obrigatório',
        ]);

        $curso = Curso::create([
            'nome' => $request->nome,
            'tag' => implode(', ', $request->tag),
            'situacao' => $request->situacao,
            'link_video_apresentacao' => $request->link_video_apresentacao,
            'objetivos' => $request->objetivos,
            'conteudo_programatico' => $request->conteudo_programatico,
            'campo_atuacao' => $request->campo_atuacao,
            'destaque' => $request->destaque,
            'descricao' => $request->descricao,
            'created_by' => auth()->user()->id,
        ]);
        
        if ($request->file('imagem')) {
            $path = Storage::putFile('cursos/' . $curso->id, $request->file('imagem'));
            $curso->imagem = $path;
        }

        $curso->save();
           
        return response()->json(['message' => 'Curso criada com sucesso', 'turma' => $curso], 201);
    }

    public function update(Request $request, $id) {
        $request->validate([
            'nome' => 'required',
            'situacao' => 'required',
            'link_video_apresentacao' => 'required',
            'objetivos' => 'required',
            'conteudo_programatico' => 'required',
            'campo_atuacao' => 'required',
            'descricao' => 'required',
            'destaque' => 'required',
            'tag' => 'required'
        ], [
            'required' => 'O campo é obrigatório',
        ]);

        $curso = Curso::find($id);
        $curso->nome = $request->nome;
        $curso->situacao = $request->situacao;
        $curso->link_video_apresentacao = $request->link_video_apresentacao;
        $curso->objetivos = $request->objetivos;
        $curso->conteudo_programatico = $request->conteudo_programatico;
        $curso->campo_atuacao = $request->campo_atuacao;
        $curso->descricao = $request->descricao;
        $curso->destaque = $request->destaque;
        $curso->tag = implode(', ', $request->tag);

        $curso->updated_by = auth()->user()->id;
        if($request->file('imagem')){
            $path = Storage::putFile('cursos/'.$curso->id, $request->file('imagem'));
            $curso->imagem = $path;
        }

        $curso->save();

        return response()->json(['message' => 'Curso atualizado com sucesso', 'turma' => $curso], 201);
    }

    public function destroy(Request $request) {

        $id = $request->id;

        $curso = is_array($id) ? Curso::destroy($id) : Curso::findOrFail($id)->delete();

        return response()->json(['message' => 'Curso deletado com sucesso', 'turma' => $curso], 201);
    }
}
