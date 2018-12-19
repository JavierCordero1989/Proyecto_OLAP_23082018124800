@extends('layouts.app')

@section('title', 'Administrar contactos')

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-12">
                <a href="{!! route('encuestas-graduados.index') !!}" class="btn btn-default pull-left"><i class="fas fa-arrow-left"></i> Volver</a>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-body with-border">
                <div class="row">
                    <div class="col-md-12" style="margin-bottom: 15px;">
                        <a href="{!! route('contactos.guardar-contacto-get', $entrevista->id) !!}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Agregar nuevo
                        </a>
                    </div>
                    @foreach ($entrevista->contactos as $contacto)
                        <div class="col-md-12">
                            <div class="box box-default">
                                <div class="box-body with-border">
                                    
                                    <div class="btn-group">
                                        <a href="{!! route('contactos.guardar-detalle-contacto-get', [$entrevista->id, $contacto->id]) !!}" class="btn btn-info btn-xs"><i class="fas fa-plus" data-toggle="tooltip" title="Agregar nuevo contacto" data-placement="top"></i></a>
    
                                        <a href="{!! route('contactos.editar-contacto-get', [$entrevista->id, $contacto->id]) !!}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Editar información del contacto" data-placement="right"><i class="far fa-edit"></i></a>
                                    </div>

                                    @if ($contacto->nombre_referencia != "")
                                        <h3 class="text-info text-capitalize">{!! $contacto->nombre_referencia !!}</h3>
                                    @endif

                                    @if ($contacto->identificacion_referencia != "")
                                        <h4 class="text-info text-capitalize">{!! $contacto->identificacion_referencia !!}</h4>
                                    @endif
        
        
                                    @if ($contacto->parentezco != "")
                                        <h4 class="text-info text-capitalize">{!! $contacto->parentezco !!}</h4>
                                    @endif
        
                                    <table class="table table-condensed table-hover">
                                        <thead>
                                            <th><u>Estado</u></th>
                                            <th><u>Contacto</u></th>
                                            <th><u>Observacion</u></th>
                                            <th><u>Opciones</u></th>
                                        </thead>
                                        <tbody>
                                            @foreach ($contacto->detalle as $detalle)
                                                <tr>
                                                    <td>{!! $detalle->estado == 'F' ? '<i class="fas fa-check-circle" style="color: green;"></i>' : ($detalle->estado == 'E' ? '<i class="fas fa-times-circle" style="color: red;"></i>' : 'INDEFINIDO') !!}</td>
                                                    <td>{!! $detalle->contacto !!}</td>
                                                    <td>{!! $detalle->observacion == "" ? "NO TIENE" : $detalle->observacion !!}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{!! route('contactos.editar-detalle-contacto-get', [$entrevista->id, $detalle->id]) !!}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Editar" data-placement="left"><i class="far fa-edit"></i></a>
                                                            {{-- <a href="#" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" data-placement="right"><i class="far fa-trash-alt"></i></a> --}}
                                                            {{-- <a href="#" class="btn btn-info btn-xs" data-toggle="tooltip" title="Cambiar estado" data-placement="left"><i class="fas fa-exchange-alt"></i></a> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection