<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Http;

class MeteoController extends Controller
{
    private static $geoApiKey;
    private static $openWehatherApiKey;
    private static $geoApiUrl;
    private static $municipialities;
    
    /* A pesar de ser un forma poco segura de guardar las api keys, 
    no supone inconvenientes para este proyecto*/
    private static function setProperties() {
        self::$openWehatherApiKey = 'f29ab863193442997819ebbc2e084bc4';
        /* Al intentar acceder a los municipios con geoapi.es algunos nombres llevaban un _
        y estos variaban si se ralizaban varias consultas */
        self::$municipialities = [
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>'ABALTZISKETA'],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ADUNA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"AIA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"AIZARNAZABAL"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ALBIZTUR"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ALEGIA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ALKIZA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ALTZAGA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ALTZO"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"AMEZKETA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ANDOAIN"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ANOETA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ANTZUOLA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ARAMA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ARETXABAlETA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ARRASATE"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ASTEASU"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ASTIGARRAGA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ATAUN"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"AZKOITIA"]];
        
        /*,
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"AZPEITiA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"BALIARRAIN"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"BEASAIN"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"BEIZAMA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"BELAUNTZA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"BERASTEGI"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"BERGARA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"BERROBI"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"BIDANiA-GOIATZ"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"DEBA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"DONOSTIA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"EIBAR"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ELDUAIN"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ELGETA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ELGOIBAR"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ERRENTERIA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ERREZIL"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ESKORIATZA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ESKIO-ITSASO"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"GABIRIA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"GAINTZA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"GAZTELU"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"GETARIA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"HERNANI"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"HERNIALDE"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"HONDARRIBIA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"IBARRA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"IDIAZABAL"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"IKAZTEGIETA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"IRUN"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"IRURA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ITSASONDO"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"LARRAUL"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"LASARTE-ORIA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"LAZKAO"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"LEABURU"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"LEGAZPI"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"LEGORRETA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"LEINTZ-GATZAGA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"LEZO"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"LIZARTZA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"MENDARO"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"MUTILOA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"MUTRIKU"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"OIARTZUN"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"OLABERRIA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"OÑATI"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ORDIZIA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ORENDAIN"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"OREXA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ORIO"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ORMAIZTEGI"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"PASAIA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"SEGURA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"SORALUZE"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"TOLOSA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"URNIETA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"URRETXU"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"USURBIL"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"VILLABONA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ZALDIBIA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ZARAUTZ"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ZEGAMA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ZERAIN"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ZESTOA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ZIZURKIL"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ZUMAIA"],
        ['lat' => '', 'lon' => '', 'weather' => '', 'name'=>"ZUMARRAGA"]
        ];*/
    }


    private static function getApiData($municipiality) {
        $url = "api.openweathermap.org/data/2.5/weather?q=$municipiality,es&appid=" . self::$openWehatherApiKey;
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

    public static function getMeteoData() {
        
        self::setProperties();

        //Guardamos en la propiedad municipialities nombres, temporal y coordenadas
        for($i = 0; $i < count(self::$municipialities); $i++) {
            $info = self::getApiData(self::$municipialities[$i]["name"]);
            $info = json_decode($info);
            
            self::$municipialities[$i]["weather"] = $info->weather[0]->main;
            self::$municipialities[$i]["lon"] = $info->coord->lon;
            self::$municipialities[$i]["lat"] = $info->coord->lat;
            
        }

        return self::$municipialities;
        
    }


}
