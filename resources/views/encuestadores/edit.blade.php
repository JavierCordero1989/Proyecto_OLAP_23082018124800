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
               <div class="container">
                   <div class="row">
                        {!! Form::model($encuestador, ['route' => ['encuestadores.update', $encuestador->id], 'id'=>'form-editar-encuestador', 'method' => 'patch', 'class'=>'form-horizontal']) !!}
    
                            <fieldset>
                                @include('encuestadores.fields-edit')
                            </fieldset>
    
                        {!! Form::close() !!}
                   </div>
               </div>
           </div>
       </div>
   </div>
@endsection