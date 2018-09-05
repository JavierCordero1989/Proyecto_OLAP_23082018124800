@extends('layouts.app')

@section('css')
    {{-- <!-- Bootstrap version 4.1.3--> --}}
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> --}}
    <!-- CSS para las letras del modal -->
    <link rel="stylesheet" href="{{ asset('css/modal_letters.css') }}">
@endsection

@section('title', "Subir archivo")

@section('content')

    {{-- CSS para las letras del modal --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/modal_letters.css') }}"> --}}

    <section class="content-header">
        <h1>
            Importar Excel a Base de Datos
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'excel.import', 'files' => 'true', 'id'=>'form_importar_excel', 'onsubmit'=>'return eventoModalFormulario();']) !!}

                        @include('excel.importar_archivo')

                    {!! Form::close() !!}

                    @include('modals.loading_letters')
                    @include('modals.mensaje')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts') 
    <!-- Script para las letras del modal -->
    <script src="{{ asset('js/jquery.lettering-0.6.1.min.js') }}"></script>

    <!-- Script para que las letras puedan tener su efecto de movimiento -->    
    <script>$(".loading").lettering();</script>

    <!-- Script para obtener los datos del formulario y realizar la peticion AJAX -->
    <script>
        function eventoModalFormulario() {
            // $('#modalLoadingLetters').modal('show');
            return true;
        }

        // $(function(){
        //     $('#form_importar_excel').on('submit', function(e) {
        //         e.preventDefault();
        //         var f = $(this);

        //         //Se obtiene el formulario
        //         var formData = new FormData(document.getElementById('form_importar_excel'));

        //         $.ajax({
        //             url: document.getElementById('form_importar_excel').action,
        //             type: 'post',
        //             dataType: 'html',
        //             data: formData,
        //             cache: false,
        //             contentType: false,
        //             processData: false,
        //             beforeSend: function() {
        //                 $('#modalLoadingLetters').modal('show');
        //             },
        //             success: function(result) {
        //                 $('#modalLoadingLetters').modal('hide');
        //                 $('#success-text').html('Se han guardado correctamente todos los registros');
        //                 $('#modal-success').modal('show');
        //                 console.log("Success: ", result);
        //             }
        //         });
        //     });
        // });

        // eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('$(0(){$(\'#3\').l(\'r\',0(e){e.v();b f=$(n);b 9=s t(7.5(\'3\'));$.d({g:7.5(\'3\').h,i:\'j\',k:\'6\',m:9,H:4,o:4,p:4,q:0(){$(\'#8\').1(\'a\')},2:0(c){$(\'#8\').1(\'w\');$(\'#2-x\').6(\'y z A B C D E\');$(\'#1-2\').1(\'a\');F.G("u: ",c)}})})});',44,44,'function|modal|success|form_importar_excel|false|getElementById|html|document|modalLoadingLetters|formData|show|var|result|ajax|||url|action|type|post|dataType|on|data|this|contentType|processData|beforeSend|submit|new|FormData|Success|preventDefault|hide|text|Se|han|guardado|correctamente|todos|los|registros|console|log|cache'.split('|'),0,{}))
    </script>
@endsection