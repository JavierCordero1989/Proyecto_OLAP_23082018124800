@extends('layouts.app')

@section('title', "Modificar disciplina")

@section('content')
    <section class="content-header">
        <h1>
            Modificar datos de disciplina
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($disciplina, ['route' => ['disciplinas.update', $disciplina->id], 'method' => 'patch']) !!}

                        @include('disciplinas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection