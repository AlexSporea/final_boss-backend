<?php

namespace App\Http\Controllers;
use App\Models\Evento;
use App\Models\AdminEvento;

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

    public function adminEventos() {
        $data = [[],[]];
        $objsType = AdminEvento::select('entityEs')->distinct()->get();

        $objsType = json_encode($objsType);
        $objsType = json_decode($objsType);

        //Guardamos en data[0] los valores de entityEs
        foreach ($objsType as $obj) {
            array_push($data[0], $obj->entityEs);
        }

        dd($data[0]);
        
        //Guardamos en data[1] el nr de ventos por cada tipo
        foreach ($data[0] as $tipo) {
            array_push($data[1], Evento::where('typeEs', '=',$tipo)->get()->count());
        }
        
        $data['data'] = json_encode($data);
        return view('pages.adminEventos');
    }
}
