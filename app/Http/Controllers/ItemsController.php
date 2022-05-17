<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Items;
use App\Models\Pedimentos;
use App\Models\Config;

class ItemsController extends Controller
{
    public function indexItems(Request $request){
        $items = Items::where("status","=",true)->get();
        return view('items',['items'=>$items]);
    }
    public function facturaItems(Request $request){
        $items = Items::where("status","=",true)->get();
        return view('factura',['items'=>$items]);
    }
    public function updateItems(Request $request)
    {
        $url = Config::first();
        $response = Http::get($url->api_get_books);
        $body = json_decode($response->body());
        $body = "[".$body->details->output."]";
        $body = json_decode($body);
        foreach ($body as $key => $value) {
            $pedimento = $value->Pedimento;
            if ($value->Pedimento != null) {
                $pedimento = str_replace(" ","  ",$pedimento);
            }
            $pedimento_check = Pedimentos::where('pedimento', '=', $pedimento)->first();
            if ($pedimento_check === null) {
               $pedimento_id = Pedimentos::insertGetId(
                    [
                        'pedimento' => $pedimento 
                    ]
                );
            }else{
                $pedimento_id = $pedimento_check->id;
            }
            
          
                if($value->No_Serie != null){
                    if (is_array($value->No_Serie)) {
                        $No_Serie = implode(",", $value->No_Serie);
                    }else{
                        $No_Serie = $value->No_Serie;
                    }                 
                }else{
                    $No_Serie = $value->No_Serie;
                }
                $verificarExistencias = Items::where('IDItem', '=', $value->IDItem)->where('Pedimento', '=', $pedimento)->first();
                if ($verificarExistencias === null) {
                    if ($pedimento == null) {
                        $pedimento = "";
                    }else{
                        $pedimento = $pedimento;
                    }
                    $item = Items::insertGetId(
                        [
                            'id_pedimento' => $pedimento_id,
                            'IDItem' => $value->IDItem,
                            'Nombre' => $value->Nombre,
                            'Sku' => $value->Sku,
                            'Cantidad' => $value->Cantidad,
                            'No_Serie' => $No_Serie,
                            'Pedimento' => $pedimento,
                            'FechaPedimento' => $value->FechaPedimento,
                            'Aduana' => $value->Aduana,
                            'status' => true
                        ]
                    );
                }else{
                    $verificarExistencias->Cantidad = $value->Cantidad;
                    $verificarExistencias->No_Serie = $No_Serie;
                    $verificarExistencias->save();
                }
               
            

        }
        return "Success";
    }
    public function obtenerDatos(Request $request)
    {
        $response = Http::get("https://www.zohoapis.com/crm/v2/functions/get_salesorder_id/actions/execute?auth_type=apikey&zapikey=1003.710714c9ec523b73f9eddbfd480d15d8.20a5c8ab494f3714d32eff3d95dc5bad&id=".$request->invoice_number);
        $body = json_decode($response->body());
        $body = $body->details->output;
        $body = json_decode($body);
       
        return $body;
    }
    public function verificarItem(Request $request){
        $item = Items::where("status","=",true)->where("Nombre","=",$request->item)->get();
        return $item;
    }
    public function getItems(Request $request){
        $item = Items::where("status","=",true)->get();
        return $item;
    }
    public function getItem(Request $request){
        $id = $request->id;
        $item = Items::where("IDItem","=",$id)->first();
        return $item;
    }
    public function update(Request $request){
         $response = Http::get("https://www.zohoapis.com/crm/v2/functions/get_invoice_id/actions/execute?auth_type=apikey&zapikey=1003.710714c9ec523b73f9eddbfd480d15d8.20a5c8ab494f3714d32eff3d95dc5bad&id=".$request->id);
        $body = json_decode($response->body());
        $body = "[".$body->details->output."]";
        $body = json_decode($body);
        $items = $body[0]->invoice->line_items;
        foreach ($items as $key => $value) {
            $verificarExistencias = Items::where('IDItem', '=', $value->item_id)->where('Pedimento', '=', $value->item_custom_fields[2]->value)->first();
            if ($verificarExistencias != null) {
                $existencias = intval($verificarExistencias->Cantidad);
                $quantity = intval($value->quantity);
                $cantidad = $existencias + $quantity;
                $verificarExistencias->Cantidad = $cantidad;
                $verificarExistencias->save();
            }
        }
        
        return "success";
    }
    
    public function sendFactura(Request $request){
        $response = Http::get("https://www.zohoapis.com/crm/v2/functions/create_package/actions/execute?auth_type=apikey&zapikey=1003.710714c9ec523b73f9eddbfd480d15d8.20a5c8ab494f3714d32eff3d95dc5bad".$request->url);
        $body = json_decode($response->body());
        $body = $body->details->output;
        $body = json_decode($body);
        return $body;
        
    }
    public function getPedimento(Request $request){
        $serial = $request->serial;
        if ($request->serial == "") {
            $serial = Items::where('Sku','=',$request->sku)->first();
            return $serial;
        }else{
             $serial = Items::where('No_Serie','like','%'.$serial.'%')->first();
            return $serial;
        }
    }
}
