@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            {cambiar}
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model(${cambiar}, ['route' => ['{cambiar}.update', ${cambiar}->id], 'method' => 'patch']) !!}

                        @include('{cambiar}.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection