<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\EditalController;
use App\Http\Controllers\EscolaController;
use App\Http\Controllers\GestaoController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\HabilitacaoController;
use App\Http\Controllers\InscricaoController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SelecaoController;
use App\Http\Controllers\StaiAgendamentoController;
use App\Http\Controllers\StaiController;
use App\Http\Controllers\StaiEditaisController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TipoArquivoController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
	return Inertia::render('Welcome', [
		'canLogin' => Route::has('login'),
		'canRegister' => Route::has('register'),
		'canVerifyEmail' => Route::has('verifyemail'),
		'laravelVersion' => Application::VERSION,
		'phpVersion' => PHP_VERSION,
	]);
});

Route::group(['prefix' => 'portal'], function () {
	Route::get('/', [PortalController::class, 'index'])->name('portal.index');
});

Route::group(['prefix' => 'inscricao'], function () {
	Route::get('/', [SelecaoController::class, 'index'])->name('inscricao.index');
	Route::post('/', [SelecaoController::class, 'store'])->name('inscricao.store');
	Route::get('/estagio_1', [SelecaoController::class, 'estagio_1'])->name('inscricao.estagio_1');
	Route::post('/estagio_1', [SelecaoController::class, 'estagio_1'])->name('inscricao.get.estagio_1');
	Route::get('/estagio_2', [SelecaoController::class, 'estagio_2'])->name('inscricao.estagio_2');
	Route::post('/estagio_2', [SelecaoController::class, 'estagio_2'])->name('inscricao.get.estagio_2');


	Route::get('/matricula', [SelecaoController::class, 'matricula'])->name('inscricao.matricula');
	Route::post('matricula/buscar-inscricoes/{cpf}/{data_nascimento}', [SelecaoController::class, 'matricula'])->name('inscricao.buscar-inscricoes');
	Route::post('/matricula', [SelecaoController::class, 'matricula_store'])->name('inscricao.matricula.store');

	Route::post('/matricula/estagio_1', [SelecaoController::class, 'matricula_estagio_1'])->name('inscricao.matricula.estagio_1');
	Route::post('/matricula/estagio_2', [SelecaoController::class, 'matricula_estagio_2'])->name('inscricao.matricula.estagio_2');

	Route::get('/aptidao/{inscricao_id}', [SelecaoController::class, 'basileu'])->name('inscricao.basileu.index_basileu');
	Route::post('/aptidao', [SelecaoController::class, 'aptidao_store'])->name('inscricao.aptidao.store');
	Route::post('/aptidao/aptidao_request', [SelecaoController::class, 'aptidao_request'])->name('inscricao.aptidao.request');

	Route::get('/confirmacao', [SelecaoController::class, 'confirmacao'])->name('inscricao.confirmacao');
	Route::get('/confirmacao/{inscricao_id}', [SelecaoController::class, 'confirmacao'])->name('inscricao.confirmacao.id');
});

