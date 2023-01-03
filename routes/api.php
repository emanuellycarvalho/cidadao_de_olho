<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeputadoController;
use Illuminate\Support\Facades\Http;    
use Illuminate\Support\Facades\DB;
use App\Models\RedeSocial;
use App\Models\Deputado;


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

Route::get('povoar-database', function(){
    $deputados = Http::get('http://dadosabertos.almg.gov.br/ws/deputados/lista_telefonica?formato=json')['list'];
    foreach($deputados as $deputado){
        // deputados
        Deputado::updateOrInsert([
            'id' =>  $deputado['id'],
            'nome' => $deputado['nome'],
         ],
         [ 
            'partido' => $deputado['partido'],
            'updated_at' => now()
         ]
        );

        // redes sociais  
        $redesSociais = $deputado['redesSociais'];
        if(sizeof($redesSociais) > 0){
            foreach($redesSociais as $rede){
                RedeSocial::updateOrInsert([
                    'id' =>  $rede['redeSocial']['id'],
                    'nome' => $rede['redeSocial']['nome'],
                    ],
                );

                DB::table('deputado_redes_sociais')->updateOrInsert([
                    'deputado_id' => $deputado['id'],
                    'rede_id' =>  $rede['redeSocial']['id'],
                    'active' => true
                    ],
                    [
                        'updated_at' => now()
                    ]
                );
            }
        }

        // reembolso de verbas por mes
        for($mes = 1; $mes < 13; $mes++){
            $total = 0;
            $verbas = Http::get('http://dadosabertos.almg.gov.br/ws/prestacao_contas/verbas_indenizatorias/deputados/' . $deputado['id'] . '/2019/' . $mes . '?formato=json');
            if(isset($verbas['list'])){
                $verbas = $verbas['list'];
                foreach($verbas as $verba){
                    $total += $verba['valor'];
                }

                if($total > 0){
                    DB::table('deputado_reembolso_mensal')->updateOrInsert([
                        'deputado_id' =>  $deputado['id'],
                        'mes' => $mes,
                        'ano' => 2019,
                        'valor' => $total,
                     ],
                     [
                        'updated_at' => now() 
                     ]
                    );
                }
            }
        }
    }
});

Route::get('deputados/verbas/maior-reembolso-mensal', [DeputadoController::class, 'maiorReembolsoDeVerbasPorMes']);
Route::get('deputados/redes-sociais/mais-utilizada', [DeputadoController::class, 'redesSociaisMaisUtilizadas']);