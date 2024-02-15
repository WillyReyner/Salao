<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\TipoArquivo;
use Spatie\Activitylog\Models\Activity;

class TipoArquivoController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['permission:Index Tipo de Documentos|Criar Tipo de Documentos|Editar Tipo de Documentos|Excluir Tipo de Documentos|Importar Tipo de Documentos|Exportar Tipo de Documentos']);
    // }

    public function index()
    {
        $tiposArquivo = TipoArquivo::with('criadoPor', 'modificadoPor')->get();
        return Inertia::render('Painel/Documentos/Index', [
            'tiposArquivo' => $tiposArquivo
        ]);
    }

    public function show($id)
    {
        $tipoArquivo = TipoArquivo::find($id);
        return Inertia::render('Painel/Documentos/Detalhes', ['tipoArquivo' => $tipoArquivo]);
    }

    public function create()
    {
        return Inertia::render('Painel/Documentos/Novo');
    }

    public function edit(Request $request, $id)
    {
        $tiposArquivo = TipoArquivo::with('criadoPor', 'modificadoPor')->find($id);
        return Inertia::render('Painel/Documentos/Editar', [
            'tiposArquivo' => $tiposArquivo
        ]);
    }

    public function store(Request $request) {

        $request->validate([
            'nome' => 'required',
            'orientacao' => 'required',
            'tipo_arquivo' => 'required',
            'tipo_versao' => 'required',
        ], [
            'required' => 'O campo é obrigatório',
        ]);

        $tipoArquivo = TipoArquivo::create([
            'nome' => $request->nome,
            'orientacao' => $request->orientacao,
            'tipo_arquivo' => $request->tipo_arquivo,
            'tipo_versao' => $request->tipo_versao,
            'created_by' => auth()->user()->id,
        ]);


        return redirect()->route('painel.documento')->with('response', $tipoArquivo);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'nome' => 'required',
            'orientacao' => 'required',
            'tipo_arquivo' => 'required',
            'tipo_versao' => 'required',
        ], [
            'required' => 'O campo é obrigatório',
        ]);

        $tipoArquivo = TipoArquivo::find($id);
        $tipoArquivo->nome = $request->nome;
        $tipoArquivo->tipo_versao = $request->tipo_versao;
        $tipoArquivo->orientacao = $request->orientacao;
        $tipoArquivo->tipo_arquivo = $request->tipo_arquivo;

        $tipoArquivo->updated_by = auth()->user()->id;

        $tipoArquivo->save();

        return redirect()->route('painel.documento')->with('response', $tipoArquivo);
    }

    public function destroy(Request $request) {

        $id = $request->id;

        $tipoArquivo = is_array($id) ? TipoArquivo::destroy($id) : TipoArquivo::findOrFail($id)->delete();

        return redirect()->route('painel.documento')->with('response', $tipoArquivo);
    }
    
    public function log(Request $request, $id)
    {
        $tipoArquivo = TipoArquivo::with('criadoPor', 'modificadoPor')->findOrFail($id);
        $logs = Activity::where('subject_type', TipoArquivo::class)
            ->where('subject_id', $tipoArquivo->id)
            ->with('causer')
            ->get();
        return Inertia::render('Painel/Documentos/Log', [
            'tipoArquivo' => $tipoArquivo,
            'logs' => $logs,
        ]);
    }
}
