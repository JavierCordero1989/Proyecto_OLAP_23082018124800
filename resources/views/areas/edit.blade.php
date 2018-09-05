@extends('layouts.app')

@section('title', "Modificar área")

@section('content')
    <section class="content-header">
        <h1>
            Modificar datos del área
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($area, ['route' => ['areas.update', $area->id], 'method' => 'patch']) !!}

                        @include('areas.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection