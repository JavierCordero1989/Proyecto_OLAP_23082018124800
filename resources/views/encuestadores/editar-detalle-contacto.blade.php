@extends('layouts.app')

@section('title', 'Editar detalle')

@section('content')
    <section class="content-header">
        <h1>
            Editar información de contacto
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($detalle, ['route' => ['asignar-encuestas.actualizar-detalle-contacto', $detalle->id, $id_entrevista], 'method' => 'patch', 'class'=>'form-horizontal']) !!}

                        <!-- Contacto Field -->
                        <div class='form-group'>
                            {!! Form::label('contacto', 'Contacto: ', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class=''></i></span>
                                    {!! Form::text('contacto', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Identificacion Field -->
                        <div class='form-group'>
                            {!! Form::label('observacion', 'Observación: ', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class=''></i></span>
                                    {!! Form::textarea('observacion', null, ['class'=>'form-control', 'rows' => 2, 'cols' => 40]) !!}
                                </div>
                            </div>
                        </div>

                        @php
                            $datos = [
                                ''=>'- - - SELECCIONE - - -',
                                'F'=>'FUNCIONAL',
                                'E'=>'ELIMINADO',
                            ]    
                        @endphp

                        <!-- campo para el estado -->
                        <div class='form-group'>
                            {!! Form::label('estado', 'Estado:', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    <span class='input-group-addon'><i class=''></i></span>
                                    {!! Form::select('estado', $datos, null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <!-- Submit Field -->
                        <div class='form-group'>
                            {!! Form::label('', '', ['class'=>'control-label col-md-4']) !!}
                            <div class='col-md-6 inputGroupContainer'>
                                <div class='input-group'>
                                    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                                    <a href="{!! route('asignar-encuestas.realizar-entrevista', $id_entrevista) !!}" class="btn btn-default">Cancelar</a>
                                </div>
                            </div>
                        </div>

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection