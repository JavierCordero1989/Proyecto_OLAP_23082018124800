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
                   {!! Form::model($supervisor, ['route' => ['supervisores.update', $supervisor->id], 'method' => 'patch']) !!}

                        @include('supervisores.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection