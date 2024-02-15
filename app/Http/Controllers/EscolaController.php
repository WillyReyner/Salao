<?php

namespace App\Http\Controllers;

use App\Models\Escola;
use App\Models\EscolaResponsavel;
use App\Models\Municipio;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Activitylog\Models\Activity;

class EscolaController extends Controller
{
	public function __construct()
	{
		$this->middleware(['permission:Index Escolas|Criar Escolas|Editar Escolas|Excluir Escolas|Importar Escolas|Exportar Escolas']);
	}

	public function index()
	{
		$municipios = Municipio::all();
		$escolas = Escola::with('criadoPor', 'modificadoPor', 'municipio',)->get();
		return Inertia::render('Painel/Escolas/Index', [
			'escolas' => $escolas,
			'municipios' => $municipios
		]);
	}

	public function show(Request $request, $id)
	{
		$escola = Escola::with('municipio')->find($id);
		$responsaveis = User::all();

		return Inertia::render('Painel/Escolas/Detalhes', ['escola' => $escola, 'responsaveis' => $responsaveis]);
	}

	public function edit(Request $request, $id)
	{
		$municipios = Municipio::all();
		$usuarios = User::all();

		$escola = Escola::with(['municipio', 'responsaveis.user'])->find($id);
		return Inertia::render('Painel/Escolas/Editar', ['municipios' => $municipios, 'usuarios' => $usuarios, 'escola' => $escola]);
	}

	public function store(Request $request)
	{
		$request->validate([
			'nome' => 'required',
			'situacao' => 'required',
			'rede' => 'required',
			'ficha' => 'required',
			'endereco_completo' => 'required',
			'contato' => 'required',
			'municipio_id' => 'required',
			'user_id' => 'required|array',
		], [
			'required' => 'O campo é obrigatório',
			'user_id.array' => 'O campo de responsáveis deve ser uma lista de usuários',
		]);

		// Crie a escola
		$escola = Escola::create([
			'nome' => $request->nome,
			'situacao' => $request->situacao,
			'rede' => $request->rede,
			'ficha' => $request->ficha,
			'endereco_completo' => $request->endereco_completo,
			'contato' => $request->contato,
			'municipio_id' => $request->municipio_id,
			'created_by' => auth()->user()->id,
		]);

		$escola->responsaveis()->delete();

		foreach ($request->user_id as $user) {
			EscolaResponsavel::insert([
				'escola_id' => $escola->id,
				'user_id' => $user
			]);
		}
		return redirect()->route('painel.escolas')->with('response', $escola);
	}

	public function create()
	{
		$municipios = Municipio::all();
		$responsaveis = User::all();

		return Inertia::render('Painel/Escolas/Novo', ['municipios' => $municipios, 'responsaveis' => $responsaveis]);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'nome' => 'required',
			'situacao' => 'required',
			'rede' => 'required',
			'ficha' => 'required',
			'endereco_completo' => 'required',
			'contato' => 'required',
			'municipio_id' => 'required',
			'user_id' => 'required|array',
		], [
			'required' => 'O campo é obrigatório',
			'user_id.array' => 'O campo de responsáveis deve ser uma lista de usuários',
		]);

		$escola = Escola::find($id);
		$escola->nome = $request->nome;
		$escola->situacao = $request->situacao;
		$escola->rede = $request->rede;
		$escola->ficha = $request->ficha;
		$escola->endereco_completo = $request->endereco_completo;
		$escola->contato = $request->contato;
		$escola->municipio_id = $request->municipio_id;
		$escola->updated_by = auth()->user()->id;
		$escola->save();

		$escola->responsaveis()->delete();

		foreach ($request->user_id as $user) {
			EscolaResponsavel::insert([
				'escola_id' => $escola->id,
				'user_id' => $user['value']
			]);
		}

		return redirect()->route('painel.escolas')->with('response', $escola);
	}


	public function destroy(Request $request)
	{

		$id = $request->id;

		$escola = is_array($id) ? Escola::destroy($id) : Escola::findOrFail($id)->delete();

		return redirect()->route('painel.escolas')->with('response', $escola);
	}

	public function log(Request $request, $id)
	{
		$escola = Escola::with('criadoPor', 'modificadoPor', 'municipio', 'responsaveis')->findOrFail($id);
		$municipios = Municipio::all();
		$logs = Activity::where('subject_type', Escola::class)
			->where('subject_id', $escola->id)
			->with('causer')
			->get();

		return Inertia::render('Painel/Escolas/Log', [
			'escola' => $escola,
			'municipios' => $municipios,
			'logs' => $logs,
		]);
	}
}
