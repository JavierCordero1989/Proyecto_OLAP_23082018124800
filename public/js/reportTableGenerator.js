function generar_tabla_reporte(datos_reporte, id_titulo, id_fecha, id_tabla) {
    // var datos_reporte = @php echo $reporte_areas_ucr; @endphp //Se obtienen los datos provenientes del servidor

    var data = datos_reporte.data;
    var totales = datos_reporte.total;

    $('#' + id_titulo).text(datos_reporte.titulo); //Se obtiene la etiqueta para el titulo de la tabla
    $('#' + id_fecha).text('Fecha: ' + datos_reporte.fecha); //Se obtiene la etiqueta para la fecha de la tabla

    var tabla = $('#' + id_tabla); // Se obtiene la tabla completa
    
    var cuerpo_tabla = $('<tbody>').appendTo(tabla); // Se crea el cuerpo de la tabla, y se incluye en la tabla

    // for para recorrer las areas
    for(var area in data) {
        // for recorrer las disciplinas
        for(var disciplina in data[area]) {
            // se crea la fila y se anexa al cuerpo de la tabla
            var fila = $('<tr>').appendTo(cuerpo_tabla);
                
            // si la disciplina es la primera, se agrega un columna con el nombre del area,
            // que abarcara el total de filas igual al numero de disciplinas.
            if(disciplina == 0) {
                // se crea una columna td y se anexa a la fila
                $('<th>', {
                    'rowspan': data[area].length
                }).text(area).appendTo(fila);

                // se recorren los datos de cada disciplina
                for(var dato in data[area][disciplina]) {
                    // se agrega una columna td y se anexa a la fila
                    $('<th>').text(data[area][disciplina][dato]).appendTo(fila);
                }
            }
            else {
                // se recorren los datos de cada disciplina
                for(var dato in data[area][disciplina]) {
                    // se agrega una columna td y se anexa a la fila
                    $('<td>').text(data[area][disciplina][dato]).appendTo(fila);
                }
            }
        }
    }

    // se crea el pie para la tabla, y se anexa a la tabla en general.
    var pie_tabla = $('<tfoot>').appendTo(tabla);
    $('<th>').appendTo(pie_tabla);
    $('<th>').text('Total').appendTo(pie_tabla);

    for(var dato in totales) {
        $('<th>').text(totales[dato]).appendTo(pie_tabla);
    }

    $('<th>').appendTo(pie_tabla);
}

function generar_reporte_general(datos_reporte) {
    var reporte_general = $('#reporte_general');

    var cuerpo_reporte = $('<tbody>').appendTo(reporte_general);

    var titulo = $('#titulo_reporte').text(datos_reporte.titulo);
    var data = datos_reporte.data;

    for(var i in data) {
        var fila = $('<tr>').appendTo(cuerpo_reporte);
        for(var j in data[i]) {
            $('<td>').text(data[i][j]).appendTo(fila);
        }
    }

    var pie_tabla = $('<tfoot>').appendTo(reporte_general);
    $('<th>').text('Total').appendTo(pie_tabla);

    for(var i in datos_reporte.total) {
        $('<th>').text(datos_reporte.total[i]).appendTo(pie_tabla);
    }
}