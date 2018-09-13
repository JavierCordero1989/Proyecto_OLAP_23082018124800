{{-- @extends('layouts.app')

@section('title', 'Datos del encuestador') 

@section('content')
    <section class="content-header">
        <h1>
            Datos del encuestador
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <!-- User code Field -->
                    <div class="form-group">
                        {!! Form::label('user_code', 'Código:') !!}
                        <p>{!! $encuestador->user_code !!}</p>
                    </div>

                    <!-- Nombre Field -->
                    <div class="form-group">
                        {!! Form::label('nombre', 'Nombre:') !!}
                        <p>{!! $encuestador->name !!}</p>
                    </div>

                    <!-- colocar los roles y permisos -->

                    <!-- Created At Field -->
                    <div class="form-group">
                        {!! Form::label('created_at', 'Creado el:') !!}
                        <p>{!! $encuestador->created_at !!}</p>
                    </div>

                    <!-- Updated At Field -->
                    <div class="form-group">
                        {!! Form::label('updated_at', 'Modificado el:') !!}
                        <p>{!! $encuestador->updated_at !!}</p>
                    </div>

                    <!--Botón para volver a atrás-->
                    <a href="{!! route('supervisor2.lista-de-encuestadores') !!}" class="btn btn-default">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection --}}
