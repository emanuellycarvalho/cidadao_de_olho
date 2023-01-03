<?php

namespace App\Http\Controllers;

use App\Models\Deputado;
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

    public function redesSociaisMaisUtilizadas(){
        $ranking = DB::select("SELECT count(*), rede_id FROM `deputado_redes_sociais` GROUP BY rede_id ORDER BY `count(*)` DESC");
            Arr::map($ranking, function($rede){
            $nome = DB::table('redes_sociais')->where('id', $rede->rede_id)->get()[0]->nome;
            $rede->nome = $nome;
        });

        return $ranking;
    }
}
