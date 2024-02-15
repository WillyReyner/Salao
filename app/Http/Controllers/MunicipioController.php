<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Municipio;
use Spatie\Activitylog\Models\Activity;

class MunicipioController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:Index Municipios|Criar Municipios|Editar Municipios|Excluir Municipios|Importar Municipios|Exportar Municipios']);
    }

    public function index()
    {
        $municipios = Municipio::with('criadoPor', 'modificadoPor')->get();
        return Inertia::render('Painel/Municipios/Index', [
            'municipios' => $municipios
        ]);
    }

    public function create()
    {
        return Inertia::render('Painel/Municipios/Novo');
    }

    public function show(Request $request, $id)
    {
        $municipio = Municipio::find($id);
        
        return Inertia::render('Painel/Municipios/Detalhes', [
            'municipio' => $municipio
        ]);
    }

    public function edit(Request $request, $id)
    {
        $municipio = Municipio::find($id);
        
        return Inertia::render('Painel/Municipios/Editar', 
        ['municipio' => $municipio]);
    }

    public function store(Request $request) {

        $request->validate([
            'nome' => 'required',
            'situacao' => 'required',
            'uf' => 'required',
        ], [
            'required' => 'O campo é obrigatório',
        ]);

        $municipio = Municipio::create([
            'nome' => $request->nome,
            'situacao' => $request->situacao,
            'uf' => $request->uf,
            'created_by' => auth()->user()->id,
        ]);


        return redirect()->route('painel.municipios')->with('response', $municipio);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'nome' => 'required',
            'situacao' => 'required',
            'uf' => 'required',
        ], [
            'required' => 'O campo é obrigatório',
        ]);

        $municipio = Municipio::find($id);
        $municipio->nome = $request->nome;
        $municipio->situacao = $request->situacao;
        $municipio->uf = $request->uf;

        $municipio->updated_by = auth()->user()->id;

        $municipio->save();

        return redirect()->route('painel.municipios')->with('response', $municipio);
    }

    public function destroy(Request $request) {

        $id = $request->id;

        $municipio = is_array($id) ? Municipio::destroy($id) : Municipio::findOrFail($id)->delete();

        return redirect()->route('painel.municipios')->with('response', $municipio);
    }
    
    public function log(Request $request, $id)
    {
        $municipio = Municipio::with('criadoPor', 'modificadoPor')->findOrFail($id);
        $logs = Activity::where('subject_type', Municipio::class)
            ->where('subject_id', $municipio->id)
            ->with('causer')
            ->get();
        return Inertia::render('Painel/Municipios/Log', [
            'municipio' => $municipio,
            'logs' => $logs,
        ]);
    }
}
