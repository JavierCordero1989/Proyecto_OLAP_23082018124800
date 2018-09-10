@extends('layouts.app')

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
                   {!! Form::model($detalle, ['route' => ['detalles.update', $detalle->id], 'method' => 'patch']) !!}

                        @include('detalles_contactos.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection