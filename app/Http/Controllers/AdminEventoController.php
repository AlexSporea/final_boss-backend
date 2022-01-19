<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminEvento;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\EventoController;

class AdminEventoController extends Controller
{
    public function populateTable() {
        for ($i=1; $i < 4; $i++) { 
            self::insertData();
        }
    }

    private static function insertData() {
        
        $adminEventsArray = self::accessApi();
        $adminEventsArray = $adminEventsArray->json();

        foreach ($adminEventsArray['events'] as $adminEvent) {
        
            AdminEvento::insert([
                'nameEs' => $adminEvent['nameEs'],
                'adjudicatorEs' => $adminEvent['adjudicatorEs'],
                'startDate' => EventoController::changeDateFormat($adminEvent['startDate'])
            ]);
        }
    }

    private static function accessApi() {
        $random = rand(1, 4000);
        $adminEvents = Http::get("https://api.euskadi.eus/administration/events/v1.0/events?_page=$random");

        return $adminEvents;
    }

    public function getAdminEventos() {
        $data = [[],[]];
        $objsType = AdminEvento::select('adjudicatorEs')->distinct()->get();

         /*Convertimos la colección a json y el json a un array de objetos, 
        estos objetos tienen la propiedad adjudicatorEs*/
        $objsType = json_encode($objsType);
        $objsType = json_decode($objsType);

        /*Guardamos en data[0] los valores de adjudicatorEs,
        usando solmante un trozo del array objsType*/
        foreach ($objsType as $obj) {
            array_push($data[0], $obj->adjudicatorEs);
        }

        //Guardamos en data[1] el nr de eventos por adjudicador
        foreach ($data[0] as $tipo) {
            array_push($data[1], AdminEvento::where('adjudicatorEs', '=',$tipo)->get()->count());
        }
        
        return json_encode($data);
    }
}
