@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Nueva información de contacto
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => ['detalles.store', 'id'=>$id_contacto]]) !!}

                        @include('detalles_contactos.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
