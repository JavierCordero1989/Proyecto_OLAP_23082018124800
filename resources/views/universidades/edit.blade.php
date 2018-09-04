@extends('layouts.app')

@section('title', "Modificar universidad")

@section('content')
    <section class="content-header">
        <h1>
            Modificar datos de universidad
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($universidad, ['route' => ['universidades.update', $universidad->id], 'method' => 'patch']) !!}

                        @include('universidades.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection