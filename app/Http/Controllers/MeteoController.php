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
        y estos variaban si se ralizaban varias consultas */
        self::$municipialities = [
        ['name'=>'ABALTZISKETA'],
        ['name'=>"ADUNA"],
        ['name'=>"AIA"],
        ['name'=>"AIZARNAZABAL"],
        ['name'=>"ALBIZTUR"],
        ['name'=>"ALEGIA"],
        ['name'=>"ALKIZA"],
        ['name'=>"ALTZAGA"],
        ['name'=>"ALTZO"],
        ['name'=>"AMEZKETA"],
        ['name'=>"ANDOAIN"],
        ['name'=>"ANOETA"],
        ['name'=>"ANTZUOLA"],
        ['name'=>"ARAMA"],
        ['name'=>"ARETXABAlETA"],
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
        ['name'=>"BIDANiA-GOIATZ"],
        ['name'=>"DEBA"],
        ['name'=>"DONOSTIA"],
        ['name'=>"EIBAR"],
        ['name'=>"ELDUAIN"],
        ['name'=>"ELGETA"],
        ['name'=>"ELGOIBAR"],
        ['name'=>"ERRENTERIA"],
        ['name'=>"ERREZIL"],
        ['name'=>"ESKORIATZA"]];
        /*
        ['name'=>"ESKIO-ITSASO"],
        ['name'=>"GABIRIA"],
        ['name'=>"GAINTZA"],
        ['name'=>"GAZTELU"],
        ['name'=>"GETARIA"],
        ['name'=>"HERNANI"],
        ['name'=>"HERNIALDE"],
        ['name'=>"HONDARRIBIA"],
        ['name'=>"IBARRA"],
        ['name'=>"IDIAZABAL"],
        ['name'=>"IKAZTEGIETA"],
        ['name'=>"IRUN"],
        ['name'=>"IRURA"],
        ['name'=>"ITSASONDO"],
        ['name'=>"LARRAUL"],
        ['name'=>"LASARTE-ORIA"],
        ['name'=>"LAZKAO"],
        ['name'=>"LEABURU"],
        ['name'=>"LEGAZPI"],
        ['name'=>"LEGORRETA"],
        ['name'=>"LEINTZ-GATZAGA"],
        ['name'=>"LEZO"],
        ['name'=>"LIZARTZA"],
        ['name'=>"MENDARO"],
        ['name'=>"MUTILOA"],
        ['name'=>"MUTRIKU"],
        ['name'=>"OIARTZUN"],
        ['name'=>"OLABERRIA"],
        ['name'=>"OÑATI"],
        ['name'=>"ORDIZIA"],
        ['name'=>"ORENDAIN"],
        ['name'=>"OREXA"],
        ['name'=>"ORIO"],
        ['name'=>"ORMAIZTEGI"],
        ['name'=>"PASAIA"],
        ['name'=>"SEGURA"],
        ['name'=>"SORALUZE"],
        ['name'=>"TOLOSA"],
        ['name'=>"URNIETA"],
        ['name'=>"URRETXU"],
        ['name'=>"USURBIL"],
        ['name'=>"VILLABONA"],
        ['name'=>"ZALDIBIA"],
        ['name'=>"ZARAUTZ"],
        ['name'=>"ZEGAMA"],
        ['name'=>"ZERAIN"],
        ['name'=>"ZESTOA"],
        ['name'=>"ZIZURKIL"],
        ['name'=>"ZUMAIA"],
        ['name'=>"ZUMARRAGA"]
        ]*/
    }


    private static function getApiData($municipiality) {
        $url = "api.openweathermap.org/data/2.5/weather?q=$municipiality,es&appid=";
        $url .= Config::get('services.openweathermap.key');;
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
                'weather' => $info->weather[0]->main
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
