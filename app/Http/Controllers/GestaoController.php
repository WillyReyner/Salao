<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GestaoController extends Controller
{

    public function usuarios()
    {
        $usuarios = User::with('roles')->get();
        return Inertia::render('Painel/Gestao/Usuarios', [
            'usuarios' => $usuarios
        ]);
    }

    public function grupos()
    {
        $grupos = Role::all();
        return Inertia::render('Painel/Gestao/Grupos', [
            'grupos' => $grupos
        ]);
    }

    public function permissoes()
    {
        $permissoes = Permission::all();
        return Inertia::render('Painel/Gestao/Permissoes', [
            'permissoes' => $permissoes
        ]);
    }
}
