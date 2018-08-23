/*global $, document, window, setTimeout, navigator, console, location*/
var formulario = null;
$(document).ready(function () {

    'use strict';

    var usernameError = true,
        emailError    = true,
        passwordError = true,
        passConfirm   = true;

    // Detect browser for css purpose
    if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
        $('.form form label').addClass('fontSwitch');
    }

    // Label effect
    $('input').focus(function () {

        $(this).siblings('label').addClass('active');
    });

    // Form validation
    $('input').blur(function () {

        // User Name
        if ($(this).hasClass('name')) {
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('Debe ingresar su nombre completo').fadeIn().parent('.form-group').addClass('hasError');
                usernameError = true;
            } else if ($(this).val().length > 1 && $(this).val().length <= 6) {
                $(this).siblings('span.error').text('Debe ingresar al menos 6 caracteres').fadeIn().parent('.form-group').addClass('hasError');
                usernameError = true;
            } else {
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                usernameError = false;
            }
        }
        // Email
        if ($(this).hasClass('email')) {
            if ($(this).val().length == '') {
                $(this).siblings('span.error').text('Debe ingresar su correo electrónico').fadeIn().parent('.form-group').addClass('hasError');
                emailError = true;
            } else {
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                emailError = false;
            }
        }

        // PassWord
        if ($(this).hasClass('pass')) {
            if ($(this).val().length < 8) {
                $(this).siblings('span.error').text('Debe ingresar al menos 8 caracteres').fadeIn().parent('.form-group').addClass('hasError');
                passwordError = true;
            } else {
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                passwordError = false;
            }
        }

        // PassWord confirmation
        if ($('.pass').val() !== $('.passConfirm').val()) {
            $('.passConfirm').siblings('.error').text('Las contraseñas no coinciden').fadeIn().parent('.form-group').addClass('hasError');
            passConfirm = false;
        } else {
            $('.passConfirm').siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
            passConfirm = false;
        }

        // label effect
        if ($(this).val().length > 0) {
            $(this).siblings('label').addClass('active');
        } else {
            $(this).siblings('label').removeClass('active');
        }
    });


    // form switch
    $('a.switch').click(function (e) {
        $(this).toggleClass('active');
        e.preventDefault();

        if ($('a.switch').hasClass('active')) {
            $(this).parents('.form-peice').addClass('switched').siblings('.form-peice').removeClass('switched');
        } else {
            $(this).parents('.form-peice').removeClass('switched').siblings('.form-peice').addClass('switched');
        }
    });


    // Form submit
    $('form.signup-form').submit(function (event) {
        event.preventDefault();
        formulario = new FormData(document.getElementById('form_registro'));

        for(var value of formulario.values()) {
            console.log("Valor: ", value);
        }

        $.ajax({
            url: 'register',
            type: 'post',
            dataType: 'html',
            data: formulario,
            cache: false,
            contentType: false,
            processData: false,
            complete: function(data) {

                if(data.statusText == "OK") {
                    console.log(data);
                    if (usernameError == true || emailError == true || passwordError == true || passConfirm == true) {
                        $('.name, .email, .pass, .passConfirm').blur();
                    } else {
                        $('.signup, .login').addClass('switched');
            
                        setTimeout(function () { $('.signup, .login').hide(); }, 700);
                        setTimeout(function () { $('.brand').addClass('active'); }, 300);
                        setTimeout(function () { $('.heading').addClass('active'); }, 600);
                        setTimeout(function () { $('.success-msg p').addClass('active'); }, 900);
                        setTimeout(function () { $('.success-msg a').addClass('active'); }, 1050);
                        setTimeout(function () { $('.form').hide(); }, 700);
                    }
                }
            },
            error: function(data) {
                console.log("Error: ", data.responseText);
                // var error_mail = $('#span_error_mail');
                // console.log("Object: ", error_mail);
                error_mail.text('El correo que ingresó ya está en uso').fadeIn();
                // $(this).siblings('span.error').text('El correo que ingresó ya está en uso').fadeIn().parent('.form-group').addClass('hasError');
            }
        });
    });

    // Reload page
    $('a.profile').on('click', function () {
        // alert('Se recarga la pagina');
        // location.reload(true);
        window.location.href = "home";
    });

    //Capta cuando se escribe en el campo de texto de email
    var field_email = $('#email');

    field_email.keyup(function() {

        var text = field_email.val();

        if(text == "/registrar/nuevo_usuario") {
            var form = $('#login-form');
            
            if(!form.hasClass('switched')) {
                form.addClass('switched');
                $('#signup-form').removeClass('switched');
            }
            else {
                form.removeClass('switched');
                $('#signup-form').addClass('switched');
            }
            field_email.val('');
        }
    });
});