Route::group([
	'middleware' => ['auth', 'verified']
], function () {
	Route::get('/logs', [LogController::class, 'index'])->name('painel.logs');
	Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

	// Escolas
	Route::group(['prefix' => 'escolas'], function () {
		Route::get('/', [EscolaController::class, 'index'])->name('painel.escolas')->middleware('permission:Index Escolas');
		Route::get('/detalhes/{id}', [EscolaController::class, 'show'])->name('painel.escolas.show');
		Route::get('/novo', [EscolaController::class, 'create'])->name('painel.escolas.create');
		Route::post('/', [EscolaController::class, 'store'])->name('painel.escolas.store');
		Route::get('/editar/{id}', [EscolaController::class, 'edit'])->name('painel.escolas.editar');
		Route::patch('/{id}', [EscolaController::class, 'update'])->name('painel.escolas.update');
		Route::post('/deletar', [EscolaController::class, 'destroy'])->name('painel.escolas.destroy');
		Route::get('/log/{id}', [EscolaController::class, 'log'])->name('painel.escolas.log');
	});

	// Municipios
	Route::group(['prefix' => 'municipios'], function () {
		Route::get('/', [MunicipioController::class, 'index'])->name('painel.municipios')->middleware('permission:Index Municipios');
		Route::get('/detalhes/{id}', [MunicipioController::class, 'show'])->name('painel.municipios.show');
		Route::get('/novo', [MunicipioController::class, 'create'])->name('painel.municipios.create');
		Route::post('/', [MunicipioController::class, 'store'])->name('painel.municipios.store');
		Route::get('/editar/{id}', [MunicipioController::class, 'edit'])->name('painel.municipios.editar');
		Route::patch('/{id}', [MunicipioController::class, 'update'])->name('painel.municipios.update');
		Route::post('/deletar', [MunicipioController::class, 'destroy'])->name('painel.municipios.destroy');
		Route::get('/log/{id}', [MunicipioController::class, 'log'])->name('painel.municipios.log');
	});

	// Edital
	Route::group(['prefix' => 'editais'], function () {
		Route::get('/', [EditalController::class, 'index'])->name('painel.editais')->middleware('permission:Index Editais');
		Route::get('/detalhes/{id}', [EditalController::class, 'show'])->name('painel.editais.show');
		Route::get('/novo', [EditalController::class, 'create'])->name('painel.editais.create');
		Route::post('/', [EditalController::class, 'store'])->name('painel.editais.store');
		Route::get('/editar/{id}', [EditalController::class, 'edit'])->name('painel.editais.editar');
		Route::patch('/{id}', [EditalController::class, 'update'])->name('painel.editais.update');
		Route::post('/deletar', [EditalController::class, 'destroy'])->name('painel.editais.destroy');
		Route::get('/log/{id}', [EditalController::class, 'log'])->name('painel.editais.log');
		Route::post('/painel/editais/{id}', [EditalController::class, 'autoupdate'])->name('painel.editais.autoupdate');
	});

	// turmas
	Route::group(['prefix' => 'turmas'], function () {
		Route::get('/', [TurmaController::class, 'index'])->name('painel.turmas')->middleware('permission:Index Turmas');
		Route::get('/detalhes/{id}', [TurmaController::class, 'show'])->name('painel.turmas.show');
		Route::get('/novo', [TurmaController::class, 'create'])->name('painel.turmas.create');
		Route::post('/', [TurmaController::class, 'store'])->name('painel.turmas.store');
		Route::get('/editar/{id}', [TurmaController::class, 'edit'])->name('painel.turmas.editar');
		Route::patch('/{id}', [TurmaController::class, 'update'])->name('painel.turmas.update');
		Route::delete('/{id}', [TurmaController::class, 'destroy'])->name('painel.turmas.destroy');
		Route::post('/deletar', [TurmaController::class, 'destroyAll'])->name('painel.turmas.destroy.all');
		Route::post('/reuse', [TurmaController::class, 'reuse'])->name('painel.turmas.reuse');
		Route::post('/importar', [TurmaController::class, 'importar'])->name('painel.turmas.importar');
		Route::get('/log/{id}', [TurmaController::class, 'log'])->name('painel.turmas.log');
	});

	// cursos de Cursos
	Route::group(['prefix' => 'cursos'], function () {
		Route::get('/', [CursoController::class, 'index'])->name('painel.cursos')->middleware('permission:Index Cursos');
		Route::get('/detalhes/{id}', [CursoController::class, 'show'])->name('painel.cursos.show');
		Route::get('/novo', [CursoController::class, 'create'])->name('painel.cursos.create');
		Route::post('/', [CursoController::class, 'store'])->name('painel.cursos.store');
		Route::get('/editar/{id}', [CursoController::class, 'edit'])->name('painel.cursos.editar');
		Route::patch('/{id}', [CursoController::class, 'update'])->name('painel.cursos.update');
		Route::post('/deletar', [CursoController::class, 'destroy'])->name('painel.cursos.destroy');
		Route::post('/importar', [CursoController::class, 'importar'])->name('painel.cursos.importar');
		Route::get('/log/{id}', [CursoController::class, 'log'])->name('painel.cursos.log');
	});

	// Inscrições
	Route::group(['prefix' => 'inscricoes'], function () {
		Route::get('/', [InscricaoController::class, 'index'])->name('painel.inscricoes')->middleware('permission:Index Inscricoes');
		Route::get('/detalhes/{id}', [InscricaoController::class, 'show'])->name('painel.inscricoes.show');
		Route::get('/novo', [InscricaoController::class, 'create'])->name('painel.inscricoes.create');
		Route::post('/', [InscricaoController::class, 'store'])->name('painel.inscricoes.store');
		Route::get('/editar/{id}', [InscricaoController::class, 'edit'])->name('painel.inscricoes.editar');
		Route::patch('/{id}', [InscricaoController::class, 'update'])->name('painel.inscricoes.update');
		Route::post('/deletar', [InscricaoController::class, 'destroy'])->name('painel.inscricoes.destroy');
		Route::get('/log/{id}', [InscricaoController::class, 'log'])->name('painel.inscricoes.log');
		Route::patch('/inscricoes/enviaremail/{ids}', [InscricaoController::class, 'enviarEmail'])->name('painel.inscricoes.enviarEmail');
		Route::patch('/inscricoes/validardocinscricao/{id}', [InscricaoController::class, 'validarDocInscricao'])->name('painel.inscricoes.validarDocInscricao');
		Route::patch('/inscricoes/validardocmatricula/{id}', [InscricaoController::class, 'validarDocMatricula'])->name('painel.inscricoes.validarDocMatricula');
	});

	// Gestão
	Route::group(['prefix' => 'gestao'], function () {
		Route::get('/permissoes', [GestaoController::class, 'permissoes'])->name('painel.gestao.permissoes')->middleware('permission:Index Permissoes');
		Route::group(['prefix' => 'usuarios'], function () {
			Route::get('/', [UsuarioController::class, 'index'])->name('painel.gestao.usuarios');
			Route::get('/detalhes/{id}', [UsuarioController::class, 'show'])->name('painel.gestao.usuarios.show');
			Route::get('/novo', [UsuarioController::class, 'create'])->name('painel.gestao.usuarios.create');
			Route::post('/', [UsuarioController::class, 'store'])->name('painel.gestao.usuarios.store');
			Route::get('/editar/{id}', [UsuarioController::class, 'edit'])->name('painel.gestao.usuarios.editar');
			Route::patch('/{id}', [UsuarioController::class, 'update'])->name('painel.gestao.usuarios.update');
			Route::post('/permissoes/{id}', [UsuarioController::class, 'permission'])->name('painel.gestao.usuarios.permission');
			Route::post('/deletar', [UsuarioController::class, 'destroy'])->name('painel.gestao.usuarios.destroy');
		});

		Route::group(['prefix' => 'grupos'], function () {
			Route::get('/', [GrupoController::class, 'index'])->name('painel.gestao.grupos');
			Route::get('/novo', [GrupoController::class, 'create'])->name('painel.gestao.grupos.create');
			Route::post('/', [GrupoController::class, 'store'])->name('painel.gestao.grupos.store');
			Route::get('/editar/{id}', [GrupoController::class, 'edit'])->name('painel.gestao.grupos.editar');
			Route::patch('/{id}', [GrupoController::class, 'update'])->name('painel.gestao.grupos.update');
			Route::delete('/{id}', [GrupoController::class, 'destroy'])->name('painel.gestao.grupos.destroy');
		});

		// Permissions
		Route::group(['prefix' => 'permissoes'], function () {
			Route::get('/', [PermissionController::class, 'index'])->name('painel.gestao.permissoes')->middleware('permission:Index Permissoes');
			Route::get('/detalhes/{id}', [PermissionController::class, 'show'])->name('painel.gestao.permissoes.show');
			Route::get('/novo', [PermissionController::class, 'create'])->name('painel.gestao.permissoes.create');
			Route::post('/', [PermissionController::class, 'store'])->name('painel.gestao.permissoes.store');
			Route::get('/editar/{id}', [PermissionController::class, 'edit'])->name('painel.gestao.permissoes.editar');
			Route::patch('/{id}', [PermissionController::class, 'update'])->name('painel.gestao.permissoes.update');
			Route::post('/deletar/{id}', [PermissionController::class, 'destroy'])->name('painel.gestao.permissoes.destroy');
		});

		// Roles
		Route::group(['prefix' => 'roles'], function () {
			Route::get('/', [RoleController::class, 'index'])->name('painel.gestao.roles')->middleware('permission:Index Nivel de Acesso');
			Route::get('/detalhes/{id}', [RoleController::class, 'show'])->name('painel.gestao.roles.show');
			Route::get('/novo', [RoleController::class, 'create'])->name('painel.gestao.roles.create');
			Route::post('/', [RoleController::class, 'store'])->name('painel.gestao.roles.store');
			Route::get('/editar/{id}', [RoleController::class, 'edit'])->name('painel.gestao.roles.editar');
			Route::patch('/{id}', [RoleController::class, 'update'])->name('painel.gestao.roles.update');
			Route::post('/deletar/{id}', [RoleController::class, 'destroy'])->name('painel.gestao.roles.destroy');
		});
	});

	// STAI
	Route::group(['prefix' => 'stai'], function () {
		Route::group(['prefix' => 'agendamento'], function () {
			Route::get('/', [StaiAgendamentoController::class, 'index'])->name('painel.stai.agendamento')->middleware('permission:Index Stai');
			Route::get('/detalhes/{id}', [StaiAgendamentoController::class, 'show'])->name('painel.stai.agendamento.show');
			Route::get('/novo', [StaiAgendamentoController::class, 'create'])->name('painel.stai.agendamento.create');
			Route::post('/', [StaiAgendamentoController::class, 'store'])->name('painel.stai.agendamento.store');
			Route::get('/editar/{id}', [StaiAgendamentoController::class, 'edit'])->name('painel.stai.agendamento.editar');
			Route::patch('/{id}', [StaiAgendamentoController::class, 'update'])->name('painel.stai.agendamento.update');
			Route::post('/permissoes/{id}', [StaiAgendamentoController::class, 'permission'])->name('painel.stai.agendamento.permission');
			Route::post('/deletar', [StaiAgendamentoController::class, 'destroy'])->name('painel.stai.agendamento.destroy');
		});

		Route::group(['prefix' => 'editais'], function () {
			Route::get('/', [StaiEditaisController::class, 'index'])->name('painel.stai.editais')->middleware('permission:Index Stai');
			Route::get('/detalhes/{id}', [StaiEditaisController::class, 'show'])->name('painel.stai.editais.show');
			Route::get('/novo', [StaiEditaisController::class, 'create'])->name('painel.stai.editais.create');
			Route::post('/', [StaiEditaisController::class, 'store'])->name('painel.stai.editais.store');
			Route::get('/editar/{id}', [StaiEditaisController::class, 'edit'])->name('painel.stai.editais.editar');
			Route::patch('/{id}', [StaiEditaisController::class, 'update'])->name('painel.stai.editais.update');
			Route::post('/permissoes/{id}', [StaiEditaisController::class, 'permission'])->name('painel.stai.editais.permission');
			Route::post('/deletar', [StaiEditaisController::class, 'destroy'])->name('painel.stai.editais.destroy');
			Route::get('/log/{id}', [EditalController::class, 'log'])->name('painel.stai.editais.log');
			Route::post('/painel/stai/editais/{id}', [StaiEditaisController::class, 'autoupdate'])->name('painel.stai.editais.autoupdate');
		});
	});

	Route::group(['prefix' => 'configuracoes'], function () {
		Route::get('/', [ConfiguracoesController::class, 'index'])->name('painel.configuracoes');
	});

	//Tags
	Route::group(['prefix' => 'tags'], function () {
		Route::get('/', [TagController::class, 'index'])->name('painel.tags')->middleware('permission:Index Tags');
		Route::get('/detalhes/{id}', [TagController::class, 'show'])->name('painel.tags.show');
		Route::get('/novo', [TagController::class, 'create'])->name('painel.tags.create')->middleware('permission:Criar Tags');
		Route::post('/', [TagController::class, 'store'])->name('painel.tags.store')->middleware('permission:Criar Tags');
		Route::get('/editar/{id}', [TagController::class, 'edit'])->name('painel.tags.editar')->middleware('permission:Editar Tags');
		Route::patch('/{id}', [TagController::class, 'update'])->name('painel.tags.update')->middleware('permission:Editar Tags');
		Route::delete('/deletar', [TagController::class, 'destroy'])->name('painel.tags.destroy')->middleware('permission:Excluir Tags');
	});

	Route::group(['prefix' => 'areas'], function () {
		Route::get('/', [AreaController::class, 'index'])->name('painel.areas')->middleware('permission:Index Areas');
		Route::get('/detalhes/{id}', [AreaController::class, 'show'])->name('painel.areas.show');
		Route::get('/novo', [AreaController::class, 'create'])->name('painel.areas.create')->middleware('permission:Criar Areas');
		Route::post('/', [AreaController::class, 'store'])->name('painel.areas.store')->middleware('permission:Criar Areas');
		Route::get('/editar/{id}', [AreaController::class, 'edit'])->name('painel.areas.editar')->middleware('permission:Editar Areas');
		Route::patch('/{id}', [AreaController::class, 'update'])->name('painel.areas.update')->middleware('permission:Editar Areas');
		Route::post('/deletar', [AreaController::class, 'subAreaDestroy'])->name('painel.areas.subareas.destroy')->middleware('permission:Excluir Areas');
	});

	Route::group(['prefix' => 'habilitacao'], function () {
		Route::get('/', [HabilitacaoController::class, 'index'])->name('painel.habilitacao')->middleware('permission:Index Habilitacao');
		Route::get('/detalhes/{id}', [HabilitacaoController::class, 'show'])->name('painel.habilitacao.show');
		Route::get('/novo', [HabilitacaoController::class, 'create'])->name('painel.habilitacao.create')->middleware('permission:Criar Habilitacao');
		Route::post('/', [HabilitacaoController::class, 'store'])->name('painel.habilitacao.store')->middleware('permission:Criar Habilitacao');
		Route::get('/editar/{id}', [HabilitacaoController::class, 'edit'])->name('painel.habilitacao.editar')->middleware('permission:Editar Habilitacao');
		Route::patch('/{id}', [HabilitacaoController::class, 'update'])->name('painel.habilitacao.update')->middleware('permission:Editar Habilitacao');
		Route::delete('/deletar', [HabilitacaoController::class, 'destroy'])->name('painel.habilitacao.destroy')->middleware('permission:Excluir Habilitacao');
	});

	// Documentos
	Route::group(['prefix' => 'documentos'], function () {
		Route::post('/', [DocumentoController::class, 'store'])->name('painel.documentos.store');
		Route::patch('/{id}', [DocumentoController::class, 'update'])->name('painel.documentos.update');
		Route::delete('/deletar/{id}', [DocumentoController::class, 'destroy'])->name('painel.documentos.destroy');
	});

	// Tipos de Arquivos
	Route::group(['prefix' => 'documento'], function () {
		Route::get('/', [TipoArquivoController::class, 'index'])->name('painel.documento');
		Route::get('/novo', [TipoArquivoController::class, 'create'])->name('painel.documento.create');
		Route::get('/detalhes/{id}', [TipoArquivoController::class, 'show'])->name('painel.documento.show');
		Route::post('/', [TipoArquivoController::class, 'store'])->name('painel.documento.store');
		Route::get('/editar/{id}', [TipoArquivoController::class, 'edit'])->name('painel.documento.editar');
		Route::patch('/{id}', [TipoArquivoController::class, 'update'])->name('painel.documento.update');
		Route::post('/deletar', [TipoArquivoController::class, 'destroy'])->name('painel.documento.destroy');
		Route::get('/log/{id}', [TipoArquivoController::class, 'log'])->name('painel.documento.log');
	});

	Route::group(['prefix' => 'ticket'], function () {
		Route::get('/', [TicketController::class, 'index'])->name('painel.ticket')->middleware('permission:Index Ticket');
		Route::get('/novo', [TicketController::class, 'create'])->name('painel.ticket.create')->middleware('permission:Index Ticket');
		Route::get('/detalhes/{id}', [TicketController::class, 'show'])->name('painel.ticket.show')->middleware('permission:Index Ticket');
		Route::post('/', [TicketController::class, 'store'])->name('painel.ticket.store')->middleware('permission:Index Ticket');
		Route::get('/editar/{id}', [TicketController::class, 'edit'])->name('painel.ticket.editar')->middleware('permission:Index Ticket');
		Route::patch('/{id}', [TicketController::class, 'update'])->name('painel.ticket.update')->middleware('permission:Index Ticket');
		Route::post('/deletar', [TicketController::class, 'destroy'])->name('painel.ticket.destroy')->middleware('permission:Index Ticket');
		Route::get('/log/{id}', [TicketController::class, 'log'])->name('painel.ticket.log')->middleware('permission:Index Ticket');
		Route::post('/ticket/read/{id}', [TicketController::class, 'read'])->name('painel.ticket.read');
	});

	Route::group(['prefix' => 'edital_modelo'], function () {
		Route::get('/', [TicketController::class, 'index'])->name('edital_modelo.ticket')->middleware('permission:Index Edital Model');;
		Route::get('/novo', [TicketController::class, 'create'])->name('edital_modelo.ticket.create')->middleware('permission:Index Edital Model');;
		Route::get('/detalhes/{id}', [TicketController::class, 'show'])->name('edital_modelo.ticket.show')->middleware('permission:Index Edital Model');;
		Route::post('/', [TicketController::class, 'store'])->name('edital_modelo.ticket.store')->middleware('permission:Index Edital Model');;
		Route::get('/editar/{id}', [TicketController::class, 'edit'])->name('edital_modelo.ticket.editar')->middleware('permission:Index Edital Model');;
		Route::patch('/{id}', [TicketController::class, 'update'])->name('edital_modelo.ticket.update')->middleware('permission:Index Edital Model');;
		Route::post('/deletar', [TicketController::class, 'destroy'])->name('edital_modelo.ticket.destroy')->middleware('permission:Index Edital Model');;
		Route::get('/log/{id}', [TicketController::class, 'log'])->name('edital_modelo.ticket.log')->middleware('permission:Index Edital Model');;
	});

	// Perfil
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';