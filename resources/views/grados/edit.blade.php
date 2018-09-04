@extends('layouts.app')

@section('title', "Modificar grado")

@section('content')
    <section class="content-header">
        <h1>
            Modificar datos del grado
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($grado, ['route' => ['grados.update', $grado->id], 'method' => 'patch']) !!}

                        @include('grados.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection