<?php

namespace App\Http\Controllers;

use App\CustomLog\TurmaLog\Models\Activity;
use App\Models\Curso;
use App\Models\Edital;
use App\Models\Escola;
use App\Models\Habilitacao;
use App\Models\Inscricao;
use App\Models\TipoArquivo;
use App\Models\Turma;
use App\Models\TurmaDocumento;
use App\Models\TurmaHabilitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class TurmaController extends Controller
{
	public function __construct()
	{
		$this->middleware(['permission:Index Turmas|Criar Turmas|Editar Turmas|Excluir Turmas|Importar Turmas|Exportar Turmas']);
	}

	public function index()
	{
		$escolas = Escola::all();
		$editais = Edital::all();
		$cursos = Curso::all();
		$habilitacao = Habilitacao::all();
		$turmas = Turma::with('edital', 'curso', 'criadoPor', 'modificadoPor')->get();
		return Inertia::render('Painel/Turmas/Index', [
			'turmas' => $turmas,
			'escolas' => $escolas,
			'editais' => $editais,
			'cursos' => $cursos,
			'habilitacao' => $habilitacao,
		]);
	}

	public function show($id)
	{
		$turma = Turma::with('inscricoes', 'edital', 'curso', 'criadoPor', 'modificadoPor')->find($id);
		return Inertia::render('Painel/Turmas/Detalhes', [
			'turma' => $turma
		]);
	}

	public function edit($id)
	{
		$cursos = Curso::all();
		$editais = Edital::all();
		$turma = Turma::with('edital', 'curso', 'escola', 'tipo_arquivos.tipo_arquivo', 'tipo_arquivos_habilitacao.habilitacao', 'criadoPor', 'modificadoPor')->find($id);
		$turmaNome = $turma->nome;
		$escolas = Escola::all();
		$documentacao = TipoArquivo::all();
		$habilitacao = Habilitacao::all();
		return Inertia::render('Painel/Turmas/Editar', [
			'turma' => $turma,
			'cursos' => $cursos,
			'editais' => $editais,
			'turmaNome' => $turmaNome,
			'escolas' => $escolas,
			'documentacao' => $documentacao,
			'habilitacao' => $habilitacao,
		]);
	}

	public function store(Request $request)
	{
		$request->validate([
			'dias_semana' => 'required',
			'faixa_etaria' => 'required',
			'edital_id' => 'required',
			'curso_id' => 'required',
			'vagas' => 'required',
			'turno' => 'required',
			'hora_inicio' => 'required',
			'hora_termino' => 'required',
			'data_inicio' => 'required',
		], [
			'required' => 'O campo é obrigatório',
		]);

		if ($request->turno === 'Matutino') {
			$turnonome = 'M';
		} elseif ($request->turno === 'Vespertino') {
			$turnonome = 'T';
		} elseif ($request->turno === 'Integral') {
			$turnonome = 'I';
		} else {
			$turnonome = 'N';
		}

		if ($request->dias_semana === 'Domingo') {
			$dias_semana_id = '1';
		} elseif ($request->dias_semana === 'Segunda') {
			$dias_semana_id = '2';
		} elseif ($request->dias_semana === 'Terça') {
			$dias_semana_id = '3';
		} elseif ($request->dias_semana === 'Quarta') {
			$dias_semana_id = '4';
		} elseif ($request->dias_semana === 'Quinta') {
			$dias_semana_id = '5';
		} elseif ($request->dias_semana === 'Sexta') {
			$dias_semana_id = '6';
		} elseif ($request->dias_semana === 'Sabado') {
			$dias_semana_id = '7';
		} else {
			$dias_semana_id = '8';
		}

		$horario_inicial = $request->hora_inicio;
		$partes = explode(":", $horario_inicial);
		$hora_i = $partes[0];

		$horario_final = $request->hora_termino;
		$partes = explode(":", $horario_final);
		$hora_f = $partes[0];

		if ($hora_i >= 7 && $hora_f < 12) {
			$turno_t = 'M';
		} elseif ($hora_i >= 12 && $hora_f < 17) {
			$turno_t = 'T';
		} elseif ($hora_i >= 17 && $hora_f < 22) {
			$turno_t = 'N';
		} elseif ($hora_i >= 7 && $hora_f < 22) {
			$turno_t = 'I';
		} else {
			$turno_t = 'Outro';
		}

		if ($turno_t === 'M' && $hora_i == '07' && $hora_f == '08') {
			$horario_id = '1';
		} elseif ($turno_t === 'M' && $hora_i == '08' && $hora_f == '09') {
			$horario_id = '2';
		} elseif ($turno_t === 'M' && $hora_i == '09' && $hora_f == '10') {
			$horario_id = '3';
		} elseif ($turno_t === 'M' && $hora_i == '10' && $hora_f == '11') {
			$horario_id = '4';
		} elseif ($turno_t === 'M' && $hora_i == '11' && $hora_f == '12') {
			$horario_id = '5';
		}

		if ($turno_t === 'T' && $hora_i == '12' && $hora_f == '13') {
			$horario_id = '1';
		} elseif ($turno_t === 'T' && $hora_i == '13' && $hora_f == '14') {
			$horario_id = '2';
		} elseif ($turno_t === 'T' && $hora_i == '14' && $hora_f == '15') {
			$horario_id = '3';
		} elseif ($turno_t === 'T' && $hora_i == '15' && $hora_f == '16') {
			$horario_id = '4';
		} elseif ($turno_t === 'T' && $hora_i == '16' && $hora_f == '17') {
			$horario_id = '5';
		}

		if ($turno_t === 'N' && $hora_i == '17' && $hora_f == '18') {
			$horario_id = '1';
		} elseif ($turno_t === 'N' && $hora_i == '18' && $hora_f == '19') {
			$horario_id = '2';
		} elseif ($turno_t === 'N' && $hora_i == '19' && $hora_f == '20') {
			$horario_id = '3';
		} elseif ($turno_t === 'N' && $hora_i == '20' && $hora_f == '21') {
			$horario_id = '4';
		} elseif ($turno_t === 'N' && $hora_i == '21' && $hora_f == '22') {
			$horario_id = '5';
		}

		if ($turno_t === 'I' && $hora_i == '07' && $hora_f == '08') {
			$horario_id = '1';
		} elseif ($turno_t === 'I' && $hora_i == '08' && $hora_f == '09') {
			$horario_id = '2';
		} elseif ($turno_t === 'I' && $hora_i == '09' && $hora_f == '10') {
			$horario_id = '3';
		} elseif ($turno_t === 'I' && $hora_i == '10' && $hora_f == '11') {
			$horario_id = '4';
		} elseif ($turno_t === 'I' && $hora_i == '11' && $hora_f == '12') {
			$horario_id = '5';
		} elseif ($turno_t === 'I' && $hora_i == '12' && $hora_f == '13') {
			$horario_id = '5';
		} elseif ($turno_t === 'I' && $hora_i == '13' && $hora_f == '14') {
			$horario_id = '6';
		} elseif ($turno_t === 'I' && $hora_i == '14' && $hora_f == '15') {
			$horario_id = '7';
		} elseif ($turno_t === 'I' && $hora_i == '15' && $hora_f == '16') {
			$horario_id = '8';
		} elseif ($turno_t === 'I' && $hora_i == '16' && $hora_f == '17') {
			$horario_id = '9';
		} elseif ($turno_t === 'I' && $hora_i == '17' && $hora_f == '18') {
			$horario_id = '10';
		} elseif ($turno_t === 'I' && $hora_i == '18' && $hora_f == '19') {
			$horario_id = '11';
		} elseif ($turno_t === 'I' && $hora_i == '19' && $hora_f == '20') {
			$horario_id = '12';
		} elseif ($turno_t === 'I' && $hora_i == '20' && $hora_f == '21') {
			$horario_id = '13';
		} elseif ($turno_t === 'I' && $hora_i == '21' && $hora_f == '22') {
			$horario_id = '14';
		}

		$cursos = Curso::where('nome', $request->curso_id)->get();
		foreach ($cursos as $curso) {
			$cursoId = $curso->id;
			$cursonome = $curso->nome;
			$cursocategoria = $curso->categoria;
		}

		$editais = Edital::where('nome', $request->edital_id)->get();
		foreach ($editais as $edital) {
			$editalId = $edital->id;
		}

		if ($request->teste_presencial_escola != null) {
			$escolas = Escola::where('nome', $request->teste_presencial_escola)->get();
			foreach ($escolas as $escola) {
				$escolaId = $escola->id;
			}
		} else {
			$escolaId = $request->teste_presencial_escola;
		}

		//Gravação no banco de dados
		$turma = Turma::create([
			'nome' => "$editalId Edital - EFG/UDEPI - $cursonome - $cursocategoria - $request->modalidade - $dias_semana_id$turnonome",
			'situacao' => 'Ativo',
			'dias_semana' => implode(', ', $request->dias_semana),
			'faixa_etaria' => $request->faixa_etaria,
			'modalidade' => $request->modalidade,
			'edital_id' => $editalId,
			'curso_id' => $cursoId,
			'vagas' => $request->vagas,
			'turno' => $request->turno,
			'hora_inicio' => date('Y-m-d H:i:s', strtotime($request->hora_inicio)),
			'hora_termino' => date('Y-m-d H:i:s', strtotime($request->hora_termino)),
			'data_inicio' => $request->data_inicio,
			'habilitacao' => $request->habilitacao,
			'teste_aptidao' => $request->accept,
			'teste_aptidao_local_online' => $request->local_teste_online,
			'teste_aptidao_local_presencial' => $request->local_teste_presencial,
			'teste_aptidao_data_online' => $request->data_limite_teste_online,
			'teste_aptidao_data_presencial' => $request->data_limite_teste_presencial,
			'teste_aptidao_hora_presencial' => $request->hora_limite_teste_presencial,
			'teste_aptidao_sala_presencial' => $request->sala_teste_presencial,
			'teste_aptidao_idade' => $request->accept_idade,
			'teste_aptidao_idade_minima' => $request->idade_minima,
			'teste_aptidao_escola_presencial' => $escolaId,
			'created_by' => auth()->user()->id,
		]);

		$turma->save();
		$turma->tipo_arquivos()->delete();
		$turma->tipo_arquivos_habilitacao()->delete();

		if ($request->input('testes_exigidos')) {
			foreach ($request->input('testes_exigidos') as $documentos_inscricao) {
				TurmaDocumento::insert([
					'tipo' => 1,
					'turma_id' => $turma->id,
					'tipo_arquivo_id' => $documentos_inscricao['value']
				]);
			}
		}

		if ($request->input('habilitacoes_exigidas')) {

			foreach ($request->input('habilitacoes_exigidas') as $habilitacao_exigida) {
				TurmaHabilitacao::insert([
					'turma_id' => $turma->id,
					'habilitacao_id' => $habilitacao_exigida['value']
				]);
			}
		}

		if ($request->file('imagem')) {
			$path = Storage::putFile('turmas/' . $turma->id, $request->file('imagem'));
			$turma->imagem = $path;
		}
		return redirect()->route('painel.turmas')->with('response', $turma);
	}

	public function create()
	{
		$cursos = Curso::all();
		$editais = Edital::all();
		$documentacao = TipoArquivo::all();
		$escolas = Escola::all();
		$habilitacao = Habilitacao::all();

		return Inertia::render('Painel/Turmas/Novo', [
			'cursos' => $cursos,
			'editais' => $editais,
			'documentacao' => $documentacao,
			'escolas' => $escolas,
			'habilitacao' => $habilitacao,
		]);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'dias_semana' => 'required',
			'faixa_etaria' => 'required',
			'edital_id' => 'required',
			'curso_id' => 'required',
			'vagas' => 'required',
			'turno' => 'required',
			'hora_inicio' => 'required',
			'hora_termino' => 'required',
			'data_inicio' => 'required',
		], [
			'required' => 'O campo é obrigatório',
		]);

		if ($request->turno === 'Matutino') {
			$turnonome = 'M';
		} elseif ($request->turno === 'Vespertino') {
			$turnonome = 'T';
		} elseif ($request->turno === 'Integral') {
			$turnonome = 'I';
		} else {
			$turnonome = 'N';
		}

		if ($request->dias_semana === 'Domingo') {
			$dias_semana_id = '1';
		} elseif ($request->dias_semana === 'Segunda') {
			$dias_semana_id = '2';
		} elseif ($request->dias_semana === 'Terça') {
			$dias_semana_id = '3';
		} elseif ($request->dias_semana === 'Quarta') {
			$dias_semana_id = '4';
		} elseif ($request->dias_semana === 'Quinta') {
			$dias_semana_id = '5';
		} elseif ($request->dias_semana === 'Sexta') {
			$dias_semana_id = '6';
		} elseif ($request->dias_semana === 'Sabado') {
			$dias_semana_id = '7';
		} else {
			$dias_semana_id = '8';
		}

		$horario_inicial = $request->hora_inicio;
		$partes = explode(":", $horario_inicial);
		$hora_i = $partes[0];

		$horario_final = $request->hora_termino;
		$partes = explode(":", $horario_final);
		$hora_f = $partes[0];

		if ($hora_i >= 7 && $hora_f < 12) {
			$turno_t = 'M';
		} elseif ($hora_i >= 12 && $hora_f < 17) {
			$turno_t = 'T';
		} elseif ($hora_i >= 17 && $hora_f < 22) {
			$turno_t = 'N';
		} elseif ($hora_i >= 7 && $hora_f < 22) {
			$turno_t = 'I';
		} else {
			$turno_t = 'Outro';
		}

		if ($turno_t === 'M' && $hora_i == '07' && $hora_f == '08') {
			$horario_id = '1';
		} elseif ($turno_t === 'M' && $hora_i == '08' && $hora_f == '09') {
			$horario_id = '2';
		} elseif ($turno_t === 'M' && $hora_i == '09' && $hora_f == '10') {
			$horario_id = '3';
		} elseif ($turno_t === 'M' && $hora_i == '10' && $hora_f == '11') {
			$horario_id = '4';
		} elseif ($turno_t === 'M' && $hora_i == '11' && $hora_f == '12') {
			$horario_id = '5';
		}

		if ($turno_t === 'T' && $hora_i == '12' && $hora_f == '13') {
			$horario_id = '1';
		} elseif ($turno_t === 'T' && $hora_i == '13' && $hora_f == '14') {
			$horario_id = '2';
		} elseif ($turno_t === 'T' && $hora_i == '14' && $hora_f == '15') {
			$horario_id = '3';
		} elseif ($turno_t === 'T' && $hora_i == '15' && $hora_f == '16') {
			$horario_id = '4';
		} elseif ($turno_t === 'T' && $hora_i == '16' && $hora_f == '17') {
			$horario_id = '5';
		}

		if ($turno_t === 'N' && $hora_i == '17' && $hora_f == '18') {
			$horario_id = '1';
		} elseif ($turno_t === 'N' && $hora_i == '18' && $hora_f == '19') {
			$horario_id = '2';
		} elseif ($turno_t === 'N' && $hora_i == '19' && $hora_f == '20') {
			$horario_id = '3';
		} elseif ($turno_t === 'N' && $hora_i == '20' && $hora_f == '21') {
			$horario_id = '4';
		} elseif ($turno_t === 'N' && $hora_i == '21' && $hora_f == '22') {
			$horario_id = '5';
		}

		if ($turno_t === 'I' && $hora_i == '07' && $hora_f == '08') {
			$horario_id = '1';
		} elseif ($turno_t === 'I' && $hora_i == '08' && $hora_f == '09') {
			$horario_id = '2';
		} elseif ($turno_t === 'I' && $hora_i == '09' && $hora_f == '10') {
			$horario_id = '3';
		} elseif ($turno_t === 'I' && $hora_i == '10' && $hora_f == '11') {
			$horario_id = '4';
		} elseif ($turno_t === 'I' && $hora_i == '11' && $hora_f == '12') {
			$horario_id = '5';
		} elseif ($turno_t === 'I' && $hora_i == '12' && $hora_f == '13') {
			$horario_id = '5';
		} elseif ($turno_t === 'I' && $hora_i == '13' && $hora_f == '14') {
			$horario_id = '6';
		} elseif ($turno_t === 'I' && $hora_i == '14' && $hora_f == '15') {
			$horario_id = '7';
		} elseif ($turno_t === 'I' && $hora_i == '15' && $hora_f == '16') {
			$horario_id = '8';
		} elseif ($turno_t === 'I' && $hora_i == '16' && $hora_f == '17') {
			$horario_id = '9';
		} elseif ($turno_t === 'I' && $hora_i == '17' && $hora_f == '18') {
			$horario_id = '10';
		} elseif ($turno_t === 'I' && $hora_i == '18' && $hora_f == '19') {
			$horario_id = '11';
		} elseif ($turno_t === 'I' && $hora_i == '19' && $hora_f == '20') {
			$horario_id = '12';
		} elseif ($turno_t === 'I' && $hora_i == '20' && $hora_f == '21') {
			$horario_id = '13';
		} elseif ($turno_t === 'I' && $hora_i == '21' && $hora_f == '22') {
			$horario_id = '14';
		}

		$cursos = Curso::where('nome', $request->curso_id)->get();
		foreach ($cursos as $curso) {
			$cursoId = $curso->id;
			$cursonome = $curso->nome;
			$cursocategoria = $curso->categoria;
		}

		$editais = Edital::where('nome', $request->edital_id)->get();
		foreach ($editais as $edital) {
			$editalId = $edital->id;
		}

		if ($request->teste_presencial_escola != null) {
			$escolas = Escola::where('nome', $request->teste_presencial_escola)->get();
			foreach ($escolas as $escola) {
				$escolaId = $escola->id;
			}
		} else {
			$escolaId = $request->teste_presencial_escola;
		}

		$turma = Turma::find($id);
		$turma->nome = "$editalId Edital - EFG/UDEPI - $cursonome - $cursocategoria - $request->modalidade - $dias_semana_id$turnonome";
		$turma->faixa_etaria = $request->faixa_etaria;
		$turma->turno = $request->turno;
		$turma->modalidade = $request->modalidade;
		$turma->vagas = $request->vagas;
		$turma->data_inicio = $request->data_inicio;
		$turma->dias_semana = implode(', ', $request->dias_semana);
		$turma->edital_id = $editalId;
		$turma->curso_id = $cursoId;
		$turma->hora_inicio = $request->hora_inicio;
		$turma->hora_termino = $request->hora_termino;

		$turma->habilitacao = $request->habilitacao;

		$turma->teste_aptidao = $request->accept;
		$turma->teste_aptidao_local_online = $request->local_teste_online;
		$turma->teste_aptidao_local_presencial = $request->local_teste_presencial;
		$turma->teste_aptidao_data_online = $request->data_limite_teste_online;
		$turma->teste_aptidao_data_presencial = $request->data_limite_teste_presencial;
		$turma->teste_aptidao_hora_presencial = $request->hora_limite_teste_presencial;
		$turma->teste_aptidao_sala_presencial = $request->sala_teste_presencial;
		$turma->teste_aptidao_idade = $request->accept_idade;
		$turma->teste_aptidao_idade_minima = $request->idade_minima;
		$turma->teste_aptidao_escola_presencial = $escolaId;

		$turma->updated_by = auth()->user()->id;

		$turma->save();
		$turma->tipo_arquivos()->delete();
		$turma->tipo_arquivos_habilitacao()->delete();

		foreach ($request->input('testes_exigidos') as $documentos_inscricao) {
			TurmaDocumento::insert([
				'tipo' => 1,
				'turma_id' => $turma->id,
				'tipo_arquivo_id' => $documentos_inscricao['value']
			]);
		}

		foreach ($request->input('habilitacoes_exigidas') as $habilitacao_exigida) {
			TurmaHabilitacao::insert([
				'turma_id' => $turma->id,
				'habilitacao_id' => $habilitacao_exigida['value']
			]);
		}

		return redirect()->route('painel.turmas')->with('response', $turma);
	}

	public function destroy($id)
	{
		$turma = is_array($id) ? Turma::destroy($id) : Turma::findOrFail($id)->delete();
		return redirect()->route('painel.turmas')->with('response', $turma);
	}

	public function destroyAll(Request $request)
	{
		$turmas = $request['deleteRows'];
		foreach ($turmas as $turma) {
			$turma = Turma::find($turma['id']);
			$turma->situacao = 'Inativo';
			$turma->delete();
		}

		return redirect()->route('painel.turmas')->with('response', $turmas);
	}

	public function reuse(Request $request)
	{
		if ($request->turno === 'Manha') {
			$turnonome = 'M';
		} elseif ($request->turno === 'Tarde') {
			$turnonome = 'T';
		} else {
			$turnonome = 'N';
		}

		if ($request->dias_semana === 'Domingo') {
			$dias_semana_id = '1';
		} elseif ($request->dias_semana === 'Segunda') {
			$dias_semana_id = '2';
		} elseif ($request->dias_semana === 'Terça') {
			$dias_semana_id = '3';
		} elseif ($request->dias_semana === 'Quarta') {
			$dias_semana_id = '4';
		} elseif ($request->dias_semana === 'Quinta') {
			$dias_semana_id = '5';
		} elseif ($request->dias_semana === 'Sexta') {
			$dias_semana_id = '6';
		} else {
			$dias_semana_id = '7';
		}

		$horario_inicial = $request->hora_inicio;
		$partes = explode(":", $horario_inicial);
		$hora_i = $partes[0];

		$horario_final = $request->hora_termino;
		$partes = explode(":", $horario_final);
		$hora_f = $partes[0];

		if ($hora_i >= 7 && $hora_f < 12) {
			$turno_t = 'M';
		} elseif ($hora_i >= 12 && $hora_f < 17) {
			$turno_t = 'T';
		} elseif ($hora_i >= 17 && $hora_f < 22) {
			$turno_t = 'N';
		} else {
			$turno_t = 'Outro';
		}

		if ($turno_t === 'M' && $hora_i == '07' && $hora_f == '08') {
			$horario_id = '1';
		} elseif ($turno_t === 'M' && $hora_i == '08' && $hora_f == '09') {
			$horario_id = '2';
		} elseif ($turno_t === 'M' && $hora_i == '09' && $hora_f == '10') {
			$horario_id = '3';
		} elseif ($turno_t === 'M' && $hora_i == '10' && $hora_f == '11') {
			$horario_id = '4';
		} elseif ($turno_t === 'M' && $hora_i == '11' && $hora_f == '12') {
			$horario_id = '5';
		}

		if ($turno_t === 'T' && $hora_i == '12' && $hora_f == '13') {
			$horario_id = '1';
		} elseif ($turno_t === 'T' && $hora_i == '13' && $hora_f == '14') {
			$horario_id = '2';
		} elseif ($turno_t === 'T' && $hora_i == '14' && $hora_f == '15') {
			$horario_id = '3';
		} elseif ($turno_t === 'T' && $hora_i == '15' && $hora_f == '16') {
			$horario_id = '4';
		} elseif ($turno_t === 'T' && $hora_i == '16' && $hora_f == '17') {
			$horario_id = '5';
		}

		if ($turno_t === 'N' && $hora_i == '17' && $hora_f == '18') {
			$horario_id = '1';
		} elseif ($turno_t === 'N' && $hora_i == '18' && $hora_f == '19') {
			$horario_id = '2';
		} elseif ($turno_t === 'N' && $hora_i == '19' && $hora_f == '20') {
			$horario_id = '3';
		} elseif ($turno_t === 'N' && $hora_i == '20' && $hora_f == '21') {
			$horario_id = '4';
		} elseif ($turno_t === 'N' && $hora_i == '21' && $hora_f == '22') {
			$horario_id = '5';
		}

		$cursos = Curso::where('id', $request->curso_id)->get();
		foreach ($cursos as $curso) {
			$cursoId = $curso->id;
			$cursonome = $curso->nome;
			$cursocategoria = $curso->categoria;
		}

		$editais = Edital::where('id', $request->edital_id)->get();
		foreach ($editais as $edital) {
			$editalId = $edital->id;
		}

		$turma = Turma::create([
			'nome' => "$editalId Edital - EFG/UDEPI - $cursonome - $cursocategoria - $request->modalidade - $dias_semana_id$turnonome",
			'situacao' => 'Ativo',
			'dias_semana' => $request->dias_semana,
			'faixa_etaria' => $request->faixa_etaria,
			'modalidade' => $request->modalidade,
			'edital_id' => $editalId,
			'curso_id' => $cursoId,
			'vagas' => $request->vagas,
			'turno' => $request->turno,
			'hora_inicio' => $request->hora_inicio,
			'hora_termino' => $request->hora_termino,
			'data_inicio' => $request->data_inicio,
			'created_by' => auth()->user()->id,
		]);

		$turma->save();

		return redirect()->route('painel.editais.editar', ['id' => $turma->edital_id])->with('response', $turma->edital_id);
	}

	public function Importar(Request $request)
	{
		$arquivo = $request->file('arquivo');
		$linhas = array_map('str_getcsv', file($arquivo->path()));
		$cabecalho = array_shift($linhas);
		$contadorImportacoes = 0;
		foreach ($linhas as $linha) {
			try {
				$dados = array_combine($cabecalho, $linha);
				$habilitacao = $dados['habilitacao'] === 'Nao' ? 0 : 1;
				$aptidao = $dados['teste_aptidao'] === 'Nao' ? 0 : 1;
				$online = $dados['teste_aptidao_local_online'] === 'Nao' ? 0 : 1;
				$presencial = $dados['teste_aptidao_local_presencial'] === 'Nao' ? 0 : 1;
				$limiteIdade = $dados['teste_aptidao_idade'] === 'Nao' ? 0 : 1;
				$escolaPresencial = $dados['teste_aptidao_escola_presencial'] === 'Nao' ? 0 : 1;

				$turma = Turma::create([
					'nome' => $dados['nome'],
					'situacao' => $dados['situacao'] ?: null,
					'turno' => $dados['turno'] ?: null,
					'modalidade' => $dados['modalidade'] ?: null,
					'faixa_etaria' => $dados['faixa_etaria'] ?: null,
					'vagas' => $dados['vagas'] ?: null,
					'dias_semana' => $dados['dias_semana'] ?: null,
					'data_inicio' => $dados['data_inicio'] ?: null,
					'hora_inicio' => $dados['hora_inicio'] ?: null,
					'hora_termino' => $dados['hora_termino'] ?: null,
					'habilitacao' => $habilitacao ?: null,
					'teste_aptidao' => $aptidao ?: null,
					'teste_aptidao_local_online' => $online ?: null,
					'teste_aptidao_local_presencial' => $presencial ?: null,
					'teste_aptidao_exigidos' => $dados['teste_aptidao_exigidos'] ?: null,
					'teste_aptidao_data_online' => $dados['teste_aptidao_data_online'] ?: null,
					'teste_aptidao_data_presencial' => $dados['teste_aptidao_data_presencial'] ?: null,
					'teste_aptidao_hora_presencial' => $dados['teste_aptidao_hora_presencial'] ?: null,
					'teste_aptidao_sala_presencial' => $dados['teste_aptidao_sala_presencial'] ?: null,
					'teste_aptidao_idade' => $limiteIdade ?: null,
					'teste_aptidao_idade_minima' => $dados['teste_aptidao_idade_minima'] ?: null,
					'edital_id' => $dados['edital_id'],
					'curso_id' => $dados['curso_id'],
					'teste_aptidao_escola_presencial' => $escolaPresencial ?: null,
				]);

				$turma->tipo_arquivos()->delete();
				$turma->tipo_arquivos_habilitacao()->delete();

				if ($dados['teste_aptidao_exigidos']) {
					$nomesTesteAptidao = explode(',', $dados['teste_aptidao_exigidos']);
					foreach ($nomesTesteAptidao as $nomeAptidao) {
						$testeAptidao = TipoArquivo::where('nome', $nomeAptidao)->first();
						if ($testeAptidao) {
							$idAptidao = $testeAptidao->id;
							if ($request->input('habilitacoes_exigidas')) {
								foreach ($request->input('habilitacoes_exigidas') as $habilitacao_exigida) {
									TurmaHabilitacao::insert([
										'turma_id' => $turma->id,
										'habilitacao_id' => $idAptidao
									]);
								}
							}
						}
					}
				}

				if ($dados['habilitacoes_exigidas']) {
					$nomesHabilitacoes = explode(',', $dados['habilitacoes_exigidas']);
					foreach ($nomesHabilitacoes as $nomeHabilitacao) {
						$testeHabilitacao = Habilitacao::where('nome', $nomeHabilitacao)->first();
						if ($testeHabilitacao) {
							$idHabilitacao = $testeHabilitacao->id;
							if ($request->input('testes_exigidos')) {
								foreach ($request->input('testes_exigidos') as $documentos_inscricao) {
									TurmaDocumento::insert([
										'tipo' => 1,
										'turma_id' => $turma->id,
										'tipo_arquivo_id' => $idHabilitacao
									]);
								}
							}
						}
					}
				}
				$contadorImportacoes++;
			} catch (\Exception $e) {
				dd('Erro ao salvar turma:', $e->getMessage(), $e->getTrace());
			}
		}
		return response()->json(['turmas_importadas' => $contadorImportacoes]);
	}

	public function log(Request $request, $id)
	{
		$edital = Edital::all();
		$curso = Curso::all();
		$inscricoes = Inscricao::all();
		$turma = Turma::with('inscricoes', 'curso', 'edital', 'criadoPor', 'modificadoPor')->findOrFail($id);
		$logs = Activity::where('subject_type', Turma::class)
			->where('subject_id', $turma->id)
			->with('causer')
			->get();

		return Inertia::render('Painel/Turmas/Log', [
			'turma' => $turma,
			'curso' => $curso,
			'inscricoes' => $inscricoes,
			'logs' => $logs,
			'edital' => $edital
		]);
	}
}
