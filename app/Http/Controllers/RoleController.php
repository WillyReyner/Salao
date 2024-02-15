<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
	public function __construct()
	{
		$this->middleware(['permission:Index Nivel de Acesso|Criar Nivel de Acesso|Editar Nivel de Acesso|Excluir Nivel de Acesso|Importar Nivel de Acesso|Exportar Nivel de Acesso']);
	}

	public function index()
	{
		$roles = Role::with('permissions')->get();
		$permissions = Permission::all();

		return Inertia::render('Painel/Gestao/Roles/Index', [
			'roles' => $roles,
			'permissions' => $permissions
		]);
	}

	public function show($id)
	{
		$roles = Role::with('permissions')->find($id);
		$permissions = Permission::all();
		return Inertia::render('Painel/Gestao/Roles/Detalhes', [
			'roles' => $roles,
			'permissions' => $permissions
		]);
	}

	public function edit(Request $request, $id)
	{
		// dd($id);
		$roles = Role::all()->find($id);
		$permissionsAll = Permission::all();
		$permissionsId = $roles->permissions->pluck('id')->toArray();
		return Inertia::render('Painel/Gestao/Roles/Editar', [
			'roles' => $roles,
			'permissionsId' => $permissionsId,
			'permissionsAll' => $permissionsAll
		]);
	}

	public function store(Request $request)
	{
		$request->validate([
			'name' => 'required|unique:roles,name',
			'permissions' => 'required'
		]);

		$role = Role::create([
			'name' => $request->input('name'),
		]);

		$role->syncPermissions($request->input('permissions'));

		return redirect()->route('painel.gestao.roles')->with('response', $role);
	}

	public function create()
	{
		$roles = Role::with('permissions')->get();
		$permissions = Permission::all();
		return Inertia::render('Painel/Gestao/Roles/Novo', [
			'roles' => $roles,
			'permissions' => $permissions
		]);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'name' => 'required',
			'permissions' => 'required'
		]);

		$role = Role::find($id);

		if (!$role) {
			// Verifique se a função com o ID especificado existe
			abort(404); // Ou faça algo apropriado para lidar com a função não encontrada
		}

		$role->name = $request->input('name');
		$role->save();

		$permissions = $request->input('permissions');

		if (is_array($permissions)) {
			// Remova permissões existentes
			$role->revokePermissionTo($role->permissions);

			// Conceda as novas permissões
			$role->givePermissionTo($permissions);
		}

		return redirect()->route('painel.gestao.roles')->with('response', $role);
	}


	public function destroy($id)
	{
		$role = Role::find($id);

		$role->delete();

		return redirect()->back()->with('response', $role);
	}
}
