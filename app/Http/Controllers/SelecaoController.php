<?php /** @noinspection ALL */

namespace App\Http\Controllers;

use App\Models\Comprovante;
use App\Models\ComprovanteAptidaoMatricula;
use App\Models\Comprovantematricula;
use App\Models\Curso;
use App\Models\Documento;
use App\Models\Edital;
use App\Models\EditalDocumento;
use App\Models\Escola;
use App\Models\Inscricao;
use App\Models\Municipio;
use App\Models\Tag;
use App\Models\TipoArquivo;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SelecaoController extends Controller
{
	public function index()
	{
		$turmas = Turma::with(['curso', 'tipo_arquivos_habilitacao', 'edital' => function ($q) {
			$q->with('escola', 'municipio');
		}, 'edital.tipo_arquivos'])->get();
		$escolas = Escola::with(['municipio', 'turmas'])->get();
		$editais = Edital::where('situacao', 'Ativo')->get();
		$cursos = Curso::all();
		$tags = Tag::all();
		$modalidade_turma = Turma::whereHas('edital', function ($query) use ($editais) {
			$query->whereIn('id', $editais->pluck('id'));
		})->get();
		$documentos = Documento::all();
		return Inertia::render('Selecao/Index', ['tags' => $tags, 'cursos' => $cursos, 'editais' => $editais, 'escolas' => $escolas, 'turmas' => $turmas, 'documentos' => $documentos, 'modalidade_turma' => $modalidade_turma]);
	}

	public function basileu(Request $request, $inscricao_id)
	{
		$inscricao = Inscricao::with(['turma', 'comprovantes_aptidao', 'turma.curso', 'turma.edital.escola.municipio', 'turma.tipo_arquivos.tipo_arquivo', 'turma.escola.municipio', 'turma.edital.tipo_arquivos.tipo_arquivo', 'criadoPor', 'modificadoPor'])->find($inscricao_id);
		$documentos = EditalDocumento::where('edital_id', $inscricao->turma->edital->id)->get();

		$nomeDocumentos = [];

		foreach ($documentos as $documento) {
			$idTipoArquivo = $documento->tipo_arquivo_id;
			$nomeDocumento = TipoArquivo::where('id', $idTipoArquivo)->first();

			if ($nomeDocumento) {
				$nomeDocumentos[] = $nomeDocumento->nome;
			}
		}

		return Inertia::render('Selecao/Index_Basileu', [
			'inscricao' => $inscricao,
			'documentos' => $documentos,
			'nomeDocumentos' => $nomeDocumentos,
		]);
	}

	public function aptidao_request(Request $request)
	{
		$inscricao_id = $request->input('inscricaoSelected');
		$inscricao = Inscricao::with(['turma', 'comprovantes_aptidao.tipoArquivo', 'turma.curso', 'turma.edital.escola.municipio', 'turma.tipo_arquivos.tipo_arquivo', 'turma.escola.municipio', 'turma.edital.tipo_arquivos.tipo_arquivo', 'criadoPor', 'modificadoPor'])->find($inscricao_id);


		return response()->json([
			'comprovante' => $inscricao,
		]);
	}

	public function estagio_1(Request $request)
	{
		$local = $request->input('localSelected');

		if ($local === 'Online') {
			$cursos = Turma::with(['edital.escola', 'tipo_arquivos_habilitacao.habilitacao', 'curso'])->where('modalidade', $local)->get();
		} else {
			$cursos = Turma::whereHas('edital.escola', function ($q) use ($local) {
				$q->where('id', $local);
			})
				->with(['edital.municipio', 'tipo_arquivos_habilitacao.habilitacao', 'curso', 'edital.escola'])
				->get();
		}

		$cursosAgrupados = $cursos->groupBy('curso.nome');
		$response = $cursosAgrupados->map(function ($cursosDoMesmoNome, $nomeCurso) {
			$todasTurmas = $cursosDoMesmoNome->map(function ($turma) {
				return [
					'turma_teste' => $turma
				];
			});

			return [
				'nome_curso' => $nomeCurso,
				'turmas' => $todasTurmas,
			];
		});
		return response()->json(['curso' => $response]);
	}

	public function estagio_2(Request $request)
	{
		$tag = $request->input('tagsSelected');
		$tags = is_array($tag) ? $tag : explode(',', $tag);

		$todosCursos = Curso::whereIn('tag', $tags)->get(['id'])->pluck('id');

		$todasTurmas = Turma::whereIn('curso_id', $todosCursos)->get();

		$todosEditais = Edital::whereIn('id', $todasTurmas->pluck('edital_id'))->get();

		$todasEscolas = Escola::whereIn('id', $todosEditais->pluck('escola_id'))->with('municipio', 'turmas')->get();

		$todosMunicipios = Municipio::whereIn('id', $todasEscolas->pluck('municipio_id'))->get();

		$turmas = Turma::with(['curso', 'edital' => function ($q) {
			$q->with('escola', 'municipio');
		}, 'edital.documentos', 'edital.documentosExigidos'])->get();

		return response()->json([
			'turmas' => $turmas,
			'todosCursos' => $todosCursos,
			'todasTurmas' => $todasTurmas,
			'todosEditais' => $todosEditais,
			'todasEscolas' => $todasEscolas,
			'todosMunicipios' => $todosMunicipios,
		]);
	}

	public function matricula()
	{
		$inscricoes = Inscricao::with('turma.curso', 'turma.edital.tipo_arquivos.tipo_arquivo', 'turma.edital.escola', 'criadoPor', 'modificadoPor')->get();
		$comprovantes = Comprovante::all();
		$curso = Curso::all();
		$turmas = Turma::all();
		$escolas = Escola::all();
		$editais = Edital::all();
		$tipoDocumentoInscricaoIds = $inscricoes->pluck('id')->toArray();
		$comprovantes = Comprovante::where('inscricao_id', $tipoDocumentoInscricaoIds)->get();

		$turmasId = $inscricoes->pluck('turma_id')->toArray();
		$turmas = Turma::with('curso')->whereIn('id', $turmasId)->get();

		$editaisId = $turmas->pluck('edital_id')->toArray();
		$editais = Edital::whereIn('id', $editaisId)->get();

		$escolasId = $editais->pluck('escola_id')->toArray();
		$escolas = Escola::whereIn('id', $escolasId)->get();

		$cursoId = $turmas->pluck('curso_id')->toArray();
		$curso = Curso::whereIn('id', $cursoId)->get();

		$documentos = Documento::all();
		return Inertia::render('Selecao/Matricula', ['curso' => $curso, 'comprovantes' => $comprovantes, 'inscricoes' => $inscricoes, 'escolas' => $escolas, 'turmas' => $turmas, 'documentos' => $documentos, 'editais' => $editais]);
	}

	public function matricula_estagio_1(Request $request)
	{
		$local = $request->input('localSelected');
		$comprovante = Comprovantematricula::with('tipoArquivo')->where('inscricao_id', $request->input('inscricaoSelected'))->get();
		$inscricao = Inscricao::with('turma.curso', 'turma.edital.tipo_arquivos.tipo_arquivo', 'turma.edital.escola.municipio', 'criadoPor', 'modificadoPor')->where('documento', $request->input('verificacao_documento'))
			->where('tipo_documento', $request->input('verificacao_tipo_documento'))
			->where('data_nascimento', $request->input('verificacao_nascimento'))
			->get();

		return response()->json(['inscricao' => $inscricao, 'comprovante' => $comprovante]);
	}

	public function matricula_estagio_2(Request $request)
	{
		$local = $request->input('localSelected');

		$comprovante = Comprovantematricula::with('tipoArquivo')
			->where('inscricao_id', $request->input('inscricaoSelected'))
			->whereNull('deleted_at')
			->get();

		if ($comprovante->isNotEmpty()) {

			foreach ($comprovante as $comprovantes) {
				$comprovanteArquivoId = $comprovantes->tipo_arquivo_id;
			}
			$nomeArquivo = TipoArquivo::where('id', $comprovanteArquivoId)->get();

			$inscricao = Inscricao::with('turma.curso', 'turma.edital.tipo_arquivos.tipo_arquivo', 'turma.edital.escola.municipio', 'comprovantes', 'criadoPor', 'modificadoPor')->where('id', $request->input('inscricaoSelected'))->get();

			return response()->json(['inscricao' => $inscricao, 'comprovante' => $comprovante, 'nomeArquivo' => $nomeArquivo]);
		} else {
			$inscricao = Inscricao::with('turma.curso', 'turma.edital.tipo_arquivos.tipo_arquivo', 'turma.edital.escola.municipio', 'comprovantes', 'criadoPor', 'modificadoPor')->where('id', $request->input('inscricaoSelected'))->get();
			return response()->json(['inscricao' => $inscricao, 'comprovante' => $comprovante]);
		}
	}

	public function store(Request $request)
	{

		$request->validate([
			'nome_completo' => 'required',
			'email' => 'required',
			'data_nascimento' => 'required',
			'nome_mae' => 'required',
			'telefone' => 'required',
			'telefone_alternativo' => 'nullable',
			'email_confirmation' => 'required',
			'cep' => 'required',
			'estado' => 'required',
			'municipio' => 'required',
			'bairro' => 'required',
			'logradouro' => 'required',
			'numero' => 'required',
			'complemento' => 'required',
			'turma_id' => 'required',
			'tipo_documento' => 'required',
			'documento' => 'required',
			'lgpd' => 'required',
		], [
			'required' => 'O campo é obrigatório',
		]);

		// $user = User::firstOrNew(['email' => $request->email]);

		// if (!$user->exists) {
		//     $user->name = $request->nome_completo;
		//     $user->cpf = $request->cpf;
		//     $user->telefone = $request->telefone;
		//     $user->situacao = 'Ativo';
		//     $user->role = 'Aluno';

		//     $user->save();
		// }

		$inscricao = Inscricao::create([
			'nome_completo' => $request->nome_completo,
			'cpf' => $request->cpf,
			'tipo' => $request->tipo,
			'rede' => $request->rede,
			'data_nascimento' => $request->data_nascimento,
			'nome_mae' => $request->nome_mae,
			'telefone' => $request->telefone,
			'telefone_alternativo' => $request->telefone_alternativo,
			'email' => $request->email,
			'email_confirmation' => $request->email_confirmation,
			'cep' => $request->cep,
			'estado' => $request->estado,
			'municipio' => $request->municipio,
			'bairro' => $request->bairro,
			'logradouro' => $request->logradouro,
			'numero' => $request->numero,
			'complemento' => $request->complemento,
			'escolaridade' => $request->escolaridade,
			'origem_escolar' => $request->origem_escolar,
			'genero' => $request->genero,
			'outro_genero' => $request->outro_genero,
			'raca' => $request->raca,
			'outro_raca' => $request->outro_raca,
			'programa_social' => $request->programa_social,
			'outro_programa_social' => $request->outro_programa_social,
			'nis_pis' => $request->nis_pis,
			'deficiencia' => $request->deficiencia,
			'outra_deficiencia' => $request->outra_deficiencia,
			'como_conheceu' => $request->como_conheceu,
			'outro_como_conheceu' => $request->outro_como_conheceu,
			'turma_id' => $request->turma_id,
			'situacao' => 'Em Análise',
			'lgpd' => $request->lgpd,
			'documento' => $request->documento,
			'tipo_documento' => $request->tipo_documento,
			'habilitacao_id' => $request->habilitacao_item,
		]);
		$inscricao->save();

		$turma = Turma::find($request->turma_id);
		$edital = Edital::find($turma->edital_id);

		$inscricao_id = $inscricao->id;
		if (!empty($request->email)) {
			try {
				$confirmationLink = route('inscricao.confirmacao.id', ['inscricao_id' => $inscricao_id]);
				Mail::mailer('smtp')->send([], [], function (Message $message) use ($confirmationLink, $request) {
					$message->to($request->email)
						->subject('Confirmação de Inscrição')
						->html(
							`Sua inscrição foi recebida com sucesso. Por favor, clique no link abaixo para confirmar: <a href='{$confirmationLink}'>Confirmar Inscrição</a>
                        <div class="tw-flex tw-flex-col tw-w-[40vw] tw-bg-white tw-gap-6 tw-text-center tw-items-center">
                            <img src="../../../imgs/logo-efg.svg" class="tw-h-[60px] tw-w-auto tw-mb-5" />
                            <h5 class="tw-font-bold tw-font-title tw-text-grass-700 tw-text-3xl tw-leading-7">
                                Inscrição realizada com sucesso!
                            </h5>
                            <img src="../../../imgs/insc-email.png" class="tw-h-[600px] tw-w-auto tw-mb-5" />
                            <h5 class="tw-font-bold tw-font-title tw-text-grass-700 tw-text-3xl tw-leading-7 tw-mb-4">
                                Olá, {{ nome }}! Seu primeiro passo rumo ao futuro foi dado.
                            </h5>
                            <h5 class="tw-font-bold tw-font-title tw-text-grass-700 tw-text-1xl tw-leading-7">
                                Nº da Inscrição: {{ inscricao_id }}
                            </h5>
                            <div class="tw-border-4 tw-border-green-500 tw-w-[30vw] tw-text-left tw-p-8">
                                <h2 class="tw-font-title tw-text-grass-700 tw-text-xl tw-leading-6 tw-mb-4">
                                Curso
                                </h2>
                                <h2 class="tw-font-title tw-font-bold tw-text-gray-700 tw-text-xl tw-leading-7 tw-mb-4">
                                {{ curso }}
                                </h2>
                                <h2 class="tw-font-title tw-text-grass-700 tw-text-xl tw-leading-7 tw-mb-4">
                                Unidade
                                </h2>
                                <h2 class="tw-font-title tw-font-bold tw-text-gray-700 tw-text-xl tw-leading-7 tw-mb-4">
                                {{ unidade }}
                                </h2>
                                <h2 class="tw-font-title tw-text-grass-700 tw-text-xl tw-leading-7 tw-mb-4">
                                CPF
                                </h2>
                                <h2 class="tw-font-title tw-font-bold tw-text-gray-700 tw-text-xl tw-leading-7 tw-mb-4">
                                {{ cpf }}
                                </h2>
                                <h2 class="tw-font-title tw-text-grass-700 tw-text-xl tw-leading-7 tw-mb-4">
                                E-mail
                                </h2>
                                <h2 class="tw-font-title tw-font-bold tw-text-gray-700 tw-text-xl tw-leading-7 tw-mb-4">
                                {{ email }}
                                </h2>
                            </div>
                            <h5 class="tw-font-bold tw-font-title tw-text-grey-700 tw-text-1xl tw-leading-7">
                                Sua inscrição foi enviada com sucesso em {{ created_at }}
                            </h5>
                            <h5 class="tw-font-bold tw-font-title tw-text-grass-700 tw-text-1xl tw-leading-7">
                                Em breve você receberá informações sobre como realizar sua matrícula. Fique de olho no seu e-mail!
                            </h5>
                            
                            </div>
                            <div class="!tw-bg-green-50 tw-h-auto tw-flex tw-flex-col tw-items-center tw-justify-center">
                            <div class="tw-grid tw-grid-cols-4 tw-gap-9 tw-w-[300px] tw-items-center tw-p-9">
                                <a target="_blank" href="https://www.instagram.com/escolasdofuturodegoias/?igshid=MTk0NTkyODZkYg%3D%3D"><Icon icon="teenyicons:instagram-outline" width="40" height="40" /></a>
                                <Icon icon="teenyicons:tiktok-outline" width="40" height="40" /></a>
                                <a target="_blank" href="https://m.facebook.com/escoladofuturodegoias?wtsid=rdr_0kpM5kA6pdjlra4cP"><Icon icon="teenyicons:facebook-outline" width="40" height="40" /></a>
                                <a target="_blank" href="https://youtube.com/@escoladofuturodoestadodego4768?si=4eRrLqGPyLK0JW8K"><Icon icon="teenyicons:youtube-outline" width="40" height="40" /></a>
                            </div>
                            <a class="tw-text-base" target="_blank" href="https://efg.org.br/">https://efg.org.br</a>
                            <div class="tw-grid tw-grid-cols-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="73" height="74" viewBox="0 0 48 49" fill="none">
                                <path id="Vector" d="M24 0.627258C10.7675 0.627258 0 11.3948 0 24.6273C0 37.8598 10.7675 48.6273 24 48.6273C37.2325 48.6273 48 37.8598 48 24.6273C48 11.3948 37.2325 0.627258 24 0.627258ZM26.3715 46.1201V25.8715H33.0134C33.5092 27.1203 34.7301 28.0091 36.1567 28.0091C38.023 28.0091 39.5385 26.4889 39.5385 24.6273C39.5385 22.7656 38.0183 21.2455 36.1567 21.2455C34.6833 21.2455 33.4344 22.1903 32.9667 23.5047H26.3715V16.2032L28.5512 14.4585H32.9854C33.4672 15.7401 34.702 16.6569 36.152 16.6569C38.0183 16.6569 39.5338 15.1367 39.5338 13.2751C39.5338 11.4135 38.0136 9.89329 36.152 9.89329C34.702 9.89329 33.4672 10.8101 32.9854 12.0917H28.1349L27.3958 12.3536L24.4444 14.7157L24 15.6419V23.5093H9.77119V16.2078L11.9509 14.4632H16.2729C16.7546 15.7448 17.9895 16.6616 19.4395 16.6616C21.3058 16.6616 22.8213 15.1414 22.8213 13.2798C22.8213 11.4181 21.3011 9.89797 19.4395 9.89797C17.9895 9.89797 16.7546 10.8147 16.2729 12.0964H11.5346L10.7955 12.3583L7.84408 14.7204L7.39973 15.6466V34.4733L7.84408 35.3994L10.7955 37.7615L11.5346 38.0235H16.2729C16.7546 39.3051 17.9895 40.2219 19.4395 40.2219C21.3058 40.2219 22.8213 38.7017 22.8213 36.8401C22.8213 34.9785 21.3011 33.4583 19.4395 33.4583C17.9895 33.4583 16.7546 34.3751 16.2729 35.6567H11.9509L9.77119 33.912V25.8948H24V46.2745C12.0772 46.2745 2.37614 36.5735 2.37614 24.6506C2.37614 12.7278 12.0772 3.02679 24 3.02679C35.9228 3.02679 45.6239 12.7278 45.6239 24.6506C45.6239 35.7736 37.181 44.9601 26.3668 46.1435L26.3715 46.1201ZM35.1417 24.6273C35.1417 24.0706 35.5954 23.6169 36.152 23.6169C36.7086 23.6169 37.1623 24.0706 37.1623 24.6273C37.1623 25.1839 36.7086 25.6376 36.152 25.6376C35.5954 25.6376 35.1417 25.1839 35.1417 24.6273ZM35.1417 13.2704C35.1417 12.7138 35.5954 12.2601 36.152 12.2601C36.7086 12.2601 37.1623 12.7138 37.1623 13.2704C37.1623 13.827 36.7086 14.2807 36.152 14.2807C35.5954 14.2807 35.1417 13.827 35.1417 13.2704ZM18.4292 13.2704C18.4292 12.7138 18.8829 12.2601 19.4395 12.2601C19.9961 12.2601 20.4498 12.7138 20.4498 13.2704C20.4498 13.827 19.9961 14.2807 19.4395 14.2807C18.8829 14.2807 18.4292 13.827 18.4292 13.2704ZM18.4292 36.8214C18.4292 36.2648 18.8829 35.811 19.4395 35.811C19.9961 35.811 20.4498 36.2648 20.4498 36.8214C20.4498 37.378 19.9961 37.8317 19.4395 37.8317C18.8829 37.8317 18.4292 37.378 18.4292 36.8214Z" fill="url(#paint0_linear_535_132)"/>
                                <defs>
                                <linearGradient id="paint0_linear_535_132" x1="24" y1="48.6226" x2="24" y2="0.627258" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#0086A8"/>
                                <stop offset="1" stop-color="#27B577"/>
                                </linearGradient>
                                </defs>
                                </svg>
                            </div>
                        </div>`
						);
				});
			} catch (\Exception $e) {
				// dd('Deu erro, o motivo? Não sei', $e);
			}
		}
		return redirect()->back()->with('response', $inscricao);
	}

	public function aptidao_store(Request $request)
	{
		if ($request->input('link') !== null) {
			$request->validate([
				'link' => 'required',
			], [
				'required' => 'O campo é obrigatório',
			]);

			$arquivoExistente = ComprovanteAptidaoMatricula::where('tipo_arquivo_id', $request->documentoMatriculaId)
				->where('inscricao_id', $request->idDoc)
				->first();

			if ($arquivoExistente) {
				$arquivoExistente->delete();
			}

			$comprovante = ComprovanteAptidaoMatricula::create([
				'situacao' => 'Analise',
				'inscricao_id' => $request->idDoc,
				'tipo_arquivo_id' => $request->documentoMatriculaId,
				'status' => 'Nao',
				'nome_arquivo' => 'Link',
				'link' => $request->link
			]);
		} else {
			if ($request->has('arquivos')) {
				$matricula = Inscricao::with('turma', 'turma.edital.tipo_arquivos.tipo_arquivo')->find($request->idDoc);

				$pastaMatricula = 'aptidao/' . $request->idDoc;
				Storage::makeDirectory($pastaMatricula);

				$file = $request->files->get('arquivos');

				if (is_array($request->file('arquivos'))) {
					$arquivo = $request->files->get('arquivos')[0];
				} else {
					$arquivo = $request->file('arquivos');
				}

				$tipoArquivoId = $request->documentoMatriculaId;

				$arquivoExistente = ComprovanteAptidaoMatricula::where('tipo_arquivo_id', $tipoArquivoId)
					->where('inscricao_id', $request->idDoc)
					->first();

				if ($arquivoExistente) {
					Storage::delete($arquivoExistente->caminho);
					$arquivoExistente->delete();
				}

				// Cria o registro no banco de dados
				$comprovante = ComprovanteAptidaoMatricula::create([
					'situacao' => 'Analise',
					'inscricao_id' => $request->idDoc,
					'tipo_arquivo_id' => $tipoArquivoId,
					'status' => 'Nao',
					'nome_arquivo' => $arquivo->getClientOriginalName(),
					'link' => $request->link
				]);

				// Gera o nome do arquivo único
				$extensao = $arquivo->getClientOriginalExtension();
				$nomeAleatorio = uniqid('', true) . '.' . $extensao;
				$fileName = $comprovante->id . '_' . $nomeAleatorio;

				$pathPdf = Storage::putFileAs($pastaMatricula, $arquivo, $fileName);

				// Atualiza o caminho no registro do banco de dados
				$comprovante->caminho = $pastaMatricula . '/' . $fileName;
				$comprovante->save();
			}
		}
	}

	public function matricula_store(Request $request)
	{
		if ($request->has('arquivos')) {
			$matricula = Inscricao::with('turma', 'turma.edital.tipo_arquivos.tipo_arquivo')->find($request->idDoc);

			$pastaMatricula = 'matriculas/' . $request->idDoc;
			Storage::makeDirectory($pastaMatricula);

			$file = $request->files->get('arquivos');


			if (is_array($request->file('arquivos'))) {
				$arquivo = $request->files->get('arquivos')[0];
			} else {
				$arquivo = $request->file('arquivos');
			}

			$tipoArquivoId = $request->documentoMatriculaId;

			$arquivoExistente = Comprovantematricula::where('tipo_arquivo_id', $tipoArquivoId)
				->where('inscricao_id', $request->idDoc)
				->where('tipo', $request->tipo)
				->first();

			if ($arquivoExistente) {
				Storage::delete($arquivoExistente->caminho);
				$arquivoExistente->delete();
			}

			// Cria o registro no banco de dados
			$comprovante = Comprovantematricula::create([
				'situacao' => 'Analise',
				'inscricao_id' => $request->idDoc,
				'tipo_arquivo_id' => $tipoArquivoId,
				'status' => 'Nao',
				'tipo' => $request->tipo,
				'nome_arquivo' => $arquivo->getClientOriginalName()
			]);

			// Gera o nome do arquivo único
			$extensao = $arquivo->getClientOriginalExtension();
			$nomeAleatorio = uniqid('', true) . '.' . $extensao;
			$fileName = $comprovante->id . '_' . $nomeAleatorio;

			$pathPdf = Storage::putFileAs($pastaMatricula, $arquivo, $fileName);

			// Atualiza o caminho no registro do banco de dados
			$comprovante->caminho = $pastaMatricula . '/' . $fileName;
			$comprovante->save();
		}
	}


	public function confirmacao($inscricao_id)
	{
		$inscricao = Inscricao::find($inscricao_id);
		$inscricao->email_verified = '1';
		$inscricao->save();
		return redirect()->route('inscricao.confirmacao')->with('response', $inscricao);
	}
}
