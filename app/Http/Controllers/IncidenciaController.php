<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Incidencia;
use App\Http\Controllers\EventoController;

class IncidenciaController extends Controller
{
    public function populateTable() {
        for ($i=1; $i < 4; $i++) { 
            self::insertData();
        }
    }

    private static function insertData() {
        
        $incidencesArray = self::accessApi();
        $incidencesArray = $incidencesArray->json();

        foreach ($incidencesArray['incidences'] as $incidence) {
            
            Incidencia::insert([
                'incidenceType' => $incidence['incidenceType'],
                'autonomousRegion' => $incidence['autonomousRegion'],
                'province' => $incidence['province'],
                'cause' => EventoController::validValue($incidence, 'cause'),
                'startDate' => EventoController::validValue($incidence, 'startDate')
            ]);
        }
    }

    private static function accessApi() {
        $random = rand(1, 100);
        $incidences = Http::get("https://api.euskadi.eus/traffic/v1.0/incidences/byYear/2020?_page=$random");

        return $incidences;
    }
}
