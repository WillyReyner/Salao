<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Turma;
use App\Models\Edital;
use App\Models\Escola;
use App\Models\Documento;
use App\Models\Municipio;
use App\Models\TipoArquivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\CustomLog\EditalLog\Models\Activity;

class EditalApiController extends Controller
{
    public function index()
    {
        $turmas = Turma::all();
        $escolas = Escola::all();
        $municipios = Municipio::all();
        $editais = Edital::with('escola','criadoPor', 'modificadoPor')->get();
        return response()->json([
            'editais' => $editais,
            'escolas' => $escolas,
            'municipios' => $municipios,
            'turmas' => $turmas
        ]);
    }

    public function create()
    {
        $turmas = Turma::all();
        $escolas = Escola::all();
        $tiposArquivo = TipoArquivo::all();
        $municipios = Municipio::all();
        return response()->json([
            'escolas' => $escolas, 
            'tiposArquivo' => $tiposArquivo, 
            'turmas' => $turmas,
            'municipios' => $municipios,
        ]);
    }
    
    public function show(Request $request, $id)
    {
        $escolas = Escola::all();
        $documentos = Documento::where('edital_id', $id)->get();
        $edital = Edital::with('escola', 'documentos', 'documentosExigidos')->find($id);
        $turmas = Turma::all();
        $municipios = Municipio::all();
        $anterior = Edital::where('id', '<', $id)->max('id');
        $proximo = Edital::where('id', '>', $id)->min('id');
        $tiposArquivo = TipoArquivo::all();
        return response()->json([
            'turmas' => $turmas,
            'escolas' => $escolas, 
            'edital' => $edital, 
            'proximo' => $proximo, 
            'anterior' => $anterior, 
            'tiposArquivo' => $tiposArquivo,
            'municipios' => $municipios,
            'documentos' => $documentos
        ]);
    }


    public function edit(Request $request, $id)
    {
        $escolas = Escola::all();
        $documentos = Documento::where('edital_id', $id)->get();
        $edital = Edital::with('escola', 'documentos', 'documentosExigidos')->find($id);
        $turmas = Turma::all();
        $municipios = Municipio::all();
        $edital = Edital::with('escola', 'documentos', 'documentosExigidos')->find($id);
        $anterior = Edital::where('id', '<', $id)->max('id');
        $proximo = Edital::where('id', '>', $id)->min('id');
        $tiposArquivo = TipoArquivo::all();
        return response()->json([
            'turmas' => $turmas,
            'escolas' => $escolas, 
            'edital' => $edital, 
            'proximo' => $proximo, 
            'anterior' => $anterior, 
            'tiposArquivo' => $tiposArquivo,
            'municipios' => $municipios,
            'documentos' => $documentos
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'situacao' => 'required',
            'agendar_publicacao' => 'required',
            'documentos_inscricao' => 'required',
            'udepi' => 'required',
            'dt_publicacao' => 'required',
            'dt_fim_edital' => 'required',
            'dt_inicio_inscricao' => 'required',
            'dt_fim_inscricao' => 'required',
            'escola_id' => 'required',
            'municipio_id' => 'required',
        ], [
            'required' => 'O campo é obrigatório',
        ]);
        $edital = Edital::create([
            'situacao' => $request->situacao,
            'agendar_publicacao' => $request->agendar_publicacao,
            'documentos_inscricao' => implode(', ', $request->documentos_inscricao),
            'udepi' => $request->udepi,
            'contagem_editais' => '0',
            'dt_publicacao' => $request->dt_publicacao,
            'dt_fim_edital' => $request->dt_fim_edital,
            'dt_inicio_inscricao' => $request->dt_inicio_inscricao,
            'dt_fim_inscricao' => $request->dt_fim_inscricao,
            'escola_id' => $request->escola_id,
            'municipio_id' => $request->municipio_id,
            'created_by' => auth()->user()->id,
        ]);

        $edital->save();

        return response()->json(['message' => 'Edital criado com sucesso', 'turma' => $edital], 201);
    }
    
    public function update(Request $request, $id) {
        if($request->udepi === 'Sim'){
            $udepi = '/UDEPI';
        }else { $udepi = ''; }

        $categorias = Turma::where('edital_id', $id)->pluck('categoria')->toArray();
        $modalidades = Turma::where('edital_id', $id)->pluck('modalidade')->toArray();

        // Remova duplicatas das categorias e modalidades
        $categorias = array_unique($categorias);
        $modalidades = array_unique($modalidades);

        $categoria_string = implode(', ', $categorias);
        $modalidade_string = implode(', ', $modalidades);


        $dt_publicacao = date('d/m/y', strtotime($request->dt_publicacao));
        $nome = "$dt_publicacao Edital - EFG$udepi $categoria_string $modalidade_string";
        $request->validate([
            'situacao' => 'required',
            'agendar_publicacao' => 'required',
            'documentos_inscricao' => 'required',
            'udepi' => 'required',
            'dt_publicacao' => 'required',
            'dt_fim_edital' => 'required',
            'dt_inicio_inscricao' => 'required',
            'dt_fim_inscricao' => 'required',
            'escola_id' => 'required',
            'municipio_id' => 'required',
        ], [
            'required' => 'O campo é obrigatório',
        ]);
        $edital = Edital::find($id);
        $edital->nome = $nome;
        $edital->situacao = $request->situacao;
        $edital->agendar_publicacao = $request->agendar_publicacao;

        $documentos_inscricao = is_array($request->documentos_inscricao) ? $request->documentos_inscricao : [$request->documentos_inscricao];
        $edital->documentos_inscricao = implode(', ', $documentos_inscricao);
        
        $edital->udepi = $request->udepi;
        $edital->dt_publicacao = $request->dt_publicacao;
        $edital->dt_fim_edital = $request->dt_fim_edital;
        $edital->dt_inicio_inscricao = $request->dt_inicio_inscricao;
        $edital->dt_fim_inscricao = $request->dt_fim_inscricao;
        $edital->escola_id = $request->escola_id;
        $edital->municipio_id = $request->municipio_id;

        $edital->documentosExigidos()->sync($request->documentosExigidos);
        
        $edital->save();

        return response()->json(['message' => 'Edital atualizado com sucesso', 'turma' => $edital], 201);
    }

    public function destroy(Request $request) {

        $id = $request->id;

        $edital = is_array($id) ? Edital::destroy($id) : Edital::findOrFail($id)->delete();

        return response()->json(['message' => 'Edital deletado com sucesso', 'turma' => $edital], 201);
    }
    
    public function log(Request $request, $id)
    {
        $escolas = Escola::all();
        $edital = Edital::with('escola','criadoPor', 'modificadoPor')->find($id);
        $logs = Activity::where('subject_type', Edital::class)
            ->where('subject_id', $edital->id)
            ->with('causer')
            ->get();
        return Inertia::render('Painel/Editais/Log', [
            'edital' => $edital,
            'escolas' => $escolas,
            'logs' => $logs,
        ]);
    }
}
