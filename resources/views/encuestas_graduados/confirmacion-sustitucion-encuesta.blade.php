@extends('layouts.app')

@section('title', 'Confirmar sustitución')

@section('content')
    <div class="content">
        <h3>Encuesta encontrada por token:</h3>
        <!-- caja para la encuesta que se encontró por medio del token -->
        <div class="box box-primary">
            <div class="box-body with-border">
                <div class="col-md-6"><p><u>Identificacion del graduado:</u> {!! $encuesta->identificacion_graduado !!}</p></div>
                <div class="col-md-6"><p><u>Nombre completo:</u> {!! $encuesta->nombre_completo !!}</p></div>
                <div class="col-md-6"><p><u>Año de graduación:</u> {!! $encuesta->annio_graduacion !!}</p></div>
                <div class="col-md-6"><p><u>Sexo:</u> {!! $encuesta->sexo == 'M' ? 'Hombre' : ($encuesta->sexo == 'F' ? 'Mujer' : 'Sin Clasificar')!!}</p></div>
                <div class="col-md-6"><p><u>Carrera:</u> {!! $encuesta->carrera->nombre !!}</p></div>
                <div class="col-md-6"><p><u>Universidad:</u> {!! $encuesta->universidad->nombre !!}</p></div>
                <div class="col-md-6"><p><u>Grado:</u> {!! $encuesta->grado->nombre !!}</p></div>
                <div class="col-md-6"><p><u>Disciplina:</u> {!! $encuesta->disciplina->descriptivo !!}</p></div>
                <div class="col-md-6"><p><u>Área:</u> {!! $encuesta->area->descriptivo !!}</p></div>
                <div class="col-md-6"><p><u>Agrupación:</u> {!! $encuesta->agrupacion->nombre !!}</p></div>
                <div class="col-md-6"><p><u>Sector:</u> {!! $encuesta->sector->nombre !!}</p></div>
                <div class="col-md-6"><p><u>Tipo de caso:</u> {!! $encuesta->tipo_de_caso !!}</p></div>
            </div>
        </div>

        <h3>Encuesta encontrada para sustitución</h3>
        <!-- Caja para la encuesta que se encontró para sustituirla -->
        <div class="box box-primary">
            <div class="box-body with-border">
                <div class="col-md-6"><p><u>Identificacion del graduado:</u> {!! $encuesta_nueva->identificacion_graduado !!}</p></div>
                <div class="col-md-6"><p><u>Nombre completo:</u> {!! $encuesta_nueva->nombre_completo !!}</p></div>
                <div class="col-md-6"><p><u>Año de graduación:</u> {!! $encuesta_nueva->annio_graduacion !!}</p></div>
                <div class="col-md-6"><p><u>Sexo:</u> {!! $encuesta_nueva->sexo == 'M' ? 'Hombre' : ($encuesta_nueva->sexo == 'F' ? 'Mujer' : 'Sin Clasificar')!!}</p></div>
                <div class="col-md-6"><p><u>Carrera:</u> {!! $encuesta_nueva->carrera->nombre !!}</p></div>
                <div class="col-md-6"><p><u>Universidad:</u> {!! $encuesta_nueva->universidad->nombre !!}</p></div>
                <div class="col-md-6"><p><u>Grado:</u> {!! $encuesta_nueva->grado->nombre !!}</p></div>
                <div class="col-md-6"><p><u>Disciplina:</u> {!! $encuesta_nueva->disciplina->descriptivo !!}</p></div>
                <div class="col-md-6"><p><u>Área:</u> {!! $encuesta_nueva->area->descriptivo !!}</p></div>
                <div class="col-md-6"><p><u>Agrupación:</u> {!! $encuesta_nueva->agrupacion->nombre !!}</p></div>
                <div class="col-md-6"><p><u>Sector:</u> {!! $encuesta_nueva->sector->nombre !!}</p></div>
                <div class="col-md-6"><p><u>Tipo de caso:</u> {!! $encuesta_nueva->tipo_de_caso !!}</p></div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="col-md-6">
                    <a id="btn-reemplazar" href="{!! route('encuestas-graduados.realizar-reemplazo', 1) !!}" class="btn btn-primary form-control">
                        Reemplazar
                    </a>
                </div>

                <div class="col-md-6">
                    <a id="btn-cancelar-reemplazo" href="{!! route('encuestas-graduados.realizar-reemplazo', 2) !!}" class="btn btn-default form-control">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#btn-reemplazar').on('click', function(ev) {
            if(!confirm('¿Desea realizar el reemplazo? No podrá deshacerla en el futuro')) {
                ev.preventDefault()
            }
        })

        $('#btn-cancelar-reemplazo').on('click', function(ev) {
            if(!confirm('¿Desea cancelar el reemplazo?')) {
                ev.preventDefault()
            }
        })
    </script>
@endsection