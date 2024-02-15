<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EditalApiController;
use App\Http\Controllers\CursoApiController;
use App\Http\Controllers\TurmaApiController;
use App\Http\Controllers\AuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

    Route::prefix('v1')->group(function () {

        Route::post('/login',[AuthController::class, 'login']);
        
        // Rotas para Editais
        Route::get('/editais/index', [EditalApiController::class, 'index'])->name('api.editais.index');
        Route::get('/editais/show/{id}', [EditalApiController::class, 'show'])->name('api.editais.show');
        Route::post('/editais/store', [EditalApiController::class, 'store'])->name('api.editais.store');
        Route::put('/editais/update/{id}', [EditalApiController::class, 'update'])->name('api.editais.update');
        Route::delete('/editais/delete/{id}', [EditalApiController::class, 'destroy'])->name('api.editais.destroy');
    
        // Rotas para Turmas
        Route::get('/turmas/index', [TurmaApiController::class, 'index'])->name('api.turmas.index');
        Route::get('/turmas/show/{id}', [TurmaApiController::class, 'show'])->name('api.turmas.show');
        Route::post('/turmas/store', [TurmaApiController::class, 'store'])->name('api.turmas.store');
        Route::put('/turmas/update/{id}', [TurmaApiController::class, 'update'])->name('api.turmas.update');
        Route::delete('/turmas/delete/{id}', [TurmaApiController::class, 'destroy'])->name('api.turmas.destroy');
    
        // Rotas para Cursos
        Route::get('/cursos/index', [CursoApiController::class, 'index'])->name('api.cursos.index');
        Route::get('/cursos/show/{id}', [CursoApiController::class, 'show'])->name('api.cursos.show');
        Route::post('/cursos/store', [CursoApiController::class, 'store'])->name('api.cursos.store');
        Route::put('/cursos/update/{id}', [CursoApiController::class, 'update'])->name('api.cursos.update');
        Route::delete('/cursos/delete/{id}', [CursoApiController::class, 'destroy'])->name('api.cursos.destroy');

        //Rotas para TAGS
        Route::get('/tags/index', [TagApiController::class, 'index'])->name('api.tags.index');
        Route::get('/tags/show/{id}', [TagApiController::class, 'show'])->name('api.tags.show');
        Route::post('/tags/store', [TagApiController::class, 'store'])->name('api.tags.store');
        Route::patch('/tags/update/{id}', [TagApiController::class, 'update'])->name('api.tags.update');
        Route::delete('/tags/deletar/{id}', [TagApiController::class, 'destroy'])->name('api.tags.destroy');
    });
});
