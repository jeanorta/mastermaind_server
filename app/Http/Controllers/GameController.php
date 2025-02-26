<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Game as Games;
use Illuminate\Http\Request;

class GameController extends Controller
{


    public function index()
    {
        return response()->json(Games::latest()->take(10)->get(), 200);
    }

    public function store(Request $request)
    {
        if(isset($request['id']) && $request['id']>0){
            if(!isset($request['user_code'])){
                $error = [];
                $error['error'] = "Falta el elemento: user_code.";
                return response()->json($error, 400);
            }
            $game = Games::find($request['id']);
            if($game == ''){
                $request['error'] = 'No existe.';
                return response()->json($request, 404);
            }
            if($game['status']=='en juego'){
                $game['round'] = $game['round'] + 1;
                $game['user_code_'.$game['round']] = $request['user_code'];

                // Comprobar que ambos arrays tienen 4 elementos
                if (count(json_decode($request['user_code'])) !== 4) {
                    $error = [];
                    $error['error'] = "El código no contiene 4 elementos.";
                    return response()->json($error, 400);
                }

                $rs = $this->check_code($game['secret_code'],$request['user_code']);
                $game['check_code_'.$game['round']] = json_encode($rs);
                $suma = array_sum($rs);
                if($suma == 8 ){
                    $game['status']='finalizada con victoria';
                    $game['score']= 11 - $game['round'];
                }
                if($suma != 8 && $game['round']==5){
                    $game['status']='finalizada con derrota';
                    $game['score']= 0;
                }
                $game->save();
                return response()->json($game, 200);
            }else{
                return response()->json($game, 201);
            }
        }else{
            $request['secret_code'] = $this->create_code();
            $request['colors'] = json_encode(array("AMARILLO", "AZUL", "ROJO", "VERDE", "NARANJA", "VIOLETA"));
            if($request['name']==""){
                $request['name']  = 'game_' . uniqid();
            }
            $game = Games::create($request->all());
            return response()->json($game, 201);
        }
    }

    public function create_code(){
        $colores = array("AMARILLO", "AZUL", "ROJO", "VERDE", "NARANJA", "VIOLETA");

        // Mezclar el array de forma aleatoria
        shuffle($colores);

        // Seleccionar los primeros 4 colores sin repetir
        $array4Colores = array_slice($colores, 0, 4);

        return json_encode($array4Colores);

    }

    public function check_code($secret_code,$user_code)
    {
        $data1 = json_decode($secret_code, true);
        $data2 = json_decode($user_code, true);
        // Validar que la decodificación fue exitosa
        if ($data1 === null || $data2 === null) {
            $error = [];
            $error['error'] = "Error al decodificar alguno de los archivos JSON.";
            return response()->json($error, 500);
        }

        $differences = [];
        for ($j = 0; $j < 4; $j++) {
            // Comparar cada elemento por color
            $st = 0;
            for ($i = 0; $i < 4; $i++) {
                if ($data2[$j] == $data1[$i]) {
                    $st = 1;
                }
            }
            // Comparar cada elemento por posición
            if($st == 1){
                if ($data2[$j] == $data1[$j]) {
                    $st = 2;
                }
            }
            $differences[] = $st;
        }
        return $differences;
    }

    public function show(Games $game)
    {
        return response()->json($game, 200);
    }



    public function destroy(Games $game)
    {
        $game->delete();
        return response()->json(null, 204);
    }
}
