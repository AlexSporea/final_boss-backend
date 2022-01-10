<?php

namespace App\Http\Controllers;
use App\Models\Evento;
use App\Models\AdminEvento;
use App\Models\Incidencia;
use App\Http\Controllers\EventoController;
class PageController extends Controller
{
    /**
     * Display icons page
     *
     * @return \Illuminate\View\View
     */
    public function icons()
    {
        return view('pages.icons');
    }

    /**
     * Display maps page
     *
     * @return \Illuminate\View\View
     */
    public function maps()
    {
        return view('pages.maps');
    }

    /**
     * Display tables page
     *
     * @return \Illuminate\View\View
     */
    public function tables()
    {
        return view('pages.tables');
    }

    /**
     * Display notifications page
     *
     * @return \Illuminate\View\View
     */
    public function notifications()
    {
        return view('pages.notifications');
    }

    /**
     * Display rtl page
     *
     * @return \Illuminate\View\View
     */
    public function rtl()
    {
        return view('pages.rtl');
    }

    /**
     * Display typography page
     *
     * @return \Illuminate\View\View
     */
    public function typography()
    {
        return view('pages.typography');
    }

    /**
     * Display upgrade page
     *
     * @return \Illuminate\View\View
     */
    public function upgrade()
    {
        return view('pages.upgrade');
    }

    //Mostramos los eventos
    public function eventos() {
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
        
        $data['data'] = json_encode($data);
        
        return view('pages.eventos', $data);
    }

    // Mostramos los eventos admin.
    public function adminEventos() {
        $data = [[],[]];
        $objsType = AdminEvento::select('adjudicatorEs')->distinct()->get();

         /*Convertimos la colección a json y el json a un array de objetos, 
        estos objetos tienen la propiedad adjudicatorEs*/
        $objsType = json_encode($objsType);
        $objsType = json_decode($objsType);

        /*Guardamos en data[0] los valores de adjudicatorEs,
        usando solmante un trozo del array objsType*/
        for($i = 16; $i < 26; $i++) {
            array_push($data[0], $objsType[$i]->adjudicatorEs);
        }

        
        //Guardamos en data[1] el nr de eventos por adjudicador
        foreach ($data[0] as $tipo) {
            array_push($data[1], AdminEvento::where('adjudicatorEs', '=',$tipo)->get()->count());
        }
        
        $data['data'] = json_encode($data);
        
        return view('pages.adminEventos', $data);
    }

    // Mostramos las incidencias
    public function incidencias() {
        $data = [[],[]];
        $objsType = Incidencia::select('province')->distinct()->get();

         /*Convertimos la colección a json y el json a un array de objetos, 
        estos objetos tienen la propiedad incidenceType*/
        $objsType = json_encode($objsType);
        $objsType = json_decode($objsType);

        dd($objsType);

        //*Guardamos en data[0] los valores de incidenceType
        foreach ($objsType as $obj) {
            array_push($data[0], $obj->incidenceType);
        }

        
        //Guardamos en data[1] el nr de incidencias por tipo
        foreach ($data[0] as $tipo) {
            array_push($data[1], Incidencia::where('incidenceType', '=',$tipo)->get()->count());
        }
        
        $data['data'] = json_encode($data);
        
        return view('pages.adminEventos', $data);
    }

    // Mostramos información meteorológica
    public function meteo() {
        $data['data'] = json_encode(MeteoController::getMeteoData());
        
        
        return view('pages.meteo', $data);
    }
}
