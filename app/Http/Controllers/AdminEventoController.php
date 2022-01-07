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
                'adjudicatorEs' => $adminEvent['adjudicatorEs'],
                'adjudicatorEu' => $adminEvent['adjudicatorEu'],
                'authorityEs' => EventoController::validValue($adminEvent, 'authorityEs'),
                'descriptionEs' => $adminEvent['descriptionEs'],
                'entityEs' => EventoController::validValue($adminEvent, 'entityEs'),
                'nameEs' => $adminEvent['nameEs'],
                'startDate' => $adminEvent['startDate'],
                'typeEs' => $adminEvent['typeEs']
            ]);
        }
    }

    private static function accessApi() {
        $random = rand(1, 4000);
        $adminEvents = Http::get("https://api.euskadi.eus/administration/events/v1.0/events?_page=$random");

        return $adminEvents;
    }
}
