<?php

namespace App\Http\Controllers;

use App\Models\Explorer;
use App\Models\Item;
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

    public function update(Request $request, $id){
        
        $atualizarExplorer = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        
        $explorer = Explorer::findOrFail($id);

        $explorer->update($atualizarExplorer);

        return response()->json([
            'message' => 'Localização atualizada com sucesso, PARABÉNS! ',
            'explorer'=>$explorer,
            ]); 

    }

    public function addItems(Request $request){
        
        $addItem = $request->validate([
            'nome' => 'required|string|max:255',
            'valor' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'idExplorer' => 'required|integer',
        ]);


        $item = Item::create($addItem);

        return response()->json([
            'message' => 'Item adicionado ao inventário! ',
            'item' => $item,
        ]); 

    }

    public function trocaItems(Request $request){

        
    }

}
