<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeputadoController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('deputados/verbas/calcular/reembolso-mensal', [DeputadoController::class, 'calcularReembolsoDeVerbasMensais']);
Route::get('deputados/verbas/calcular/reembolso-mensal', [DeputadoController::class, 'calcularReembolsoDeVerbasMensais']);
Route::get('deputados/redes-sociais/registar-rede-por-deputado', [DeputadoController::class, 'registrarRedesSociaisPorDeputado']);
Route::get('deputados/redes-sociais/mais-utilizada', [DeputadoController::class, 'redesSociaisMaisUtilizadas']);