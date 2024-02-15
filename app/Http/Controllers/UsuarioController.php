<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;


class UsuarioController extends Controller
{
	public function __construct()
	{
		$this->middleware(['permission:Index Usuarios|Criar Usuarios|Editar Usuarios|Excluir Usuarios|Importar Usuarios|Exportar Usuarios']);
	}

	public function index()
	{
		$usuarios = User::with('permissions', 'roles')->get();
		$roles = Role::all();
		$permissions = Permission::all();
		return Inertia::render('Painel/Gestao/Usuarios/Index', [
			'usuarios' => $usuarios,
			'permissions' => $permissions,
			'roles' => $roles,
		]);
	}

	public function show($id)
	{
		$usuarios = User::with('permissions', 'roles')->find($id);
		return Inertia::render('Painel/Gestao/Usuarios/Detalhes', [
			'usuarios' => $usuarios,
		]);
	}

	public function store(Request $request)
	{
		$Users = User::all();

		$role = Role::find($request->role);
		if ($role) {
			$roleName = $role->name;
		} else {
			$roleName = null;
		}

		$request->validate([
			'name' => 'required',
			'cpf' => ['required', 'unique:users'],
			'telefone' => 'required',
			'email' => ['required', 'unique:users'],
			'data_nascimento' => 'required',
			'role' => 'required'
		], [
			'name.required' => 'O campo nome é obrigatório',
			'cpf.required' => 'O campo CPF é obrigatório',
			'cpf.unique' => 'Este CPF já está sendo utilizado',
			'telefone.required' => 'O campo telefone é obrigatório',
			'email.required' => 'O campo e-mail é obrigatório',
			'email.unique' => 'Este EMAIL já está sendo utilizado',
			'data_nascimento.required' => 'O campo data de nascimento é obrigatório',
			'role.required' => 'O campo papel é obrigatório',
		]);

		foreach ($Users as $user) {
			if ($user->name !== $request->name || $user->email !== $request->email || $user->cpf !== $request->cpf) {

				$user = User::create([
					'name' => $request->name,
					'cpf' => $request->cpf,
					'telefone' => $request->telefone,
					'email' => $request->email,
					'data_nascimento' => $request->data_nascimento,
					'role' => $roleName,
					'created_by' => auth()->user()->id,
				]);

				if ($request->file('imagem')) {
					$path = Storage::putFile('usuarios/' . $user->id, $request->file('imagem'));
					$user->imagem = $path;
				}

				$user->save();
				$user->assignRole($request->input('role'));
				return redirect()->route('painel.gestao.usuarios')->with('response', $user);
			} else {
				echo "<script>window.confirm('Por gentilez corrija os campos')</script>";
			}
		}
	}

	public function create()
	{
		$permissions = Permission::all();
		$roles = Role::all();
		return Inertia::render('Painel/Gestao/Usuarios/Novo', [
			'permissions' => $permissions,
			'roles' => $roles
		]);
	}

	public function edit(Request $request, $id)
	{
		$usuarios = User::with('permissions', 'roles')->find($id);

		$permissions = Permission::all();
		$roles = Role::all();

		return Inertia::render('Painel/Gestao/Usuarios/Editar', [
			'usuarios' => $usuarios,
			'roles' => $roles,
			'permissions' => $permissions
		]);
	}

	public function update(Request $request, $id)
	{
		$role = Role::find($request->role);
		if ($role) {
			$roleName = $role->name;
		} else {
			$roleName = null;
		}

		$request->validate([
			'name' => 'required',
			'cpf' => 'required',
			'telefone' => 'required',
			'email' => 'required',
			'data_nascimento' => 'required',
			'role' => 'required'
		], [
			'required' => 'O campo é obrigatório',
		]);

		$usuario = User::find($id);
		$usuario->name = $request->name;
		$usuario->cpf = $request->cpf;
		$usuario->telefone = $request->telefone;
		$usuario->email = $request->email;
		$usuario->role = $roleName;
		$usuario->data_nascimento = $request->data_nascimento;
		$usuario->updated_by = auth()->user()->id;

		if ($request->file('imagem')) {
			$path = Storage::putFile('usuarios/' . $usuario->id, $request->file('imagem'));
			$usuario->imagem = $path;
		}

		$usuario->save();

		DB::table('model_has_roles')->where('model_id', $id)->delete();

		$usuario->assignRole($request->input('role'));

		activity()
			->causedBy(auth()->user())
			->performedOn($usuario)
			->withProperties(['permissao' => 'editar usuario'])
			->log('Usuário atualizado');

		return redirect()->route('painel.gestao.usuarios')->with('response', $usuario);
	}

	public function destroy(Request $request)
	{
		$id = $request->id;

		$usuario = is_array($id) ? User::destroy($id) : User::findOrFail($id)->delete();

		activity()
			->causedBy(auth()->user())
			//            ->performedOn($usuario)
			->withProperties(['permissao' => 'deletar usuario'])
			->log('Usuário removido');

		return redirect()->route('painel.gestao.usuarios')->with('response', $usuario);
	}

	public function permission(Request $request, User $user)
	{
		$selectedPermissions = $request->input('permissions', []);
		$allPermissions = Permission::all();
		$user->revokePermissionTo($allPermissions);
		$user->givePermissionTo($selectedPermissions);
		return response()->json(['message' => 'Permissões atualizadas com sucesso']);
	}
}
