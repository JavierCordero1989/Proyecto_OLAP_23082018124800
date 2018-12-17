<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Auth;
use App\ObservacionesGraduado;
use App\DatosCarreraGraduado;
use Illuminate\Http\Request;
use App\TiposDatosCarrera;
use App\EncuestaGraduado;
use App\ContactoGraduado;
use App\DetalleContacto;
use App\Universidad;
use App\Asignacion;
use App\Disciplina;
use App\Agrupacion;
use Carbon\Carbon;
use App\Carrera;
use App\Estado;
use App\Sector;
use App\Grado;
use App\Area;
use App\User;
use Flash;
use DB;

class EncuestaGraduadoController extends Controller
{
    public function index() {
        if(EncuestaGraduado::totalDeEncuestas()->count() <= 0) {
            Flash::info('Aún no existen encuestas en el sistema, contacte con el Administrador para más información');
            return redirect(url('home'));
        }

        session()->forget('ids_encuestas_filtradas');

        $encuestas = EncuestaGraduado::listaDeGraduados()->orderBy('identificacion_graduado', 'ASC')->paginate(25);
        return view('encuestas_graduados.index')->with('encuestas', $encuestas);
    }

    /* FUNCION QUE FILTRA LAS ENCUESTAS POR LOS DATOS QUE EL USUARIO INGRESE EN LOS CAMPOS */
    public function filtro_encuestas(Request $request) {
        // se sacan todas las encuestas de la base de datos.
        $encuestas = EncuestaGraduado::listaDeGraduados();

        /* COMPRUEBA QUE LA IDNETIFICACION DEL GRADUADO TENGA DATOS */
        if(isset($request->identificacion_graduado)) {
            //buscar por identificacion del graduado
            $encuestas = $encuestas->where('identificacion_graduado', 'like', '%'.$request->identificacion_graduado.'%');
        }
        /* COMPRUEBA QUE EL NOMBRE TENGA DATOS */
        if(isset($request->nombre_completo)) {
            //buscar por el nombre
            $encuestas = $encuestas->where('nombre_completo', 'like', '%'.$request->nombre_completo.'%');
        }
        /* COMPRUEBA QUE EL SEXO TENGA DATOS */
        if(isset($request->sexo)) {
            //buscar por el sexo
            $encuestas = $encuestas->where('sexo', $request->sexo);
        }
        /* COMPRUEBA QUE EL CODIGO DE LA CARRERA TENGA DATOS, LO QUE VIENE ES UN NOMBRE */
        if(isset($request->codigo_carrera)) {
            //buscar primero las carreras que coincidan con los nombres para obtener los codigos
            $carreras = Carrera::buscarPorNombre($request->codigo_carrera)->pluck('id');

            //buscar las encuestas que coincidan con los codigos encontrados
            $encuestas = $encuestas->whereIn('codigo_carrera', $carreras);
        }
        /* COMPRUEBA QUE EL CODIGO DE LA UNIVERSIDAD TENGA DATOS, LO QUE VIENE ES UN NOMBRE */
        if(isset($request->codigo_universidad)) {
            //buscar primero las carreras que coincidan con los nombres para obtener los codigos
            $universidades = Universidad::buscarPorNombre($request->codigo_universidad)->pluck('id');

            //buscar las encuestas que coincidan con los codigos encontrados
            $encuestas = $encuestas->whereIn('codigo_universidad', $universidades);
        }
        /* COMPRUEBA QUE EL CODIGO DE LA AGRUPACION TENGA DATOS, LO QUE VIENE ES EL CÓDIGO */
        if(isset($request->codigo_agrupacion)) {
            // buscar primero el ID de la base de datos de la agrupacion con el código
            $agrupacion = Agrupacion::buscarPorCodigo($request->codigo_agrupacion)->first();

            if(!empty($agrupacion)) {
                // busca las encuestas que coincidan con la agrupación seleccionada.
                $encuestas = $encuestas->where('codigo_agrupacion', $agrupacion->id);
            }
            else {
                // meter un dato para que no devuelva nada
                $encuestas = $encuestas->where('codigo_agrupacion', '');
            }
        }
        /* COMPRUEBA QUE EL CODIGO DEL GRADO TENGA DATOS, LO QUE VIENE ES EL CÓDIGO */
        if(isset($request->codigo_grado)) {
            $profesorado = null;
            $diplomado = null;
            $bachillerato = null;
            $licenciatura = null;

            // se setean las disciplinas, dependiendo de las que el usuario ingresó.
            switch($request->codigo_grado) {
                case 3:
                    $profesorado = Grado::buscarPorCodigo(2)->first();
                    $diplomado = Grado::buscarPorCodigo(3)->first();
                break;

                case 4:
                    $bachillerato = Grado::buscarPorCodigo($request->codigo_grado)->first();
                break;

                case 5:
                    $licenciatura = Grado::buscarPorCodigo($request->codigo_grado)->first();
                break;
            }

            // dependiendo de cual dato no sea nulo, entrará a uno de los tres if siguientes para realizar el filtro.
            if(!is_null($profesorado) && !is_null($diplomado)) {
                $encuestas = $encuestas->whereIn('codigo_grado', [$profesorado->id, $diplomado->id]);
            }
            else if(!is_null($bachillerato)) {
                $encuestas = $encuestas->where('codigo_grado', $bachillerato->id);
            }
            else if(!is_null($licenciatura)) {
                $encuestas = $encuestas->where('codigo_grado', $licenciatura->id);
            }
            else {
                $encuestas = $encuestas->where('codigo_grado', '');
            }
        }
        /* COMPRUEBA QUE EL CODIGO DE LA DISCIPLINA TENGA DATOS, LO QUE VIENE ES EL NOMBRE */
        if(isset($request->codigo_disciplina)) {
            //buscar primero las carreras que coincidan con los nombres para obtener los codigos
            $disciplinas = Disciplina::buscarPorDescriptivo($request->codigo_disciplina)->pluck('id');

            //buscar las encuestas que coincidan con los codigos encontrados
            $encuestas = $encuestas->whereIn('codigo_disciplina', $disciplinas);
        }
        /* COMPRUEBA QUE EL CODIGO DEL ÁREA TENGA DATOS, LO QUE VIENE ES EL NOMBRE */
        if(isset($request->codigo_area)) {
            //buscar primero las carreras que coincidan con los nombres para obtener los codigos
            $areas = Area::buscarPorDescriptivo($request->codigo_area)->pluck('id');

            //buscar las encuestas que coincidan con los codigos encontrados
            $encuestas = $encuestas->whereIn('codigo_area', $areas);
        }
        /* COMPRUEBA QUE EL TIPO DE CASO TENGA DATOS, LO QUE VIENE ES EL TIPO DE CASO COMO TAL */
        if(isset($request->tipo_de_caso)) {
            //buscar por el tipo de caso
            $encuestas = $encuestas->where('tipo_de_caso', $request->tipo_de_caso);
        }
        /* COMPRUEBA QUE EL ESTADO TENGA DATOS, LO QUE VIENE ES EL ID DEL ESTADO */
        if(isset($request->estado)) {
            $estado = Estado::find($request->estado);
            
            if(!empty($estado)) {
                $ids_graduados = Asignacion::where('id_estado', $estado->id)->pluck('id_graduado');
    
                $encuestas = $encuestas->whereIn('id', $ids_graduados);
            }
        }
        /* COMPRUEBA QUE EL CONTACTO TENGA DATOS, LO QUE VIENE ES UN CORREO O UN NÚMERO */
        if(isset($request->contacto)) {
            $ids = [];

            foreach($encuestas->get() as $encuesta) {
                $contactos = $encuesta->contactos;
                foreach($contactos as $c) {
                    $detalle = $c->detalle;
                    foreach($detalle as $d) {
                        if($d->contacto == $request->contacto) {
                            $ids[] = $encuesta->id;
                        }
                    }
                }
            }

            $encuestas = $encuestas->whereIn('id', $ids);
        }
        
        $ids_encuestas = array();

        foreach($encuestas->get() as $encuesta) {
            $ids_encuestas[] = $encuesta->id;
        }

        /* DE LAS ENTREVISTAS OBTENIDAS, SE PAGINAN DE 15 EN 15, Y SE ORDENAN ASCENDENTEMENTE POR EL ID */
        $encuestas = $encuestas->orderBy('id', 'ASC')->paginate(15);


        // se guardan los ids, para cuando se quiera descargar el reporte en excel.
        session()->put('ids_encuestas_filtradas', $ids_encuestas);

        return view('encuestas_graduados.index')->with('encuestas', $encuestas);
    }

