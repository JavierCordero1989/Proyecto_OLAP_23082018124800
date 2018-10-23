<?php

namespace App\Http\Controllers;

use App\EncuestaGraduado as Entrevista;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estados_temp = Entrevista::totalesPorEstado()->get();

        $estados = [];

        foreach($estados_temp as $key => $value) {
            $estados[$value->estado] = $value->total;
        }

        $estados['TOTAL DE ENTREVISTAS'] = Entrevista::totalDeEncuestas();

        return view('home', compact('estados'));
    }
}
