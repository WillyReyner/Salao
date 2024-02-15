<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|max:255|required_with:email_confirmation|same:email_confirmation|unique:'.User::class,
            'cpf' => 'required',
            'telefone' => 'required',
            'setor' => 'nullable',
            'funcao' => 'nullable',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
        ], [
            'required' => 'O campo é obrigatório',
            'same' => 'Os campos não conferem',
            'unique' => "Já existe um registro com esse dado"
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Usuario',
            'cpf' => $request->cpf,
            'data_nascimento' => $request->data_nascimento,
            'telefone' => $request->telefone,
            'situacao' => 'NOVO',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
