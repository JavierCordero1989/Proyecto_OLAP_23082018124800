@extends('layouts.app')

@section('title', "Modificar carrera")

@section('content')
    <section class="content-header">
        <h1>
            Modificar datos de carrera
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($carrera, ['route' => ['carreras.update', $carrera->id], 'method' => 'patch']) !!}

                        @include('carreras.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection