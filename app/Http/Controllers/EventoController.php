<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use Illuminate\Support\Facades\Http;

class EventoController extends Controller
{
    public function populateTable() {
        $events = Http::get('https://api.euskadi.eus/culture/events/v1.0/events/byYear/2022/byProvince/20?_elements=20');

        $eventsArray = $events->json();

        foreach ($events['items'] as $event) {
        
            Evento::insert([
                'nameEs' => str_replace('"', '', $event['nameEs']),
                'typeEs' => $event['typeEs'],
                
            ]);

        }

    }

    public function getEventos() {
        $data = [[],[]];
        $objsType = Evento::select('typeEs')->distinct()->get();

        /*Convertimos la colección a json y el json a un array de objetos, 
        estos objetos tienen la propiedad typeEs*/
        $objsType = json_encode($objsType);
        $objsType = json_decode($objsType);

        //Guardamos en data[0] los valores de typeEs
        foreach ($objsType as $obj) {
            array_push($data[0], $obj->typeEs);
        }

        //Guardamos en data[1] el nr de ventos por cada tipo
        foreach ($data[0] as $tipo) {
            array_push($data[1], Evento::where('typeEs', '=',$tipo)->get()->count());
        }

        // Obtenemos el valor máximo el cual nos ayudará para el gráfico
        $data[2] = max($data[1]);

        return json_encode($data);
    }
}
