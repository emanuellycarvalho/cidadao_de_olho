<?php

namespace App\Http\Controllers;

use App\Models\Deputado;
use App\Models\RedeSocial;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;    

class DeputadoController extends Controller
{
    
    public function maiorReembolsoDeVerbasPorMes(){
        $result = array();
        for($mes = 1; $mes < 13; $mes++){
            $maiores = DB::table('deputado_reembolso_mensal')->where('mes', $mes)->orderByDesc('valor')->limit(5)->select('deputado_id', 'valor', 'updated_at')->get();
            $maiores = $maiores->map(function($item, $deputado_id){
                $item->nome = Deputado::find($item->deputado_id)->nome;
                return $item;
            });

            array_push($result, [
                'mes' => $mes,
                'ano' => 2019,
                'ranking' => $maiores 
            ]);
        }
        return $result;
    }

    public function rankingRedesSociais(){
        $ranking = DB::select("SELECT count(*) as usuarios, rede_id FROM `deputado_redes_sociais` WHERE `active` = true GROUP BY rede_id ORDER BY `usuarios` DESC");
        Arr::map($ranking, function($rede){
            $nome = RedeSocial::find($rede->rede_id)->nome;
            $rede->nome = $nome;
        });

        return $ranking;
    }
}
