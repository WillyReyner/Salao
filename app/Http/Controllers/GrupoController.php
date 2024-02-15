<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GrupoController extends Controller
{


    public function index()
    {
        $roles = Role::with('permissions')->get();
        return Inertia::render('Painel/Gestao/Grupos/Index', [
            'roles' => $roles
        ]);
    }

    public function create(){
        $permissions = Permission::all();
        return Inertia::render('Painel/Gestao/Grupos/Novo', [
            'permissions' => $permissions
        ]);
    }
    public function store(Request $request) {

        $request->validate([
            'name' => 'required',
            'permissions' => 'required',
        ], [
            'required' => 'O campo é obrigatório',
        ]);

        $role = Role::create(['name' => $request->name]);

        $role->syncPermissions($request->permissions);

        return redirect()->route('painel.gestao.grupos')->with('response', $role);
    }
 
    public function edit(Request $request, $id){
        $role = Role::with('permissions')->find($id);

        $permissions = Permission::all();
        return Inertia::render('Painel/Gestao/Grupos/Editar', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'permissions' => 'required',
        ], [
            'required' => 'O campo é obrigatório',
        ]);

        $role = Role::findById($id);
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);

        return redirect()->route('painel.gestao.grupos')->with('response', $role);
    }
    public function destroy($id) {
        $role = Role::findById($id);
        $role->delete();

        return redirect()->route('painel.gestao.grupos')->with('response', $role);
    }
}