    public function ver_otras_carreras($ids) {
        $ids = explode('-', $ids);
        
        $encuestas = EncuestaGraduado::whereIn('id', $ids)->orderBy('identificacion_graduado', 'ASC')->paginate(25);

        return view('encuestas_graduados.index')->with('encuestas', $encuestas);
    }

    /* METODO USADO PARA PAGINAR CON VUE.JS, NO FUNCIONO DE ACUERDO A LAS ESPECTATIVAS */
    // public function listaDeEncuestas(Request $request) {
    //     $encuestas = EncuestaGraduado::listaDeGraduados()->whereNull('deleted_at')->orderBy('id', 'ASC')->with('contactos')->paginate(25);
        
    //     //NUEVA FORMA DE OBTENER LAS ENCUESTAS
    //     // $encuestas = EncuestaGraduado::listaDeGraduados()->whereNull('deleted_at')->with('contactos')->get();

    //     foreach ($encuestas as $encuesta) {
    //         $encuesta->changeCodesByNames();
    //     }

    //     $paginacion = [
    //         'pagination' => [
    //             'total'=>$encuestas->total(),
    //             'current_page'=>$encuestas->currentPage(),
    //             'per_page'=>$encuestas->perPage(),
    //             'last_page'=>$encuestas->lastPage(),
    //             'from'=>$encuestas->firstItem(),
    //             'to'=>$encuestas->lastPage(),
    //         ],
    //         'encuestas' => $encuestas
    //     ];

