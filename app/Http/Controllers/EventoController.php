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
                'nameEs' => $event['nameEs'],
                'nameEu' => $event['nameEu'],
                'typeEs' => $event['typeEs'],
                'priceEs' => self::validValue($event, 'priceEs'),
                'municipalityEs' => $event['municipalityEs'],
                'placeEs' => self::validValue($event, 'placeEs'),
                'startDate' => $event['startDate'],
                'openingHoursEs' => self::validValue($event, 'openingHoursEs'),
                'establishmentEs' => self::validValue($event, 'establishmentEs')

            ]);

        }

    }
    // Comprobamos si el campo es nulo y devolvemos el valor correspondiente
    public static function validValue($currentEvent, $value) {
        if (isset($currentEvent[$value])) return $currentEvent[$value];
        return "";
    }
}
