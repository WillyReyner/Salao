<?php

namespace App\Http\Controllers;

use App\CustomLog\EditalLog\Models\Activity;
use App\Models\Documentacaoexigida;
use App\Models\Documento;
use App\Models\Edital;
use App\Models\EditalDocumento;
use App\Models\EditalModelo;
use App\Models\Escola;
use App\Models\Municipio;
use App\Models\TipoArquivo;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class EditalController extends Controller
{
	public function __construct()
	{
		$this->middleware(['permission:Index Editais|Criar Editais|Editar Editais|Excluir Editais|Importar Editais|Exportar Editais']);
	}

	public function index()
	{
		$turmas = Turma::all();
		$escolas = Escola::all();
		$municipios = Municipio::all();
		$user = Auth::user();
		$editais = Edital::with('escola', 'municipio', 'tipo_arquivos', 'criadoPor', 'modificadoPor')->get();
		return Inertia::render('Painel/Editais/Index', [
			'editais' => $editais,
			'escolas' => $escolas,
			'municipios' => $municipios,
			'turmas' => $turmas,
			'user' => $user
		]);
	}

	public function show(Request $request, $id)
	{
		$escolas = Escola::all();
		$documentacao_inscricao = Documentacaoexigida::all();
		$documentos = Documento::where('edital_id', $id)->get();
		$edital = Edital::with('escola', 'municipio', 'tipo_arquivos', 'criadoPor', 'modificadoPor')->find($id);
		$turmas = Turma::all();
		$municipios = Municipio::all();
		$anterior = Edital::where('id', '<', $id)->max('id');
		$proximo = Edital::where('id', '>', $id)->min('id');

		$user = Auth::user();
		return Inertia::render('Painel/Editais/Detalhes', [
			'turmas' => $turmas,
			'escolas' => $escolas,
			'edital' => $edital,
			'proximo' => $proximo,
			'anterior' => $anterior,
			'municipios' => $municipios,
			'documentos' => $documentos,
			'user' => $user,
			'documentacao_inscricao' => $documentacao_inscricao
		]);
	}

	public function create()
	{
		$turmas = Turma::all();
		$escolas = Escola::all();
		$documentacao = TipoArquivo::all();
		$editalModelo = EditalModelo::all();

		$municipios = Municipio::all();
		return Inertia::render('Painel/Editais/Novo', [
			'escolas' => $escolas,
			'turmas' => $turmas,
			'municipios' => $municipios,
			'documentacao' => $documentacao,
			'editalModelo' => $editalModelo
		]);
	}

	public function edit(Request $request, $id)
	{
		$escolas = Escola::all();
		$documentos = Documento::where('edital_id', $id)->get();
		$edital = Edital::with('escola', 'municipio', 'tipo_arquivos.tipo_arquivo', 'criadoPor', 'modificadoPor')->find($id);
		$turmas = Turma::all();
		$tipoarquivos = TipoArquivo::all();
		$municipios = Municipio::all();
		$anterior = Edital::where('id', '<', $id)->max('id');
		$proximo = Edital::where('id', '>', $id)->min('id');
		$editalModelo = EditalModelo::all();

		return Inertia::render('Painel/Editais/Editar', [
			'turmas' => $turmas,
			'escolas' => $escolas,
			'edital' => $edital,
			'proximo' => $proximo,
			'anterior' => $anterior,
			'municipios' => $municipios,
			'documentos' => $documentos,
			'tipoarquivos' => $tipoarquivos,
			'editalModelo' => $editalModelo
		]);
	}

	public function store(Request $request)
	{
		$request->validate([
			'nome' => 'required',
			'situacao' => 'required',
			'agendar_publicacao' => 'required',
			'udepi' => 'required',
			'dt_publicacao' => 'required',
			'dt_fim_edital' => 'required',
			'dt_inicio_inscricao' => 'required',
			'dt_fim_inscricao' => 'required',
			'escola_id' => 'required',
			'numero_edital' => 'required',
			'municipio_id' => 'required',
		], [
			'required' => 'O campo é obrigatório',
		]);

		$edital = Edital::create([
			'nome' => $request->nome,
			'situacao' => $request->situacao,
			'agendar_publicacao' => $request->agendar_publicacao,
			'udepi' => $request->udepi,
			'numero_edital' => $request->numero_edital,
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
		$edital->tipo_arquivos()->delete();

		// foreach($request->input('documentos_inscricao') as $documentos_inscricao){
		//     EditalDocumento::insert([
		//         'tipo' => 1,
		//         'edital_id' => $edital->id,
		//         'tipo_arquivo_id' => $documentos_inscricao['value']
		//     ]);
		// }

		foreach ($request->input('documentos_matricula') as $documentos_matricula) {
			EditalDocumento::insert([
				'tipo' => 2,
				'edital_id' => $edital->id,
				'tipo_arquivo_id' => $documentos_matricula['value']
			]);
		}
		return redirect()->route('painel.editais.editar', ['id' => $edital->id])->with('response', $edital);
	}

	public function update(Request $request, $id)
	{
//		if ($request->udepi === 'Sim') {
//			$udepi = '/UDEPI';
//		} else {
//			$udepi = '';
//		}
//
//		$categoria_string = '';
//
//		$turmasId = Turma::where('edital_id', $id)->get();
//		if ($turmasId !== '') {
//
//			$turmasId = Turma::where('edital_id', $id)->get();
//			foreach ($turmasId as $turmaId) {
//				$turmasId = $turmaId->id;
//				$cursoId = $turmaId->curso_id;
//				$cursosId = Curso::where('id', $cursoId)->get();
//
//				$categorias = [];
//				foreach ($cursosId as $cursoId) {
//					$cursosCategoria[] = $cursoId->categoria;
//				}
//				$categorias = array_unique($cursosCategoria);
//				$categoria_string = implode(', ', $categorias);
//			}
//		}
//
//		$modalidades = Turma::where('edital_id', $id)->pluck('modalidade')->toArray();
//		$modalidades = array_unique($modalidades);
//		$modalidade_string = implode(', ', $modalidades);
//
//		$dt_publicacao = date('d/m/y', strtotime($request->dt_publicacao));
//		$nome = "$dt_publicacao Edital - EFG$udepi $categoria_string $modalidade_string";

		$request->validate([
			'nome' => 'required',
			'situacao' => 'required',
			'agendar_publicacao' => 'required',
			'udepi' => 'required',
			'dt_publicacao' => 'required',
			'dt_fim_edital' => 'required',
			'dt_inicio_inscricao' => 'required',
			'dt_fim_inscricao' => 'required',
			'escola_id' => 'required',
			'numero_edital' => 'required',
			'municipio_id' => 'required',
		], [
			'required' => 'O campo é obrigatório',
		]);

		$edital = Edital::find($id);
		$edital->nome = $request->nome;
		$edital->numero_edital = $request->numero_edital;
		$edital->situacao = $request->situacao;
		$edital->agendar_publicacao = $request->agendar_publicacao;
		$edital->udepi = $request->udepi;
		$edital->dt_publicacao = $request->dt_publicacao;
		$edital->dt_fim_edital = $request->dt_fim_edital;
		$edital->dt_inicio_inscricao = $request->dt_inicio_inscricao;
		$edital->dt_fim_inscricao = $request->dt_fim_inscricao;
		$edital->escola_id = $request->escola_id;
		$edital->municipio_id = $request->municipio_id;

		$edital->save();
		$edital->tipo_arquivos()->delete();

		// foreach($request->input('documentos_inscricao') as $documentos_inscricao){
		//     EditalDocumento::insert([
		//         'tipo' => 1,
		//         'edital_id' => $edital->id,
		//         'tipo_arquivo_id' => $documentos_inscricao['value']
		//     ]);
		// }

		foreach ($request->input('documentos_matricula') as $documentos_matricula) {
			EditalDocumento::insert([
				'tipo' => 2,
				'edital_id' => $edital->id,
				'tipo_arquivo_id' => $documentos_matricula['value']
			]);
		}
		return redirect()->route('painel.editais')->with('response', $edital);
	}

	public function autoupdate(Request $request, $id)
	{
		try {
			$edital = Edital::find($id);
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

	public function destroy(Request $request)
	{
		$id = $request->id;
		$edital = is_array($id) ? Edital::destroy($id) : Edital::findOrFail($id)->delete();
		return redirect()->route('painel.editais')->with('response', $edital);
	}

	public function log(Request $request, $id)
	{
		$escolas = Escola::all();
		$edital = Edital::with('escola', 'criadoPor', 'modificadoPor')->find($id);
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