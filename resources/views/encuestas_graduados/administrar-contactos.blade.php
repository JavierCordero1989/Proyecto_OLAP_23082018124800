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
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Agregar nuevo
                        </a>
                    </div>
                    @foreach ($entrevista->contactos as $contacto)
                        <div class="col-md-12">
                            <div class="box box-default">
                                <div class="box-body with-border">
                                    
                                    <a href="{!! route('contactos.agregar-contacto-get', [$entrevista->id, $contacto->id]) !!}" class="btn btn-default btn-xs" data-toggle="tooltip" title="Editar información del contacto" data-placement="right"><i class="far fa-edit"></i></a>

                                    @if ($contacto->nombre_referencia != "")
                                        <h3 class="text-info text-capitalize">{!! $contacto->nombre_referencia !!}</h3>
                                    @endif

                                    @if ($contacto->identificacion_referencia != "")
                                        <h4 class="text-info text-capitalize">{!! $contacto->identificacion_referencia !!}</h4>
                                    @endif
        
        
                                    @if ($contacto->parentezco != "")
                                        <h4 class="text-info text-capitalize">{!! $contacto->parentezco !!}</h4>
                                    @endif
        
                                    <table class="table table-condensed table-striped">
                                        <thead>
                                            <th><u>Contacto</u></th>
                                            <th><u>Observacion</u></th>
                                            <th><u>Estado</u></th>
                                            <th><u>Opciones</u></th>
                                        </thead>
                                        <tbody>
                                            @foreach ($contacto->detalle as $detalle)
                                                <tr>
                                                    <td>{!! $detalle->contacto !!}</td>
                                                    <td>{!! $detalle->observacion == "" ? "NO TIENE" : $detalle->observacion !!}</td>
                                                    <td>{!! $detalle->estado == 'F' ? '<i class="fas fa-check-circle" style="color: green;"></i>' : ($detalle->estado == 'E' ? '<i class="fas fa-times-circle" style="color: red;"></i>' : 'INDEFINIDO') !!}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="#" class="btn btn-default btn-xs" data-toggle="tooltip" title="Editar" data-placement="left"><i class="far fa-edit"></i></a>
                                                            <a href="#" class="btn btn-danger btn-xs" data-toggle="tooltip" title="Eliminar" data-placement="right"><i class="far fa-trash-alt"></i></a>
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