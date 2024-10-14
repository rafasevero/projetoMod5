<?php

namespace App\Http\Controllers;

use App\Models\Explorer;
use Illuminate\Http\Request;

class ExplorerController extends Controller
{
    public function store(Request $request){
        $array =  $request->validate([
            'nome' => 'required|string|max:255',
            'idade' =>'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $explorer = Explorer::create($array);

        
        return response()->json([
            'message' => 'Explorador adicionado com sucesso! ',
            'explorer'=>$explorer,
            ]); 
    }

    public function update(Request $request){

    }

}
