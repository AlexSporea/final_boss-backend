<?php

namespace App\Http\Controllers;
use App\Models\Evento;

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
    public function eventos()
    {
        $eventos = Evento::all();
        $data = [];
        $data['category'] = Evento::select('typeEs')->distinct()->get();

        foreach($eventos as $evento) {
            $data['label'][] = $evento->nameEs;
            $data['data'][] = $evento->typeEs;
        }

        dd($data);
        $data['data'] = json_encode($data);

        return view('pages.eventos', $data);
    }
}
