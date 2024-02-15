<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ConfiguracoesController extends Controller
{
    public function index()
	{
		return Inertia::render('Painel/Configuracoes/Index');
	}
}
