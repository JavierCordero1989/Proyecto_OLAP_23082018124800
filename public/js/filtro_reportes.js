// Carga los eventos a cada checkbox
$(document).ready(function() {
    $('[name="sector[]"]').on('click', function() {
        evento_sectores($(this));
    });

    $('[name="areas[]"]').on('click', function() {
        evento_areas($(this))
    });
});

function evento_sectores(check_seleccionado) {
    var valor_check = check_seleccionado.attr('value');
    var valor_checkeado = check_seleccionado.prop('checked');
    var grupo_checks = $('[name="sector[]"]');

    //Check de TODOS
    if(valor_check == 1) {
        $(grupo_checks).prop('checked', valor_checkeado);
    }

    // Check para sector PÚBLICO
    if(valor_check == 2) {
        if(false == check_seleccionado.prop('checked')) {
            $('#seleccionar_sectores').prop('checked', false);
        }

        if($('[name="sector[]"]:checked').length == $(grupo_checks).length-1) {
            $("#seleccionar_sectores").prop('checked', true);
        }
    }

    // Check para sector PRIVADO
    if(valor_check == 3) {
        if(false == check_seleccionado.prop('checked')) {
            $('#seleccionar_sectores').prop('checked', false);
        }

        if($('[name="sector[]"]:checked').length == $(grupo_checks).length-1) {
            $("#seleccionar_sectores").prop('checked', true);
        }
    }

    //Se crea un arreglo para guardar los IDS seleccionados.
    var valores_checks = [];

    //Se recorre el grupo de checks y se comprueba los que están seleccionados.
    grupo_checks.each(function() {
        if(this.checked) {
            // Se agrega el valor del check al arreglo.
            valores_checks.push($(this).val());
        }
    });

    //Envío de datos al controlador para procesarlos.
    $.ajax({
        cache: false,
        type: 'get',
        dataType: 'json',
        data: {
            valores:valores_checks
        },
        url: '{{ route("universidades.sector") }}',
        beforeSend: function() {
            console.log('beforeSend: ', valores_checks);
        },
        success: function(respuesta) {
            console.log('success: ', respuesta.mensaje);
            cargarUniversidades(respuesta.datos_obtenidos);
        },
        error: function(jqXHR, respuesta_servidor, errorThrown) {
            alert("AJAX error: " + respuesta_servidor + ' : ' + errorThrown);
        }
    });
}

function evento_areas(check_seleccionado) {
    console.log('Área: ', check_seleccionado.attr('value'));
}

//Llena la caja con los datos de las universidades que se seleccionaron.
function cargarUniversidades(data) {
    // Se vacía el contenedor
    $('#contenedor-general-universidades').html('');

    if(data.length <= 0) {
        //Se oculta el contenedor de universidades
        $('#contenedor_universidades').addClass('hide');
        $('#contenedor_universidades').removeClass('show');
    }
    else {
        //se muestra lo que trae el objeto data
        $('#contenedor_universidades').removeClass('hide');
        $('#contenedor_universidades').addClass('show');

        $('#contenedor-general-universidades').append('<input type="checkbox" id="seleccionar_universidades" name="seleccionar_universidades"> Todas <br>');
        
        //Se recorre el objeto data, para mostrar su información en la caja de las universidades
        data.forEach(function(element) {
            $('#contenedor-general-universidades').append('<input type="checkbox" name="universidades[]" value="'+element.id+'"> '+element.nombre+'<br>');
        });
    }

    //Agregar eventos para los checks recién creados.
    $('[name="universidades[]"]').on('click', function() {
        evento_universidades($(this));
    });
}

function evento_universidades(check_seleccionado) {
    console.log('Universidad: ', check_seleccionado.attr('value'));
}