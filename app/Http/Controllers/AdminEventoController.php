<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminEvento;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\EventoController;

class AdminEventoController extends Controller
{
    public function populateTable() {

        $adminEvents = Http::get('https://api.euskadi.eus/administration/events/v1.0/events?_page=1');
        
        $adminEventsArray = $adminEvents->json();

        foreach ($adminEventsArray['events'] as $adminEvent) {
        
            AdminEvento::insert([
                'adjudicatorEs' => $adminEvent['adjudicatorEs'],
                'adjudicatorEu' => $adminEvent['adjudicatorEu'],
                'authorityEs' => EventoController::validValue($adminEvent, 'authorityEs'),
                'descriptionEs' => $adminEvent['descriptionEs'],
                'entityEs' => $adminEvent['entityEs'],
                'nameEs' => $adminEvent['nameEs'],
                'startDate' => $adminEvent['startDate'],
                'typeEs' => $adminEvent['typeEs']

            ]);

        }

    }
}
