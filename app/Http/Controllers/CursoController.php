<?php

namespace App\Http\Controllers;

use App\CustomLog\CursoLog\Models\Activity;
use App\Models\Curso;
use App\Models\Tag;
use App\Models\TagsCursosModel;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class CursoController extends Controller
{
	public function __construct()
	{
		$this->middleware(['permission:Index Cursos|Criar Cursos|Editar Cursos|Excluir Cursos|Importar Cursos|Exportar Cursos']);
	}

	public function index()
	{
		$turmas = Turma::get();
		$tags = Tag::all();
		$cursos = Curso::with('criadoPor', 'modificadoPor', 'tags.tag')->get();
		return Inertia::render('Painel/Cursos/Index', [
			'cursos' => $cursos,
			'turmas' => $turmas,
			'tags' => $tags
		]);
	}

	public function edit($id)
	{
		$curso = Curso::with('tags.tag')->get()->find($id);
		$turmas = Turma::all();
		$tags = Tag::all();
		return Inertia::render('Painel/Cursos/Editar', ['curso' => $curso, 'turmas' => $turmas, 'tags' => $tags]);
	}

	public function show($id)
	{
		$curso = Curso::with('tags.tag')->find($id);
		$turmas = Turma::all();
		return Inertia::render('Painel/Cursos/Detalhes', ['curso' => $curso, 'turmas' => $turmas]);
	}

	public function store(Request $request)
	{

		$request->validate([
			'nome' => 'required',
			'situacao' => 'required',
			'destaque' => 'required',
			'link_video_apresentacao' => 'required',
			'horas_curso' => 'required',
			'nivel' => 'required',
			'faixa_etaria' => 'required',
			'area' => 'required|array',
			'subarea' => 'required|array',
			'texto_site' => 'required',
			'des_texto_site' => 'required',
			'disciplina' => 'required',
			'des_disciplina' => 'required',
			'conteudo_programatico' => 'required',
			'des_conteudo' => 'required',
			'area_atuacao' => 'required',
			'des_area_atuacao' =>'required',
		], [
			'required' => 'O campo é obrigatório',
		]);

		$curso = Curso::create([
			'nome' => $request->nome,
			'id_curso_siga' => $request->id_curso_siga,
			'escola_curso_siga' => $request->escola_curso_siga,
			'situacao' => $request->situacao,
			'destaque' => $request->destaque,
			'link_video_apresentacao' => $request->link_video_apresentacao,
			'horas_curso' => $request->horas_curso,
			'nivel' => $request->nivel,
			'faixa_etaria' => $request->faixa_etaria,
			'texto_site' => $request->texto_site,
			'des_texto_site' => $request->des_texto_site,
			'disciplina' => $request->disciplina,
			'des_disciplina' => $request->des_disciplina,
			'conteudo_programatico' => $request->conteudo_programatico,
			'des_conteudo' => $request->des_conteudo,
			'area_atuacao' => $request->area_atuacao,
			'des_area_atuacao' => $request->des_area_atuacao,
			'created_by' => auth()->user()->id,
		]);

		$curso->tags()->delete();

		foreach ($request->input('area') as $tags) {
			TagsCursosModel::insert([
				'curso_id' => $curso->id,
				'tag_id' => $tags['value'],
				'tipo' => 'area'
			]);
		}

		foreach ($request->input('subarea') as $tags) {
			TagsCursosModel::insert([
				'curso_id' => $curso->id,
				'tag_id' => $tags['value'],
				'tipo' => 'subarea'
			]);
		}

		if ($request->file('imagem')) {
			$path = Storage::putFile('cursos/' . $curso->id, $request->file('imagem'));
			$curso->imagem = $path;
		}

		return redirect()->route('painel.cursos')->with('response', $curso);
	}

	public function create()
	{
		$turmas = Turma::all();
		$tags = Tag::all();
		return Inertia::render('Painel/Cursos/Novo', ['turmas' => $turmas, 'tags' => $tags]);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'nome' => 'required',
			'situacao' => 'required',
			'destaque' => 'required',
			'link_video_apresentacao' => 'required',
			'horas_curso' => 'required',
			'nivel' => 'required',
			'faixa_etaria' => 'required',
			'area' => 'required|array',
			'subarea' => 'required|array',
			'texto_site' => 'required',
			'des_texto_site' => 'required',
			'disciplina' => 'required',
			'des_disciplina' => 'required',
			'conteudo_programatico' => 'required',
			'des_conteudo' => 'required',
			'area_atuacao' => 'required',
			'des_area_atuacao' =>'required',
		], [
			'required' => 'O campo é obrigatório',
		]);

		$curso = Curso::find($id);
		$curso->nome = $request->nome;
		$curso->id_curso_siga = $request->id_curso_siga;
		$curso->escola_curso_siga = $request->escola_curso_siga;
		$curso->situacao = $request->situacao;
		$curso->destaque = $request->destaque;
		$curso->link_video_apresentacao = $request->link_video_apresentacao;
		$curso->horas_curso = $request->horas_curso;
		$curso->nivel = $request->nivel;
		$curso->faixa_etaria = $request->faixa_etaria;
		$curso->texto_site = $request->texto_site;
		$curso->des_texto_site = $request->des_texto_site;
		$curso->disciplina = $request->disciplina;
		$curso->des_disciplina = $request->des_disciplina;
		$curso->conteudo_programatico = $request->conteudo_programatico;
		$curso->des_conteudo = $request->des_conteudo;
		$curso->area_atuacao = $request->area_atuacao;
		$curso->des_area_atuacao = $request->des_area_atuacao;

		$curso->updated_by = auth()->user()->id;

		if ($request->file('imagem')) {
			$path = Storage::putFile('cursos/' . $curso->id, $request->file('imagem'));
			$curso->imagem = $path;
		}

		$curso->save();

		$curso->tags()->delete();

		foreach ($request->input('area') as $tags) {
			TagsCursosModel::insert([
				'curso_id' => $curso->id,
				'tag_id' => $tags['value'],
				'tipo' => 'area'
			]);
		}

		foreach ($request->input('subarea') as $tags) {
			TagsCursosModel::insert([
				'curso_id' => $curso->id,
				'tag_id' => $tags['value'],
				'tipo' => 'subarea'
			]);
		}

		return redirect()->route('painel.cursos')->with('response', $curso);
	}

	public function destroy(Request $request)
	{

		$id = $request->id;

		$curso = is_array($id) ? Curso::destroy($id) : Curso::findOrFail($id)->delete();

		return redirect()->route('painel.cursos')->with('response', $curso);
	}

	public function Importar(Request $request)
	{
		$arquivo = $request->file('arquivo');

		$linhas = array_map('str_getcsv', file($arquivo->path()));
		$cabecalho = array_shift($linhas);

		foreach ($linhas as $linha) {
			try {
				$dados = array_combine($cabecalho, $linha);
				if (!empty($dados['nome']) && is_string($dados['nome'])) {
					$nomesSiga = explode(',', $dados['nome']);
					foreach ($nomesSiga as $registro) {
						preg_match('/^(.*?)\s*(\d+\s*HR)\s*ID\s*(\d+)$/', $registro, $matches);
						$nome = $matches[1];
						$hora = $matches[2];
						$hora = str_replace('HR', 'Horas', $matches[2]);
						$substituicoes = ['CAPACITAÇÃO' => 'Capacitação', 'QUALIFICAÇÃO' => 'Qualificação', 'TÉCNICO' => 'Técnico', 'SUPERIOR' => 'Superior',];

						$tipo = str_replace(array_keys($substituicoes), array_values($substituicoes), $dados['tipo']);

						$curso = Curso::create([
							'id_curso_siga' => $dados['id_cursos'],
							'nome' => $nome,
							'imagem' => '1',
							'horas_curso' => $hora,
							'situacao' => 'Ativo',
							'escola_curso_siga' => $dados['escola'],
						]);
					}
				} else {
					Log::warning('Campo "nome" não é uma string ou está vazio.', ['dados' => $dados]);
				}
			} catch (\Exception $e) {
				Log::error('Erro ao salvar curso:', ['exception' => $e]);
			}
		}
		$turmas = Turma::get();
		$tags = Tag::all();
		$cursos = Curso::with('criadoPor', 'modificadoPor', 'tags.tag')->get();
		return Inertia::render('Painel/Cursos/Index', [
			'cursos' => $cursos,
			'turmas' => $turmas,
			'tags' => $tags,
			'contador' => count($linhas)
		]);
	}

	public function log(Request $request, $id)
	{
		$tag = Tag::all();
		$curso = Curso::with('tags', 'criadoPor', 'modificadoPor')->findOrFail($id);
		$logs = Activity::where('subject_type', Curso::class)
			->where('subject_id', $curso->id)
			->with('causer')
			->get();

		return Inertia::render('Painel/Cursos/Log', [
			'curso' => $curso,
			'logs' => $logs,
			'tag' => $tag
		]);
	}
}
