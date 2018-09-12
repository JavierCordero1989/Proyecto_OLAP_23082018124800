@extends('layouts.app')

@section('title', 'Modificar encuestador')

@section('content')
    <section class="content-header">
        <h1>
            Modificar datos de encuestador
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
                   {!! Form::model($encuestador, ['route' => ['encuestadores.update', $encuestador->id], 'method' => 'patch', 'onsubmit' => 'return validar_formulario();']) !!}

                        @include('encuestadores.fields-edit')

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

            if( user_code=="" || name=="" || email=="") {
                alert('Los espacios del formulario para Código, Nombre y Email deben estar completos para poder continuar');
                return false;
            }
            else {
                if(password == "") {
                    return confirm('El espacio para la contraseña está vacío, ¿Desea dejarlo así? Tome en cuenta que la contraseña actual del encuestador no cambiará en caso afirmativo.');
                }
            }

           return true;
       }
   </script>
@endsection