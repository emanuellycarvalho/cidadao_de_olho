<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;    

class DeputadoController extends Controller
{
    public function calcularReembolsoDeVerbasMensais(){
        $deputados = Http::get('http://dadosabertos.almg.gov.br/ws/deputados/em_exercicio?formato=json')['list'];
        foreach($deputados as $deputado){
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
                            'deputado' =>  $deputado['id'],
                            'mes' => $mes,
                            'ano' => 2019,
                         ],
                         [
                            'valor' => $total,
                            'updated_at' => now() 
                         ]
                        );
                    }
                }
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'O valor do reembolso mensal de cada deputado foi armazenado no banco de dados.'
        ]);
    }

    public function maiorReembolsoDeVerbasPorMes(){
        $result = array();
        for($mes = 1; $mes < 13; $mes++){
            $maiores = DB::table('deputado_reembolso_mensal')->where('mes', $mes)->orderByDesc('valor')->limit(5)->select('deputado', 'valor', 'updated_at')->get();
            array_push($result, [
                'mes' => $mes,
                'ano' => 2019,
                'maiores' => $maiores 
            ]);
        }
        return $result;
    }

    public function registrarRedesSociaisPorDeputado(){
        $deputados = Http::get('http://dadosabertos.almg.gov.br/ws/deputados/lista_telefonica?formato=json')['list'];
        foreach($deputados as $deputado){
            $redesSociais = $deputado['redesSociais'];
            if(sizeof($redesSociais) > 0){
                foreach($redesSociais as $rede){
                    DB::table('redes_sociais')->updateOrInsert([
                        'id' =>  $rede['redeSocial']['id'],
                        'nome' => $rede['redeSocial']['nome'],
                     ],
                    );

                    DB::table('deputado_redes_sociais')->updateOrInsert([
                        'deputado' => $deputado['id'],
                        'rede_id' =>  $rede['redeSocial']['id'],
                     ],
                     [
                        'updated_at' => now()
                     ]
                    );
                }
            }
        }
    }

    public function redesSociaisMaisUtilizadas(){
        $ranking = DB::select("SELECT count(*), rede_id FROM `deputado_redes_sociais` GROUP BY rede_id ORDER BY `count(*)` DESC");
            Arr::map($ranking, function($rede){
            $nome = DB::table('redes_sociais')->where('id', $rede->rede_id)->get()[0]->nome;
            $rede->nome = $nome;
        });

        return $ranking;
    }
}