    //     return $paginacion;
    //     // return view('encuestas_graduados.index', compact('paginacion'));
    // }

    public function edit($id) {
        $encuesta = EncuestaGraduado::find($id);

        if(empty($encuesta)) {
            Flash::overlay('No se ha encontrado la entrevista solicitada', 'Error en la búsqueda')->error();
            return redirect(route('encuestas-graduados.index'));
        }

        $datos_academicos = array();

        $datos_academicos['sexo'] = array('M'=>'HOMBRE', 'F'=>'MUJER', 'SC'=>'SIN CLASIFICAR');
        $datos_academicos['carreras'] = Carrera::allData()->pluck('nombre', 'id');
        $datos_academicos['universidades'] = Universidad::allData()->pluck('nombre', 'id');
        $datos_academicos['grados'] = Grado::allData()->pluck('nombre', 'id');
        $datos_academicos['disciplinas'] = Disciplina::all()->pluck('descriptivo', 'id');
        $datos_academicos['areas'] = Area::all()->pluck('descriptivo', 'id');
        $datos_academicos['agrupaciones'] = Agrupacion::allData()->pluck('nombre', 'id');
        $datos_academicos['sectores'] = Sector::allData()->pluck('nombre', 'id');
        $datos_academicos['tipos'] = array('CENSO'=>'CENSO','MUESTRA'=>'MUESTRA','SUSTITUCION'=>'SUSTITUCION');

        return view('encuestas_graduados.editar-encuesta')->with('encuesta', $encuesta)->with('datos_academicos', $datos_academicos);
    }

    public function update($id, Request $request) {
        $encuesta = EncuestaGraduado::find($id);

        if(empty($encuesta)) {
            Flash::overlay('No se ha encontrado la entrevista solicitada', 'Error en la búsqueda')->error();
            return redirect(route('encuestas-graduados.index'));
        }

        // dd($request->all());

        $encuesta->update($request->all());

        Flash::success('Los datos de la encuesta han sido actualizados correctamente.');
        return redirect(route('encuestas-graduados.index'));
    }

    public function destroy($id) {
        $encuesta = EncuestaGraduado::find($id);

        if(empty($encuesta)) {
            Flash::error('No existe la entrevista que intenta eliminar.');
            return redirect(route('encuestas-graduados.index'));
        }

        $datoViejo = $encuesta->deleted_at;

        /* Se modifica el dato de la fecha de eliminacion, para que no aparezca más */
        $encuesta->deleted_at = carbon::now();
        $encuesta->save();

        //En la tabla de bitácora se registra el cambio
        $bitacora = [
            'transaccion'            =>'D',
            'tabla'                  =>'tbl_graduados',
            'id_registro_afectado'   =>$encuesta->id,
            'dato_original'          =>$datoViejo,
            'dato_nuevo'             =>('Se ha eliminado el registro de la encuesta de la BD. Nuevo dato: deleted_at => '.$encuesta->deleted_at),
            'fecha_hora_transaccion' =>Carbon::now(),
            'id_usuario'             =>Auth::user()->id,
            'created_at'             =>Carbon::now()
        ];

        DB::table('tbl_bitacora_de_cambios')->insert($bitacora);

        Flash::success('Se ha eliminado la encuesta del sistema.');
        return redirect(route('encuestas-graduados.index'));
    }

    public function create() {
        //Array con los datos del sexo
        $sexo = [
            ''=>'- - - SELECCIONE - - -',
            'M' => 'HOMBRE',
            'F'=>'MUJER',
            'ND'=>'NO DISPONIBLE'
        ];

        // Array con los datos de los grados
        $grados = Grado::allData()->pluck('nombre', 'id');
        $grados->prepend('- - - SELECCIONE - - -', '');

        // Array con los datos de las areas
        $areas = Area::pluck('descriptivo', 'id');
        $areas->prepend('- - - SELECCIONE - - -', '');

        // Array con los datos de agrupacion
        $agrupaciones = Agrupacion::allData()->pluck('nombre', 'id');
        $agrupaciones->prepend('- - - SELECCIONE - - -', '');

        // Array con los datos de los sectores
        // $sectores = Sector::allData()->pluck('nombre', 'id');
        // $sectores->prepend('- - - SELECCIONE - - -', '');

        // Array con los tipos de caso posibles
        $tipos_caso = [
            ''=>'- - - SELECCIONE - - -',
            'MUESTRA'=>'MUESTRA',
            'CENSO'=>'CENSO',
            'SUSTITUCION'=>'SUSTITUCION'
        ];

        $data = [
            'sexo'=>$sexo,
            'grados'=>$grados,
            'areas'=>$areas,
            'agrupaciones'=>$agrupaciones,
            // 'sectores'=>$sectores,
            'tipos_caso'=>$tipos_caso
        ];

        return view('encuestas_graduados.agregar-nueva-encuesta', compact('data'));
    }

