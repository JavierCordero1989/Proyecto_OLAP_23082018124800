@extends('layouts.app')

@section('title', "Cambiar nombre de usuario")

@section('content')
    <section class="content-header">
        <h1>
            Editar nombre de usuario
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                    {!! Form::model($user, ['route' => ['users.update_name', $user->id], 'method' => 'patch']) !!}

                        <div class="form-group col-sm-6">
                            {!! Form::label('actual_name', 'Nombre actual:') !!}
                            {!! Form::text('actual_name', $user->name, ['class' => 'form-control', 'readonly']) !!}
                        </div>

                        <div class="form-group col-sm-6">
                            {!! Form::label('new_name', 'Nombre nuevo:') !!}
                            {!! Form::text('new_name', null, ['class' => 'form-control', 'required']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('users.index') !!}" class="btn btn-default">Cancelar</a>
                        </div>

                    {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection