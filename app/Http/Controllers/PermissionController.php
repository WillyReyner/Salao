<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['permission:Index Permissoes|Criar Permissoes|Editar Permissoes|Excluir Permissoes|Importar Permissoes|Exportar Permissoes']);
    }

    public function index()
    {
        $permissions = Permission::all();

        return Inertia::render('Painel/Gestao/Permissoes/Index', [
            'permissions' => $permissions
        ]);
    }

    public function create()
    {
        $permissions = Permission::all();
        return Inertia::render('Painel/Gestao/Permissoes/Novo', [
            'permissions' => $permissions,
        ]);
    }

    public function show($id)
    {
        $permissoes = Permission::all()->find($id);
        return Inertia::render('Painel/Gestao/Permissoes/Detalhes', [
            'permissions' => $permissoes,
        ]);
    }

    public function edit(Request $request, $id)
    {
        $permissoes = Permission::all()->find($id);
        return Inertia::render('Painel/Gestao/Permissoes/Editar', [
            'permissoes' => $permissoes,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $permission = Permission::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('painel.gestao.permissoes')->with('response', $permission);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->input('name');
        $permission->save();
        
        return redirect()->route('painel.gestao.permissoes')->with('response', $permission);
    }

    public function destroy($id)
    {
        $permission = Permission::find($id);

        $permission->delete();

        return redirect()->route('painel.gestao.permissoes')->with('response', $permission);
    }
}