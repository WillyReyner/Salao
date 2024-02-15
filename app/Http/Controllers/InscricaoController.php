<?php

namespace App\Http\Controllers;

use App\Models\Comprovante;
use App\Models\Comprovantematricula;
use App\Models\Curso;
use App\Models\Edital;
use App\Models\Escola;
use App\Models\Inscricao;
use App\Models\TipoArquivo;
use App\Models\Turma;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class InscricaoController extends Controller
{
	public function index()
	{
		$edital = Edital::all();
		$curso = Curso::all();
		$escolas = Escola::with('responsaveis')->get();
		$inscricoes = Inscricao::with('turma.curso', 'turma.edital.escola.responsaveis', 'criadoPor', 'modificadoPor')
			->where(function ($query) use ($escolas) {
				foreach ($escolas as $escola) {
					foreach ($escola->responsaveis as $responsavel) {
						$query->orWhere('user_id', $responsavel->user_id);
					}
				}
			})
			->get();

		return Inertia::render('Painel/Inscricoes/Index', [
			'inscricoes' => $inscricoes,
			'edital' => $edital,
			'cursos' => $curso,
			'escolas' => $escolas
		]);
	}

	public function edit($id)
	{
		$inscricoes = Inscricao::with('turma', 'comprovantes')->find($id);
		$comprovantes = Comprovante::where('inscricao_id', $id)->get();
		$comprovantesMatricula = Comprovantematricula::where('inscricao_id', $id)->get();

		$tipoDocumentoInscricaoIds = $comprovantes->pluck('tipo_arquivo_id')->toArray();
		$documentacao_inscricao = TipoArquivo::whereIn('id', $tipoDocumentoInscricaoIds)->get();

		$tipoDocumentoMatriculaIds = $comprovantesMatricula->pluck('tipo_arquivo_id')->toArray();
		$documentacao_matricula = TipoArquivo::whereIn('id', $tipoDocumentoMatriculaIds)->get();

		$turmas = Turma::where('id', $inscricoes->turma_id)->get();
		return Inertia::render('Painel/Inscricoes/Editar', ['inscricoes' => $inscricoes, 'documentacao_matricula' => $documentacao_matricula, 'documentacao_inscricao' => $documentacao_inscricao, 'turmas' => $turmas, 'comprovantes' => $comprovantes, 'comprovantesMatricula' => $comprovantesMatricula]);
	}

	public function show($id)
	{
		$inscricoes = Inscricao::with('turma', 'comprovantes')->find($id);

		$turmas = Turma::where('id', $inscricoes->turma_id)->get();
		return Inertia::render('Painel/Inscricoes/Detalhes', ['inscricoes' => $inscricoes, 'turmas' => $turmas]);
	}

	public function store(Request $request)
	{
		$request->validate([
			"nome_completo" => "required",
			"documento" => "required",
			"tipo_documento" => "required",
			"data_nascimento" => "required",
			"nome_mae" => "required",
			"telefone" => "required",
			"telefone_alternativo" => "nullable",
			"email" => "required",
			"email_confirmation" => "required",
			"cep" => "required",
			"estado" => "required",
			"municipio" => "required",
			"bairro" => "required",
			"logradouro" => "required",
			"numero" => "required",
			"escolaridade" => "required",
			"origem_escolar" => "required",
			"raca" => "required",
			"sexo" => "required",
			"programa_social" => "nullable",
			"outro_programa_social" => "nullable",
			"nis_pis" => "nullable",
			"deficiencia" => "nullable",
			"outra_deficiencia" => "nullable",
			"como_conheceu" => "nullable",
			"outro_como_conheceu" => "nullable",
			"turma_id" => "required",
		], [
			'required' => 'O campo é obrigatório',
		]);

		$inscricao = Inscricao::create([
			'nome_completo' => $request->nome_completo,
			'documento' => $request->documento,
			'tipo_documento' => $request->tipo_documento,
			'email' => $request->email,
			'password' => $request->password,
			'cpf' => $request->cpf,
			'tipo' => $request->tipo,
			'rede' => $request->rede,
			'sexo' => $request->genero,
			'telefone' => $request->telefone,
			'data_nascimento' => $request->data_nascimento,
			'nome_mae' => $request->nome_mae,
			'programa_social' => $request->programa_social,
			'turno' => $request->turno,
			'modalidade' => $request->modalidade,
			'categoria_deficiencia' => $request->categoria_deficiencia,
			'outra_categoria_deficiencia' => $request->outra_categoria_deficiencia,
			'recursos_acessibilidade' => $request->recursos_acessibilidade,
			'como_conheceu' => $request->como_conheceu,
			'tipo_documento' => $request->tipo_documento,
			'escola_id' => $request->escola_id,
			'turma_id' => $request->turma_id,
			'colegio_id' => $request->colegio_id,
			'situacao' => $request->status,
		]);
		return redirect()->back()->with('response', $inscricao);
	}

	public function create()
	{
		$turmas = Turma::all();
		$users = User::all();
		return Inertia::render('Painel/Inscricoes/Novo', ['turmas' => $turmas, 'users' => $users]);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			"nome_completo" => "required",
			"cpf" => "required",
			"situacao" => "required",
			"data_nascimento" => "required",
			"email" => "required",
			"telefone" => "required",
			"telefone_alternativo" => "nullable",
		], [
			"required" => 'O campo é obrigatório',
		]);

		$inscricao = Inscricao::find($id);
		$inscricao->documento = $request->documento;
		$inscricao->tipo_documento = $request->tipo_documento;
		$inscricao->nome_completo = $request->nome_completo;
		$inscricao->cpf = $request->cpf;
		$inscricao->situacao = $request->situacao;
		$inscricao->data_nascimento = $request->data_nascimento;
		$inscricao->telefone = $request->telefone;
		$inscricao->telefone_alternativo = $request->telefone;
		$inscricao->email = $request->email;
		$inscricao->email_confirmation = $request->email;
		$inscricao->save();

		return redirect()->route('painel.inscricoes')->with('response', $inscricao);
	}

	public function destroy(Request $request)
	{

		$id = $request->id;
		$inscricao = is_array($id) ? Inscricao::destroy($id) : Inscricao::findOrFail($id)->delete();
		return redirect()->route('painel.inscricoes')->with('response', $inscricao);
	}

	public function validarDocInscricao(Request $request, $id)
	{
		$doc = Comprovante::find($id);
		$doc->status = 'Sim';
		$doc->save();
	}

	public function validarDocMatricula(Request $request, $id)
	{
		$doc = Comprovantematricula::find($id);
		$doc->status = 'Sim';
		$doc->save();
	}

	public function enviarEmail(Request $request, $ids)
	{
		$idsArray = explode(',', $ids);

		if (empty($idsArray)) {
			return redirect()->route('pagina_de_erro');
		}

		$inscricoes = Inscricao::whereIn('id', $idsArray)->get();

		$inscricoes->situacao = 'Aguardando Documentacao';
		if ($inscricoes->isEmpty()) {
			return redirect()->route('pagina_de_erro');
		}

		foreach ($inscricoes as $inscricao) {
			$recipientEmail = $inscricao->email;

			$inscricao->situacao = 'Aguardando Documentacao';
			$inscricao->save();

			if (!empty($recipientEmail)) {
				try {
					Mail::mailer('smtp')->send([], [], function (Message $message) use ($recipientEmail) {
						$message->to($recipientEmail)
							->subject('Confirmação de Inscrição')
							->html("Sua inscrição foi recebida com sucesso. Por favor, clique no link abaixo para confirmar: <a href='URL_DA_CONFIRMACAO'>Confirmar Inscrição</a>");
					});
				} catch (\Exception $e) {
					// Lidar com erros no envio de e-mail
					// Aqui você pode registrar detalhes do erro ou tomar medidas apropriadas
				}
			}
		}

		return redirect()->route('painel.inscricoes')->with('response', $inscricoes);
	}

//    public function log(Request $request, $id)
//    {
//        $inscricao = Inscricao::with('turma', 'comprovantes', 'criadoPor', 'modificadoPor')->findOrFail($id);
//        $logs = Activity::where('subject_type', Inscricao::class)
//            ->where('subject_id', $inscricao->id)
//            ->with('causer')
//            ->get();
//
//        return Inertia::render('Painel/Inscricoes/Log', [
//            'inscricao' => $inscricao,
//            'logs' => $logs,
//        ]);
//    }
}
