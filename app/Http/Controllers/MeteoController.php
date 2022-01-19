<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\Meteo;

class MeteoController extends Controller
{
    private static $geoApiUrl;
    private static $municipialities;
    
    private static function setProperties() {
        /* Al intentar acceder a los municipios con geoapi.es algunos nombres llevaban un _
        y estos varían si se realizan varias consultas */
        self::$municipialities = [
        ['name'=>'ABALTZISKETA'],
        ['name'=>"ADUNA"],
        ['name'=>"AIZARNAZABAL"],
        ['name'=>"ALEGIA"],
        ['name'=>"ALTZAGA"],
        ['name'=>"ALTZO"],
        ['name'=>"ANDOAIN"],
        ['name'=>"ANOETA"],
        ['name'=>"ANTZUOLA"],
        ['name'=>"ARAMA"],
        ['name'=>"ARRASATE"],
        ['name'=>"ASTEASU"],
        ['name'=>"ASTIGARRAGA"],
        ['name'=>"ATAUN"],
        ['name'=>"AZKOITIA"],
        ['name'=>"AZPEITiA"],
        ['name'=>"BALIARRAIN"],
        ['name'=>"BEASAIN"],
        ['name'=>"BEIZAMA"],
        ['name'=>"BELAUNTZA"],
        ['name'=>"BERASTEGI"],
        ['name'=>"BERGARA"],
        ['name'=>"BERROBI"],
        ['name'=>"DEBA"],
        ['name'=>"DONOSTIA"],
        ['name'=>"EIBAR"],
        ['name'=>"ERRENTERIA"],
        ['name'=>"HERNANI"],
        ['name'=>"HONDARRIBIA"],
        ['name'=>"IRUN"],
        ['name'=>"OIARTZUN"],
        ['name'=>"OÑATI"],
        ['name'=>"ORIO"],
        ['name'=>"PASAIA"],
        ['name'=>"TOLOSA"],
        ['name'=>"URNIETA"],
        ['name'=>"ZARAUTZ"],
        ['name'=>"ZUMAIA"],
        ['name'=>"ZUMARRAGA"]];
        
    }


    private static function getApiData($municipiality) {
        $url = "api.openweathermap.org/data/2.5/weather?q=$municipiality,es&lang=es&units=metric&appid=";
        // Añadimos la clave
        $url .= Config::get('services.openweathermap.key');
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);

        curl_close($curl);
        
        return $response;
        
    }

    public static function populateTable() {
        
        self::setProperties();

        //Guardamos en la propiedad municipialities nombres, temporal y coordenadas
        for($i = 0; $i < count(self::$municipialities); $i++) {
            $info = self::getApiData(self::$municipialities[$i]["name"]);
            $info = json_decode($info);
            
            Meteo::insert([
                'nameEs' => self::$municipialities[$i]["name"],
                'lon' => $info->coord->lon,
                'lat' => $info->coord->lat,
                'weather' => $info->weather[0]->main,
                'description' => $info->weather[0]->description,
                'temp' => $info->main->temp,
                'feels_like' => $info->main->feels_like,
                'humidity' => $info->main->humidity
            ]);
            
        }
        
    }

    public function getMeteo() {
        $data = Meteo::all();
        
        //Convertimos la colección a json
        $data = json_encode($data);
        
        return $data;
    }


}
