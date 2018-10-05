@extends('pruebas.app')

@section('title', 'Usuarios')

@section('content')
    <div class="content">
        <div class="row">
            <!-- Administradores -->
            <div class="col-xs-6">
                <h3 class="text-center">Administradores</h3>
                <table class="table text-center">
                    <tbody>
                        @foreach ($datos['administradores'] as $usuario)
                            <tr>
                                <td>{!! $usuario !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Supervisores 1 -->
            <div class="col-xs-6">
                <h3 class="text-center">Supervisores 1</h3>
                <table class="table  text-center">
                    <tbody>
                        @foreach ($datos['supervisores_1'] as $usuario)
                            <tr>
                                <td>{!! $usuario !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <!-- Supervisores 2 -->
            <div class="col-xs-6">
                <h3 class="text-center">Supervisores 2</h3>
                <table class="table text-center">
                    <tbody>
                        @foreach ($datos['supervisores_2'] as $usuario)
                            <tr>
                                <td>{!! $usuario !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Encuestadores -->
            <div class="col-xs-6">
                <h3 class="text-center">Encuestadores</h3>
                <table class="table text-center">
                    <tbody>
                        @foreach ($datos['encuestadores'] as $usuario)
                            <tr>
                                <td>{!! $usuario !!}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection