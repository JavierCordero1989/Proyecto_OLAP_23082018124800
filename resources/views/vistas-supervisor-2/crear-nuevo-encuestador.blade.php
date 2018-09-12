{{-- @extends('layouts.app')

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
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'supervisor2.almacenar-nuevo-encuestador', 'onsubmit'=>'return validar_formulario();']) !!}

                        <!-- Codigo del usuario Field -->
                        <div class="form-group col-sm-6 col-sm-offset-3">
                            <div class="col-sm-12 text-center">
                                {!! Form::label('user_code', 'Código') !!}
                            </div>
                            <div class="col-sm-12">
                                {!! Form::text('user_code', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <!-- Nombre Field -->
                        <div class="form-group col-sm-6 col-sm-offset-3">
                            <div class="col-xs-12 text-center">
                                {!! Form::label('name', 'Nombre') !!}
                            </div>
                            <div class="col-xs-12">
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <!-- Email Field -->
                        <div class="form-group col-sm-6 col-sm-offset-3">
                            <div class="col-xs-12 text-center">
                                {!! Form::label('email', 'Correo electrónico') !!}
                            </div>
                            <div class="col-xs-12">
                                {!! Form::text('email', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <!-- Password Field -->
                        <div class="form-group col-sm-6 col-sm-offset-3">
                            <div class="col-xs-12 text-center">
                                {!! Form::label('password', 'Contraseña:') !!}
                            </div>
                            <div class="col-xs-12">
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            <div class="col-xs-3 col-xs-offset-3">
                                {!! Form::submit('Guardar', ['class' => 'btn btn-primary col-xs-12']) !!}
                            </div>
                            <div class="col-xs-3">
                                <a href="{!! route('supervisor2.lista-de-encuestadores') !!}" class="btn btn-default col-xs-12">Cancelar</a>
                            </div>
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
@endsection --}}