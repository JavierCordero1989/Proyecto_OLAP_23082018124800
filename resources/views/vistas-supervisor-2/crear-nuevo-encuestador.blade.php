@extends('layouts.app')

@section('title', "Crear Encuestador")

@section('content')
    <section class="content-header">
        <h1>
            Nuevo encuestador
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        {{-- @include('adminlte-templates::common.errors') --}}
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'supervisor2.almacenar-nuevo-encuestador', 'onsubmit'=>'return validar_formulario();']) !!}

                        <!-- Codigo del usuario Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('user_code', 'Código:') !!}
                            {!! Form::text('user_code', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Nombre Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('name', 'Nombre:') !!}
                            {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Email Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('email', 'Email:') !!}
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                        </div>

                        <!-- Password Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('password', 'Contraseña:') !!}
                            {{-- {!! Form::password('password',['class' => 'form-control', 'placeholder' => 'Password', 'type' => 'password']) !!} --}}
                            {!! Form::password('password', ['class' => 'form-control']) !!}
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('supervisor2.lista-de-encuestadores') !!}" class="btn btn-default">Cancelar</a>
                        </div>
                        
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function validar_formulario() {
            var user_code = $('#user_code').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var password = $('#password').val();

            if( user_code=="" || name=="" || email=="" || password=="" ) {
                alert("Debe completar todos los campos del formulario para continuar");
                return false;
            }

            return true;
        }
    </script>
@endsection