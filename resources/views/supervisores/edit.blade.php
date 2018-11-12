@extends('layouts.app')

@section('title', 'Modificar supervisor')

@section('content')
    <section class="content-header">
        <h1>
            Modificar datos de supervisor
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($supervisor, ['route' => ['supervisores.update', $supervisor->id],'id'=>'form-editar-supervisor', 'class'=>'form-horizontal', 'method' => 'patch']) !!}

                   <fieldset>
                       @include('supervisores.fields-edit')
                   </fieldset>

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection