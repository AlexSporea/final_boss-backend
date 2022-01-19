<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use Illuminate\Support\Facades\Http;

class EventoController extends Controller
{
    private static $data;

    public function populateTable() {
        for ($i=1; $i < 4; $i++) { 
            self::insertData();
        }
    }
    public function insertData() {

        $eventsArray = self::accessApi();
        $eventsArray = $eventsArray->json();

        foreach ($eventsArray['items'] as $event) {
            Evento::insert([
                'nameEs' => str_replace('"', '', $event['nameEs']),
                'typeEs' => $event['typeEs'],
                'municipalityEs' => $event['municipalityEs'],
                'startDate' => self::changeDateFormat($event['startDate'])
            ]);
        }
    }

    public static function changeDateFormat($originalDate) {
        $eventDate = strtotime($originalDate);
        $eventDate = date("Y-m-d", $eventDate);

        return $eventDate;
    }

    private static function accessApi() {
        $random = rand(1, 100);
        $adminEvents = Http::get("https://api.euskadi.eus/culture/events/v1.0/events/byYear/2022?_elements=20&_page=$random");

        return $adminEvents;
    }

    public function getEventos() {
        $eventos = Evento::select('typeEs')->distinct()->get();

        /*Convertimos la colección a json y el json a un array de objetos, 
        estos objetos tienen la propiedad typeEs*/
        $eventos = json_encode($eventos);
        $eventos = json_decode($eventos);

        self::generarJson($eventos);

        // Obtenemos el valor máximo el cual nos ayudará para el gráfico
        self::$data[2] = max(self::$data[1]);

        return json_encode(self::$data);

    }

    private function generarJson($array) {
        self::$data = [[],[]];
        
        //Guardamos en data[0] los valores de typeEs
        foreach ($array as $obj) {
            array_push(self::$data[0], $obj->typeEs);
        }

        //Guardamos en data[1] el nr de ventos por cada tipo
        foreach (self::$data[0] as $tipo) {
            array_push(self::$data[1], Evento::where('typeEs', '=',$tipo)->get()->count());
        }

    }

}
