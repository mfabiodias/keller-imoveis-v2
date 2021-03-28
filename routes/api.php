<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

######################################################
# Grupo de Rotas - Login, Logout e Ping              #
######################################################
Route::name('api.')->group(function () {
    # Login (Gerar token de acesso para páginas restritas)
    Route::post('login', [UserController::class, 'login'])
        ->name('login');
    
    # Logout (Remover um ou mais tokens do usuário logado)
    Route::delete('logout', [UserController::class, 'logout'])
        ->middleware('auth:sanctum')
        ->name('logout');
    
    # Ping (Verifica se o usuário está logado)
    Route::get('ping', [UserController::class, 'ping'])
        ->middleware('auth:sanctum')
        ->name('ping');
});
######################################################
######################################################