    public function ajaxObtenerDisciplinasPorArea(Request $request){
        if($request->ajax()) {

        }
    }

    public function store(Request $request) {

        dd($request->all());
        /* VALIDAR TODOS LOS CAMPOS UNICOS DE LA BD */
        $encuesta = EncuestaGraduado::where('token', $request->token)->first();

        if(!empty($encuesta)) {
            Flash::error('El token que ingresó ya se encuentra registrado.');
            return back();
        }

        $encuesta = EncuestaGraduado::create($request->all());

        // dd($encuesta);

        Flash::success('Encuesta agregada con éxito al sistema.');
        return back();
    }

    public function agregarContacto($id_encuesta) {
        return view('encuestas_graduados.agregar-contacto')->with('id_encuesta', $id_encuesta);
    }

    public function guardarContacto($id_encuesta, Request $request) {

        $contacto = ContactoGraduado::create([
            'identificacion_referencia' => $request->identificacion_referencia,
            'nombre_referencia'         => $request->nombre_referencia,
            'parentezco'                => $request->parentezco,
            'id_graduado'               => $id_encuesta,
            'created_at'                => \Carbon\Carbon::now()
        ]);

        $contacto->agregarDetalle($request->informacion_contacto, $request->observacion_contacto);

        Flash::success('Se ha guardado correctamente la nueva información de contacto.');
        return redirect(route('encuestas-graduados.index'));
    }

    /** Obtiene todos los datos existentes por carrera, universidad, grado, disciplina y area,
     * para poder mostrarlos en un combobox para que el encargado de asignar asl encuestas
     * pueda seleccionar todos los filtros adecuados.
    */
    public function asignar($id_supervisor, $id_encuestador) {
        $user = User::find($id_encuestador);

        if(empty($user)) {
            Flash::overlay('No se ha encontrado un usuario con el ID especificado', 'Error en la búsqueda')->error();
            return redirect(url('/home'));
        }
        $rol_usuario = $user->hasRole('Encuestador') ? 'Encuestador' : 'Supervisor';

        if(EncuestaGraduado::totalDeEncuestas()->count() <= 0) {
            Flash::info('Aún no existen encuestas en el sistema, contacte con el Administrador para más información');

            if($rol_usuario == 'Encuestador') {
                return redirect(route('encuestadores.index'));
            }
            else {
                return redirect(route('supervisores.index'));
            }
        }

        $id_grado =      TiposDatosCarrera::grado()->first();
        $id_agrupacion = TiposDatosCarrera::agrupacion()->first();
        // $grados =        DatosCarreraGraduado::where('id_tipo', $id_grado->id)       ->pluck('nombre', 'id');
        $grados =        Grado::allData()->pluck('nombre', 'id');
        $disciplinas =   Disciplina::pluck('descriptivo', 'id')->all();
        $areas =         Area::pluck('descriptivo', 'id')->all();
        $agrupaciones =  DatosCarreraGraduado::where('id_tipo', $id_agrupacion->id)  ->pluck('nombre', 'id');

        $datos_carrera = [
            // 'carreras' => $carreras,
            // 'universidades' => $universidades,
            'grados' => $grados,
            'disciplinas' => $disciplinas,
            'areas' => $areas,
            'agrupaciones' => $agrupaciones,
            // 'sectores' => $sectores
        ];

        return view('encuestadores.lista-filtro-encuestas', 
            compact('id_supervisor', 'id_encuestador', 'datos_carrera', 'rol_usuario'));
    }

    /** Recibe las encuestas seleccionadas por la persona que realiza la asignacion, y realiza algunas
     * validaciones. Primero comprueba que el supervisor que realizó la asignación exista en la base de datos,
     * luego que el encuestador también exista. Después busca los estados NO ASIGNADA y ASIGNADA para 
     * cambiar el estado de las encuestas de uno a otra.
     */
    public function crearAsignacion($id_supervisor, $id_encuestador, Request $request) {
        /** Se obtiene el supervisor por el ID */
        $supervisor = User::find($id_supervisor);

        /** Si el supervisor no se encuentra en la BD */
        if(empty($supervisor)) {
            Flash::error('El supervisor con el ID '.$id_supervisor.' no existe');
            return redirect(route('encuestadores.index'));
        }

        /** Se obtiene el encuestador por el ID */
        $encuestador = User::find($id_encuestador);

        /** Si el encuestador no se encuentra en la BD */
        if(empty($encuestador)) {
            Flash::error('El encuestador con el ID '.$id_encuestador.' no existe');
            return redirect(route('encuestadores.index'));
        }

        /** Se consulta si el estado 'NO ASIGNADA' existe en la base de datos */
        $id_estado_sin_asignar = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'NO ASIGNADA')->first();

