@extends('layouts.app')

@section('title', 'Modificar encuestador')

@section('content')
    <section class="content-header">
        <h1>
            Modificar datos de encuestador
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($encuestador, ['route' => ['encuestadores.update', $encuestador->id], 'method' => 'patch']) !!}

                        @include('encuestadores.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection