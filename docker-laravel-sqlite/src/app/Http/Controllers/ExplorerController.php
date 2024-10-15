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
        
        $request->validate([
            'explorers1_Id' => 'required|exists:explorers.id',
            'explorers2_Id' => 'required|exists:explorers.id',
            'item1_Id' => 'required|exists:item.id',
            'item2_Id' => 'required|exists:item.id',
        ]);
        
        $explorers1 = Explorer::find($request->explorers1_Id);
        $explorers2 = Explorer::find($request->explorers2_Id);
        $itemsExplorer1 = Item::whereIn('id', $request->itemExplorer1)->get();
        $itemsExplorer2 = Item::whereIn('id', $request->itemExplorer2)->get();

        $explorer1Total = $itemsExplorer1->sum('valor');
        $explorer2Total = $itemsExplorer2->sum('valor');

        if ($explorer1Total != $explorer2Total) {
            return response()->json([
                'message' => "A troca é impossível, há uma desigualdade de valores!"
            ]);
        }


    if ($itemsExplorer1->explorer_id !== $explorers1->id) {
        return response()->json(['error' => 'O item 1 não é do explorer 1.'], 400);
    }

    if ($itemsExplorer2->explorer_id !== $explorers2->id) {
        return response()->json(['error' => 'o item 2 não é do explorer 2.'], 400);
    }
    



    $itemsExplorer1->explorer_id = $explorers2->id;
    $itemsExplorer2->explorer_id = $explorers1->id;

    $itemsExplorer1->save();
    $itemsExplorer2->save();

    return response()->json([
        'message' => 'A troca foi feita com sucesso!'
    ]);    


    }

}
