<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		// Grupos
		$admin = Role::create(['name' => 'Admin']);
		$secretaria = Role::create(['name' => 'Secretaria']);
		$usuario = Role::create(['name' => 'Usuario']);
		$escola = Role::create(['name' => 'Escola']);

		// Inscricoes
		$inscricoes_index = Permission::create(['name' => 'Index Inscricoes']);
		$inscricoes_criar = Permission::create(['name' => 'Criar Inscricoes']);
		$inscricoes_editar = Permission::create(['name' => 'Editar Inscricoes']);
		$inscricoes_deletar = Permission::create(['name' => 'Excluir Inscricoes']);
		$inscricoes_importar = Permission::create(['name' => 'Importar Inscricoes']);
		$inscricoes_exportar = Permission::create(['name' => 'Exportar Inscricoes']);
		$inscricoes_topbar = Permission::create(['name' => 'Sidebar Inscricoes']);
		$inscricoes_permissoes = [$inscricoes_index, $inscricoes_criar, $inscricoes_editar, $inscricoes_deletar, $inscricoes_importar, $inscricoes_importar, $inscricoes_exportar, $inscricoes_topbar];

		// Cursos
		$cursos_index = Permission::create(['name' => 'Index Cursos']);
		$cursos_criar = Permission::create(['name' => 'Criar Cursos']);
		$cursos_editar = Permission::create(['name' => 'Editar Cursos']);
		$cursos_deletar = Permission::create(['name' => 'Excluir Cursos']);
		$cursos_importar = Permission::create(['name' => 'Importar Cursos']);
		$cursos_exportar = Permission::create(['name' => 'Exportar Cursos']);
		$cursos_topbar = Permission::create(['name' => 'Sidebar Cursos']);
		$cursos_permissoes = [$cursos_index, $cursos_criar, $cursos_editar, $cursos_deletar, $cursos_importar, $cursos_importar, $cursos_exportar, $cursos_topbar];

		// Turmas
		$turmas_index = Permission::create(['name' => 'Index Turmas']);
		$turmas_criar = Permission::create(['name' => 'Criar Turmas']);
		$turmas_editar = Permission::create(['name' => 'Editar Turmas']);
		$turmas_deletar = Permission::create(['name' => 'Excluir Turmas']);
		$turmas_importar = Permission::create(['name' => 'Importar Turmas']);
		$turmas_exportar = Permission::create(['name' => 'Exportar Turmas']);
		$turmas_topbar = Permission::create(['name' => 'Sidebar Turmas']);
		$turmas_permissoes = [$turmas_index, $turmas_criar, $turmas_editar, $turmas_deletar, $turmas_importar, $turmas_importar, $turmas_exportar, $turmas_topbar];

		// Documentos
		$documentos_index = Permission::create(['name' => 'Index Documentos']);
		$documentos_criar = Permission::create(['name' => 'Criar Documentos']);
		$documentos_editar = Permission::create(['name' => 'Editar Documentos']);
		$documentos_deletar = Permission::create(['name' => 'Excluir Documentos']);
		$documentos_importar = Permission::create(['name' => 'Importar Documentos']);
		$documentos_exportar = Permission::create(['name' => 'Exportar Documentos']);
		$documentos_topbar = Permission::create(['name' => 'Topbar Documentos']);
		$documentos_permissoes = [$documentos_index, $documentos_criar, $documentos_editar, $documentos_deletar, $documentos_importar, $documentos_importar, $documentos_exportar, $documentos_topbar];

		// Tags
		$tags_index = Permission::create(['name' => 'Index Tags']);
		$tags_criar = Permission::create(['name' => 'Criar Tags']);
		$tags_editar = Permission::create(['name' => 'Editar Tags']);
		$tags_deletar = Permission::create(['name' => 'Excluir Tags']);
		$tags_importar = Permission::create(['name' => 'Importar Tags']);
		$tags_exportar = Permission::create(['name' => 'Exportar Tags']);
		$tags_topbar = Permission::create(['name' => 'Topbar Tags']);
		$tags_permissoes = [$tags_index, $tags_criar, $tags_editar, $tags_deletar, $tags_importar, $tags_importar, $tags_exportar, $tags_topbar];

		// Areas
		$areas_index = Permission::create(['name' => 'Index Areas']);
		$areas_criar = Permission::create(['name' => 'Criar Areas']);
		$areas_editar = Permission::create(['name' => 'Editar Areas']);
		$areas_deletar = Permission::create(['name' => 'Excluir Areas']);
		$areas_importar = Permission::create(['name' => 'Importar Areas']);
		$areas_exportar = Permission::create(['name' => 'Exportar Areas']);
		$areas_topbar = Permission::create(['name' => 'Topbar Areas']);
		$areas_permissoes = [$areas_index, $areas_criar, $areas_editar, $areas_deletar, $areas_importar, $areas_importar, $areas_exportar, $areas_topbar];

		// Habilitacao
		$Habilitacao_index = Permission::create(['name' => 'Index Habilitacao']);
		$habilitacao_criar = Permission::create(['name' => 'Criar Habilitacao']);
		$habilitacao_editar = Permission::create(['name' => 'Editar Habilitacao']);
		$habilitacao_deletar = Permission::create(['name' => 'Excluir Habilitacao']);
		$habilitacao_importar = Permission::create(['name' => 'Importar Habilitacao']);
		$habilitacao_exportar = Permission::create(['name' => 'Exportar Habilitacao']);
		$habilitacao_topbar = Permission::create(['name' => 'Topbar Habilitacao']);
		$habilitacao_permissoes = [$Habilitacao_index, $habilitacao_criar, $habilitacao_editar, $habilitacao_deletar, $habilitacao_importar, $tags_importar, $habilitacao_exportar, $habilitacao_topbar];

		// Ticket
		$ticket_index = Permission::create(['name' => 'Index Ticket']);
		$ticket_criar = Permission::create(['name' => 'Criar Ticket']);
		$ticket_editar = Permission::create(['name' => 'Editar Ticket']);
		$ticket_deletar = Permission::create(['name' => 'Excluir Ticket']);
		$ticket_importar = Permission::create(['name' => 'Importar Ticket']);
		$ticket_exportar = Permission::create(['name' => 'Exportar Ticket']);
		$ticket_topbar = Permission::create(['name' => 'Topbar Ticket']);
		$ticket_permissoes = [$ticket_index, $ticket_criar, $ticket_editar, $ticket_deletar, $ticket_importar, $ticket_importar, $ticket_exportar, $ticket_topbar];

		// Escolas
		$escola_index = Permission::create(['name' => 'Index Escolas']);
		$escola_criar = Permission::create(['name' => 'Criar Escolas']);
		$escola_editar = Permission::create(['name' => 'Editar Escolas']);
		$escola_deletar = Permission::create(['name' => 'Excluir Escolas']);
		$escola_importar = Permission::create(['name' => 'Importar Escolas']);
		$escola_exportar = Permission::create(['name' => 'Exportar Escolas']);
		$escola_topbar = Permission::create(['name' => 'Topbar Escolas']);
		$escola_permissoes = [$escola_index, $escola_criar, $escola_editar, $escola_deletar, $escola_importar, $escola_importar, $escola_exportar, $escola_topbar];

		// Usuário
		$usuario_index = Permission::create(['name' => 'Index Usuarios']);
		$usuario_criar = Permission::create(['name' => 'Criar Usuarios']);
		$usuario_editar = Permission::create(['name' => 'Editar Usuarios']);
		$usuario_deletar = Permission::create(['name' => 'Excluir Usuarios']);
		$usuario_importar = Permission::create(['name' => 'Importar Usuarios']);
		$usuario_exportar = Permission::create(['name' => 'Exportar Usuarios']);
		$usuario_topbar = Permission::create(['name' => 'Topbar Usuarios']);
		$usuario_permissoes = [$usuario_index, $usuario_criar, $usuario_editar, $usuario_deletar, $usuario_importar, $usuario_importar, $usuario_exportar, $usuario_topbar];

		//niveis de Acessos
		$niveis_de_acesso_index = Permission::create(['name' => 'Index Nivel de Acesso']);
		$niveis_de_acesso_criar = Permission::create(['name' => 'Criar Nivel de Acesso']);
		$niveis_de_acesso_editar = Permission::create(['name' => 'Editar Nivel de Acesso']);
		$niveis_de_acesso_deletar = Permission::create(['name' => 'Excluir Nivel de Acesso']);
		$niveis_de_acesso_topbar = Permission::create(['name' => 'Topbar Nivel de Acesso']);
		$niveis_de_acesso_permissoes = [$niveis_de_acesso_index, $niveis_de_acesso_criar, $niveis_de_acesso_editar, $niveis_de_acesso_deletar, $niveis_de_acesso_topbar];

		// permissoes
		$permissao_index = Permission::create(['name' => 'Index Permissoes']);
		$permissao_criar = Permission::create(['name' => 'Criar Permissoes']);
		$permissao_editar = Permission::create(['name' => 'Editar Permissoes']);
		$permissao_deletar = Permission::create(['name' => 'Excluir Permissoes']);
		$permissao_topbar = Permission::create(['name' => 'Topbar Permissoes']);
		$permissao_permissoes = [$permissao_index, $permissao_criar, $permissao_editar, $permissao_deletar, $permissao_topbar];

		// Editais

		$edital_listar = Permission::create(['name' => 'Index Editais']);
		$edital_criar = Permission::create(['name' => 'Criar Editais']);
		$edital_editar = Permission::create(['name' => 'Editar Editais']);
		$edital_deletar = Permission::create(['name' => 'Excluir Editais']);
		$edital_importar = Permission::create(['name' => 'Importar Editais']);
		$edital_exportar = Permission::create(['name' => 'Exportar Editais']);
		$edital_sidebar = Permission::create(['name' => 'Sidebar Editais']);
		$edital_permissoes = [$edital_criar, $edital_editar, $edital_listar, $edital_deletar, $edital_importar, $edital_exportar, $edital_sidebar];

		// Municípios

		$municipio_listar = Permission::create(['name' => 'Index Municipios']);
		$municipio_criar = Permission::create(['name' => 'Criar Municipios']);
		$municipio_editar = Permission::create(['name' => 'Editar Municipios']);
		$municipio_deletar = Permission::create(['name' => 'Excluir Municipios']);
		$municipio_importar = Permission::create(['name' => 'Importar Municipios']);
		$municipio_exportar = Permission::create(['name' => 'Exportar Municipios']);
		$municipio_topbar = Permission::create(['name' => 'Topbar Municipios']);
		$municipio_permissoes = [$municipio_criar, $municipio_editar, $municipio_listar, $municipio_deletar, $municipio_importar, $municipio_exportar, $municipio_topbar];

		// Stai

		$stai_listar = Permission::create(['name' => 'Index Stai']);
		$stai_criar = Permission::create(['name' => 'Criar Stai']);
		$stai_editar = Permission::create(['name' => 'Editar Stai']);
		$stai_deletar = Permission::create(['name' => 'Excluir Stai']);
		$stai_importar = Permission::create(['name' => 'Importar Stai']);
		$stai_exportar = Permission::create(['name' => 'Exportar Stai']);
		$stai_sidebar = Permission::create(['name' => 'Sidebar Stai']);
		$stai_permissoes = [$stai_criar, $stai_editar, $stai_listar, $stai_deletar, $stai_importar, $stai_exportar, $stai_sidebar];

		// Logs
		$logs_index = Permission::create(['name' => 'Logs Geral']);
		$logs_inscricoes = Permission::create(['name' => 'Logs Inscricoes']);
		$logs_cursos = Permission::create(['name' => 'Logs Cursos']);
		$logs_turmas = Permission::create(['name' => 'Logs Turmas']);
		$logs_editais = Permission::create(['name' => 'Logs Editais']);
		$logs_stai = Permission::create(['name' => 'Logs Stai']);
		$logs_permissoes = [$logs_inscricoes, $logs_cursos, $logs_turmas, $logs_editais, $logs_index, $logs_stai];

		// $logs_municipios = Permission::create(['name' => 'Logs Municipios']);
		// $logs_documentos = Permission::create(['name' => 'Logs Documentos']);
		// $logs_tags = Permission::create(['name' => 'Logs Tags']);
		// $logs_escolas = Permission::create(['name' => 'Logs Escolas']);
		// $logs_usuarios = Permission::create(['name' => 'Logs Usuarios']);

		//Permissões por Grupo
		$permissoes_admin = array_merge($areas_permissoes, $municipio_permissoes, $edital_permissoes, $permissao_permissoes, $niveis_de_acesso_permissoes, $usuario_permissoes, $escola_permissoes, $tags_permissoes, $documentos_permissoes, $turmas_permissoes, $cursos_permissoes, $inscricoes_permissoes, $logs_permissoes, $habilitacao_permissoes, $ticket_permissoes, $stai_permissoes);

		$admin->syncPermissions($permissoes_admin);
	}
}
