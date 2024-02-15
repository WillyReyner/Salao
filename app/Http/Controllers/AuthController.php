<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

//	"token": "7|gYwoBrkKblbpHtCBWBdU1tIaa04th9pIgIN75zLjd6d6564e"

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = $request->user(); // Obtém o modelo do usuário autenticado
            $token = $user->createToken('invoice');

            $data = [
                'message' => 'Authorized',
                'user' => $user,
                'token' => $token->plainTextToken,
            ];

            return response()->json($data, 200);
        }

        $data = ['message' => 'Not Authorized'];
        return response()->json($data, 403);
    }
}
