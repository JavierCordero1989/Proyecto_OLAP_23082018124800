@extends('layouts.app')

@section('title', 'Pagina de pruebas')

@section('content')

@section('css')
    <style>
        
    </style>
@endsection
    <div class="content">
        <div class="row">
            <div class="col-xs-12">
                <h2>Página de pruebas</h2>
            </div>
            <div class="col-xs-4">
                <h3>Lista desplegable</h3>
                <div class="col-xs-12">
                    <section class="sidebar">
                        {!! Form::open(['route'=>'pruebas.from']) !!}
                            <ul id="menu_areas" class="sidebar-menu">
                            </ul>

                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" value="Enviar datos">
                            </div>
                        {!! Form::close() !!}
                    </section>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            var data = <?php echo $data; ?>;

            var menu = $('#menu_areas'); //Contenedor de las areas, elemento UL

            for(var item in data) {
                var li = $('<li>', {
                    'class': 'treeview'
                }).appendTo(menu);

                var a = $('<a>', {
                    'href': '#'
                }).appendTo(li);

                $('<span>', {
                    'text': item
                }).appendTo(a);

                var span_2 = $('<span>', {
                    'class': 'pull-right-container'
                }).appendTo(a);
                
                $('<i>', {
                    'class': 'fa fa-angle-left pull-right'
                }).appendTo(span_2);
                
                var ul = $('<ul>', {
                    'class': 'treeview-menu'
                }).appendTo(li);

                var li_todos = $('<li>', {
                    'class': 'checkbox'
                }).appendTo(ul);

                var label_todos = $('<label>', {
                    'class': 'label-text'
                }).appendTo(li_todos);

                label_todos.append('<input type="checkbox" name="disciplinas[]" value="'+item+'"> Todas');

                for(var disciplina in data[item]) {
                    var sub_li = $('<li>', {
                        'class': 'checkbox'
                    }).appendTo(ul);

                    var label_check = $('<label>', {
                        'class': 'label-text'
                    }).appendTo(sub_li);
                    
                    label_check.append('<input type="checkbox" name="disciplinas[]" value="'+(data[item])[disciplina].codigo+'"> '+(data[item])[disciplina].descriptivo);
                }
            }
        </script>
    @endsection
@endsection