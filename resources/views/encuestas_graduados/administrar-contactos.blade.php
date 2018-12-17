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
                    @foreach ($entrevista->contactos as $contacto)
                        <div class="col-md-12">
                            <div class="box box-default">
                                <div class="box-body with-border">
                                    @if ($contacto->identificacion_referencia != "")
                                        <h3 class="text-info">{!! $contacto->identificacion_referencia !!}</h3>
                                    @endif
        
                                    @if ($contacto->nombre_referencia != "")
                                        <h3 class="text-info">{!! $contacto->nombre_referencia !!}</h3>
                                    @endif
        
                                    @if ($contacto->parentezco != "")
                                        <h3 class="text-info">{!! $contacto->parentezco !!}</h3>
                                    @endif
        
                                    <table class="table table-condensed table-striped">
                                        <thead>
                                            <th>Contacto</th>
                                            <th>Observacion</th>
                                            <th>Estado</th>
                                            <th>Opciones</th>
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