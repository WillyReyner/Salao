<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Municipio;
use Spatie\Permission\Models\Permission;

class PermissaoController extends Controller
{

    public function index()
    {
        $permissoes = Permission::all();
        return Inertia::render('Painel/Gestao/Permissoes', [
            'permissoes' => $permissoes
        ]);
    }


}