        /** Mensaje en caso de que el estado NO ASIGNADA no exista */
        if(is_null($id_estado_sin_asignar)) {
            Flash::error('El estado \"NO ASIGNADA\" no existe en la base de datos, contacte al administrador para más información.');
            return redirect(route('encuestadores.index'));
        }

        /** Se consulta si el estado 'ASIGNADA' existe en la base de datos */
        $id_estado_asignada = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'ASIGNADA')->first();

        /** Mensaje en caso de que el estado ASIGNADA no exista */
        if(is_null($id_estado_asignada)) {
            Flash::error('El estado \"ASIGNADA\" no existe en la base de datos, contacte al administrador para más información.');
            return redirect(route('encuestadores.index'));
        }

        $encuestas_no_encontradas = [];

        /** Se hace una busqueda de la encuesta */
        foreach($request->encuestas as $id_graduado) {
            $registro_encuesta = EncuestaGraduado::find($id_graduado);

            if(empty($registro_encuesta)) {
                array_push($encuestas_no_encontradas, $id_graduado);
            }

            $update = $registro_encuesta->asignarEncuesta($id_supervisor, $id_encuestador, $id_estado_sin_asignar->id, $id_estado_asignada->id);
        }

        if(sizeof($encuestas_no_encontradas) <= 0) {
            Flash::success('Se han asignado las encuestas correctamente.');
        }
        else {
            Flash::warning('Algunas encuestas no han sido asignadas: '.$encuestas_no_encontradas);
        }

        return redirect(route('encuestadores.index'));
    }

    public function encuestasAsignadasPorEncuestador($id_encuestador) {
        // $listaDeEncuestas = EncuestaGraduado::contactsAndDetails()->get();
        // dd(json_encode($listaDeEncuestas));
        $listaDeEncuestas = EncuestaGraduado::listaEncuestasAsignadasEncuestador($id_encuestador)->with('contactos')->get();

        /* se recorren las encuestas encontradas */
        foreach($listaDeEncuestas as $encuesta) {
            /* se le cambian los codigos por numeros */
            $encuesta->changeCodesByNames();
            /* se sacan los contactos por cada encuesta */
            $contactos = $encuesta->contactos;

            /* se recorren los contactos */
            foreach($contactos as $contacto) {
                /* se sacan los detalles de contacto, de cada contacto */
                $detalles = $contacto->detalle;

                /* se setean los detalles, en una variable de detalle para cada contacto */
                $contacto->detalle = $detalles;
            }
            /* se setean los contactos en una variable de contacto para cada encuesta */
            $encuesta->contactos = $contactos;
            /* se setea un estado para cada encuesta */
            $encuesta->estado = $encuesta->estado()->estado;

            $ids_carreras = '';
            $otras_carreras = $encuesta->otrasCarreras();

            // dd($otras_carreras);

            if(!is_null($otras_carreras)) {
                $tam = sizeof($otras_carreras);
                for($i=0; $i<$tam; $i++) {
                    if($i>=$tam-1) {
                        $ids_carreras .= $otras_carreras[$i];
                    }
                    else {
                        $ids_carreras .= $otras_carreras[$i] . '-';
                    }
                }
    
                $encuesta->otras_carreras = $ids_carreras;
            }
            else {
                $encuesta->otras_carreras = null;
            }
        }

        /* NOTA:
        todo lo anterior tiene como fin, poder crear un objeto que permita ser cargado mediante vue.js en la vista,
        de forma que puedan existir campos de filtro, sin necesidad de ir a la base de datos a realizar las consultas.
        el objeto quedaría formado asi: datos = [
            {
                datos_de_cada_encuesta,
                contactos : [
                    {
                        datos_de_cada_contacto,
                        detalle: [
                            {
                                datos_de_cada_detalle
                            }
                        ]
                    }
                ],
                estado
            }
        ]
        Así se podrá leer en vue o javascript para cada encuesta: encuesta, encuesta.contactos, encuesta.contactos.detalle,
        sin mayor complicación
        */

        $encuestador = User::find($id_encuestador);

        return view('encuestadores.tabla-encuestas-asignadas', compact('listaDeEncuestas', 'encuestador'));
    }

    /** Permite obtenet todas las encuestas que tienen por estado NO ASIGNADA, mediante los filtros
     * que el usuario haya agregado en la vista.
     */
    public function filtrar_muestra_a_asignar($id_supervisor, $id_encuestador, Request $request) {

        $input = $request->all();

        $resultado = EncuestaGraduado::listaDeEncuestasSinAsignar();

        // if(!is_null($input['carrera'])) {
        //     $resultado->where('codigo_carrera', $input['carrera']);
        // }

        // if(!is_null($input['universidad'])) {
        //     $resultado->where('codigo_universidad', $input['universidad']);
        // }

        if(!is_null($input['grado'])) {
            // es pregrado (profesorado y diplomado)
            if($input['grado'] == 3){

            }
            else if($input['grado'] == 4){ // bachillerato

            }
            else if($input['grado'] == 5) { //licenciatura

            }
            $grado = Grado::buscarPorCodigo($input['grado'])->first();

            if(!empty($grado)){
                $resultado->where('codigo_grado', $grado->id);
            }
            else {
                $resultado->where('codigo_grado', '');
            }
        }

        if(!is_null($input['disciplina'])) {
            $resultado->where('codigo_disciplina', $input['disciplina']);
        }

        if(!is_null($input['area'])) {
            $resultado->where('codigo_area', $input['area']);
        }

        if(!is_null($input['agrupacion'])) {
            $agrupacion = Agrupacion::buscarPorCodigo($input['agrupacion'])->first();

            if(!empty($agrupacion)) {
                $resultado->where('codigo_agrupacion', $agrupacion->id);
            }
            else {
                $resultado->where('codigo_agrupacion', '');
            }
        }

        // if(!is_null($input['sector'])) {
        //     $resultado->where('codigo_sector', $input['sector']);
        // }

        $encuestasNoAsignadas = $resultado->get();

        return view('encuestadores.tabla-encuestas-no-asignadas', compact('encuestasNoAsignadas', 'id_supervisor', 'id_encuestador'));
    }

    public function removerEncuestas($id_encuestador, Request $request) {

        $encuestasAsignadas = Asignacion::where('id_encuestador', $id_encuestador)->get();
        $id_no_asignada = DB::table('tbl_estados_encuestas')->select('id')->where('estado', 'NO ASIGNADA')->first();

        foreach($encuestasAsignadas as $encuesta) {
            // echo 'Encuesta: '.$encuesta->id.'<br>';
            foreach($request->encuestas as $id_desasignada) {
                if($encuesta->id_graduado == $id_desasignada) {
                    $encuesta->id_encuestador = null;
                    $encuesta->id_supervisor = null;
                    $encuesta->id_estado = $id_no_asignada->id;
                    $encuesta->updated_at = \Carbon\Carbon::now();
                    $encuesta->save();
                }
            }
        }

        Flash::success('Se han eliminado las encuestas de este encuestador');
        return redirect(route('asignar-encuestas.lista-encuestas-asignadas', $id_encuestador));
    }

    public function remover_encuestas_a_encuestador($id_entrevista, $id_encuestador) {
        $entrevista = EncuestaGraduado::find($id_entrevista);
        $quito_entrevista = $entrevista->desasignarEntrevista();
        
        if($quito_entrevista) {
            Flash::success('Se ha eliminado la entrevista de este encuestador');
            return redirect(route('asignar-encuestas.lista-encuestas-asignadas', $id_encuestador));
        }
        else {
            Flash::error('No se ha podido eliminar la entrevista de este encuestador');
            return redirect(route('asignar-encuestas.lista-encuestas-asignadas', $id_encuestador));
        }
    }

    public function realizar_entrevista($id_entrevista) {
        $entrevista = EncuestaGraduado::find($id_entrevista);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista solicitada.');
            return redirect(route('asignar-encuestas.lista-encuestas-asignadas', Auth::user()->id));
        }
        
        // $estados = DB::table('tbl_estados_encuestas')->get()->pluck('estado', 'id');

        return view('encuestadores.realizar-entrevista', compact('entrevista'));
    }

    public function agregar_contacto($id_entrevista) {
        return view('encuestadores.agregar-contacto-entrevista')->with('id_entrevista', $id_entrevista);
    }

    public function actualizar_entrevista($id_entrevista, Request $request) {
        // dd($request->all());

        $entrevista = EncuestaGraduado::find($id_entrevista);

        if(empty($entrevista)) {
            Flash::error('No se ha encontrado la entrevista solicitada.');
            return redirect(route('asignar-encuestas.lista-encuestas-asignadas', Auth::user()->id));
        }

        //Cambiar el estado de la entrevista por el del request
        $cambio_estado = $entrevista->cambiarEstadoDeEncuesta($request->estados);

        if(!$cambio_estado) {
            Flash::error('No se ha podido cambiar el estado de la entrevista');
            return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
        }

        //si no existen observaciones, agregarla, de lo contrario modificar la existente.
        $observaciones_entrevista = $entrevista->observaciones;

        if(sizeof($observaciones_entrevista) == 0) {
            //Agregar la observación
            $nueva_observacion = ObservacionesGraduado::create([
                'id_graduado' => $entrevista->id,
                'id_usuario' => Auth::user()->id,
                'observacion' => $request->observacion,
                'created_at' => Carbon::now()
            ]);
        }
        else {
            //Modificar la existente
            $observacion_existente = ObservacionesGraduado::where('id_graduado', $entrevista->id)->first();
            $observacion_existente->observacion = $request->observacion;
            $observacion_existente->updated_at = Carbon::now();
            $cambio_observacion = $observacion_existente->save();

            if(!$cambio_observacion) {
                Flash::error('No se ha podido agregar la observación a la entrevista');
                return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
            }
        }

        Flash::success('Se han guardado correctamente los cambios');
        return redirect(route('asignar-encuestas.lista-encuestas-asignadas', Auth::user()->id));
    }

    public function agregar_detalle_contacto($id_contacto, $id_entrevista) {
        return view('encuestadores.agregar-detalle-contacto', compact('id_contacto', 'id_entrevista'));
    }

    public function borrar_detalle_contacto($id_detalle_contacto, $id_entrevista) {
        $detalle = DetalleContacto::find($id_detalle_contacto);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
        }

        $detalle->deleted_at = Carbon::now();
        $detalle->save();

        Flash::success('La información del contacto se ha eliminado.');
        return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
    }

    public function editar_detalle_contacto($id_detalle_contacto, $id_entrevista) {
        $detalle = DetalleContacto::find($id_detalle_contacto);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
        }

        return view('encuestadores.editar-detalle-contacto', compact('detalle', 'id_entrevista'));
    }

    public function editar_contacto_entrevista($id_contacto, $id_entrevista) {
        $contacto = ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No existe el contacto que busca');
            return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
        }

        return view('encuestadores.modificar-contacto-entrevista', compact('contacto', 'id_entrevista'));
    }

    public function guardar_contacto($id_entrevista, $id_supervisor, Request $request) {
        
        $contacto = ContactoGraduado::create([
            'identificacion_referencia' => $request->identificacion_referencia,
            'nombre_referencia'         => $request->nombre_referencia,
            'parentezco'                => $request->parentezco,
            'id_graduado'               => $id_entrevista,
            'created_at'                => \Carbon\Carbon::now()
        ]);

        $contacto->agregarDetalle($request->informacion_contacto, $request->observacion_contacto);

        Flash::success('Se ha guardado correctamente la nueva información de contacto.');
        return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
    }

    public function guardar_detalle_contacto($id_contacto, $id_entrevista, Request $request) {
        $contacto = ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No se ha encontrado el contacto.');
            return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
        }

        $contacto->agregarDetalle($request->contacto, $request->observacion);

        Flash::success('Se ha agregado información al contacto correctamente.');
        return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
    }

    public function actualizar_detalle_contacto($id_detalle_contacto, $id_entrevista, Request $request) {
        $detalle = DetalleContacto::find($id_detalle_contacto);

        if(empty($detalle)) {
            Flash::error('No se ha encontrado el detalle del contacto.');
            return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
        }

        $detalle->contacto = $request->contacto;
        $detalle->observacion = $request->observacion;
        $detalle->estado = $request->estado;
        $detalle->updated_at = Carbon::now();
        $detalle->save();

        Flash::success('La información del contacto se ha modificado correctamente.');
        return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
    }

    public function actualizar_contacto_entrevista($id_contacto, $id_entrevista, Request $request) {
        $contacto = ContactoGraduado::find($id_contacto);

        if(empty($contacto)) {
            Flash::error('No existe el contacto que busca');
            return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
        }

        $contacto->identificacion_referencia = $request->identificacion_referencia;
        $contacto->nombre_referencia = $request->nombre_referencia;
        $contacto->parentezco = $request->parentezco;
        $contacto->updated_at = Carbon::now();
        $contacto->save();

        Flash::success('El contacto ha sido actualizado correctamente.');
        return redirect(route('asignar-encuestas.realizar-entrevista', $id_entrevista));
    }

    public function hacer_sustitucion() {
        if(EncuestaGraduado::totalDeEncuestas()->count() <= 0) {
            Flash::info('Aún no existen encuestas en el sistema, no tiene sentido realizar una sustitución.');
            return redirect(url('home'));
        }

        return view('encuestas_graduados.hacer-sustitucion');
    }

    public function hacer_sustitucion_post(Request $request) {
        // dd($request->all());
        $ruta = 'encuestas-graduados.hacer-sustitucion';

        /* SE BUSCA LA ENCUESTA POR MEDIO DEL TOKEN INGRESADO */
        $encuesta = EncuestaGraduado::where('token', $request->token_entrevista)->first();

        /* SI LA ENCUESTA NO EXISTE, SE DEVOLVERÁ UN ERROR */
        if(empty($encuesta)) {
            Flash::error('La entrevista que busca por token, no corresponde con los registros del sistema.');
            // Flash::overlay('La entrevista que busca por token, no corresponde con los registros del sistema.', 'Error de búsqueda')->error();
            return redirect(route($ruta));
        }
        else {
            /* SI LA ENCUESTA EXISTE Y CORRESPONDE A UN CASO DE CENSO, SE MOSTRARÁ UN ERROR */
            if($encuesta->tipo_de_caso == 'CENSO' || $encuesta->tipo_de_caso == 'SUSTITUCION') {
                Flash::error('El caso que busca corresponde a Censo o una Sustitucion, no se puede sustituir.');
                // Flash::overlay('El caso que busca corresponde a Censo, no se puede sustituir.', 'Error de tipo de caso')->error();
                return redirect(route($ruta));
            }
            else {
                /* SI LA ENCUESTA EXISTE Y NO ES CENSO, SE HARÁ UNA BÚSQUEDA PARA ENCONTRAR EL REEMPLAZO */
                $tipo_de_caso = 'SUSTITUCION';
    
                $encuesta_nueva = EncuestaGraduado::where('codigo_grado', $encuesta->codigo_grado)
                    ->where('codigo_disciplina', $encuesta->codigo_disciplina)
                    ->where('codigo_area', $encuesta->codigo_area)
                    ->where('codigo_agrupacion', $encuesta->codigo_agrupacion)
                    ->where('tipo_de_caso', $tipo_de_caso)
                    ->first();
    
                /* SI EL REEMPLAZO NO SE ENCUENTRA, MOSTRARÁ UN ERROR */
                if(empty($encuesta_nueva)) {
                    Flash::error('No se ha encontrado una sustitución que coincida con las características.');
                    // Flash::overlay('No se ha encontrado una sustitución que coincida con las características.', 'Error en la búsqueda de sustituciones')->error();
                    return redirect(route($ruta));
                }

                /* SI EXISTE EL REEMPLAZO, SE LE CAMBIA EL ESTADO */
                $encuesta_nueva->tipo_de_caso = $encuesta->tipo_de_caso;
                $save = $encuesta_nueva->save();

                /* A LA ENCUESTA ENCONTRADA POR TOKEN, SE LE CAMBIA EL TIPO DE CASO */
                $estado = Asignacion::where('id_graduado', $encuesta->id)->first();
                $estado = Estado::find($estado->id);
                $encuesta->tipo_de_caso = $estado->estado;
                $encuesta->save();

                /* SI TODO SALE BIEN,  */
                Flash::success('La sustitución se ha realizado con éxito.');
                return redirect(route('home'));
            }
        }       
    }

    /* Permite buscar una entrevista por TOKEN, devolviendo el resultado en forma de array, esto porque
    la funcion se llama mediante AXIOS. Se devuelve Si fue encontrada o no, la encuesta y un mensaje para el usuario. */
    function buscar_encuesta(Request $request) {
        /* se busca la encuesta mediante el token */
        $encuesta = EncuestaGraduado::where('token', $request->token)->first();

        /* si la encuesta no se encuentra, se devuelven los datos para informar al usuario. */
        if(empty($encuesta)) {
            return array('encontrada'=> false, 'encuesta'=>null, 'mensaje'=>'No se ha encontrado una encuesta con el token ingresado.');
        }

        /* si la encuesta encontrada es un censo, se devuelve un mensaje informando al usuario */
        if($encuesta->tipo_de_caso == 'CENSO') {
            return array('encontrada'=> false, 'encuesta'=>null, 'mensaje'=>'La encuesta encontrada pertenece a CENSO, no se puede hacer el reemplazo con la misma.');
        }

        /* si la encuesta encontrada es una sustitucion, se devuelve un mensaje informando al usuario */
        if($encuesta->tipo_de_caso == 'SUSTITUCION') {
            return array('encontrada'=> false, 'encuesta'=>null, 'mensaje'=>'La encuesta encontrada pertenece a una SUSTITUCION, no se puede hacer el reemplazo con la misma.');
        }

        /* si ninguna de las condiciones nteriores se cumple, se devuelve la informacion correcta */
        return array('encontrada'=> true, 'encuesta'=>$encuesta, 'mensaje'=>'Se ha encontrado una coincidencia.');
    }

    public function reasignar_caso($id_entrevista, $id_encuestador) {
        $encuesta = EncuestaGraduado::find($id_entrevista);

        if(empty($encuesta)) {
            Flash::error('No se ha encontrado la entrevista solicitada');
            return redirect(route('asignar-encuestas.lista-encuestas-asignadas', $id_encuestador));
        }

        $encuestador = User::find($id_encuestador);

        if(empty($encuestador)) {
            Flash::error('No se ha encontrado el encuestador en cuestión.');
            return redirect(route('home'));
        }

        return view('encuestadores.reasignar-caso', compact('id_entrevista', 'id_encuestador'));
    }

    public function reasignar_caso_post($id_entrevista, $id_encuestador, Request $request) {
        $data = [
            'id_entrevista'=>$id_entrevista,
            'id_encuestador'=>$id_encuestador,
            'user_code'=>$request->user_code
        ];

        dd($data);
    }
}