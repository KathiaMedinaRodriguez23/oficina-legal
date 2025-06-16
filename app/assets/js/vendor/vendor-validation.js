"use strict";
var checkExistRoute = $('#route-exist-check').val();
var token = $('#token-value').val();
var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");
        $("#add_client").validate({
            debug: false,
            rules: {
                f_name: "required",
               // m_name: "required",
                l_name: "required",
                address: "required",
                country: "required",
                state: "required",
                city_id: "required",
                email: {
                    email: true,
                },
                mobile: {
                    required: true,
                    minlength: 9,
                    maxlength: 9,
                    number: true
                },
                alternate_no: {
                    required: false,
                    minlength: 8,
                    maxlength: 8,
                    number: true
                },
                reference_mobile: {
                    required: false,
                    minlength: 9,
                    maxlength: 9,
                    number: true
                }
            },
            messages: {
                f_name: "Por favor, ingrese el nombre.",
               // m_name: "Por favor, ingrese el segundo nombre.",
                l_name: "Por favor, ingrese el apellido.",
                address: "Por favor, ingrese la dirección.",
                country: "Por favor, seleccione el país.",
                state: "Por favor, seleccione el estado.",
                city_id: "Por favor, seleccione la ciudad.",

                email: {
                    email: "Por favor, ingrese un correo electrónico válido.",
                },
                mobile: {
                    required: "Por favor, ingrese el número de celular.",
                    minlength: "El número de celular debe tener 9 dígitos.",
                    maxlength: "El número de celular debe tener 9 dígitos.",
                    number: "Por favor, ingrese solo dígitos del 0 al 9."
                },
                alternate_no: {
                    required: "Por favor, ingrese el número alternativo.",
                    minlength: "El número debe tener 9 dígitos.",
                    maxlength: "El número debe tener 9 dígitos.",
                    number: "Por favor, ingrese solo dígitos del 0 al 9."
                },
                reference_mobile: {
                    required: "Por favor, ingrese el número de referencia.",
                    minlength: "El número debe tener 9 dígitos.",
                    maxlength: "El número debe tener 9 dígitos.",
                    number: "Por favor, ingrese solo dígitos del 0 al 9."
                }
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function () {
                $('#show_loader').removeClass('fa-save');
                $('#show_loader').addClass('fa-spin fa-spinner');
                $("button[name='btn_add_user']").attr("disabled", "disabled").button('refresh');
                return true;
            }
        })
    }

};
jQuery(document).ready(function () {
    FormControlsClient.init();

    //set initial state.
    $("#change_court_chk").on("click", function () {
        if ($(this).is(":checked")) {

            var returnVal = this.value;
            if (returnVal == 'Yes') {
                $('#change_court_div').removeClass('hidden');
            }
        } else {
            $('#change_court_div').addClass('hidden');
        }
    });

    $('.two').css('display', 'none');

    $('input[type=radio][name=type]').on("change", function () {

        if (this.value == 'single') {
            $('.one').css('display', 'block');
            $('.two').css('display', 'none');
        } else if (this.value == 'multiple') {
            $('.two').css('display', 'block');
            $('.one').css('display', 'none');
        }

    });

    $('.repeater').repeater({
        initEmpty: false,
        defaultValues: {
            'text-input': 'foo'
        },
        show: function () {
            $(this).slideDown();
            var id = $(this).find('[type="text"]').attr('id');
            var label = $(this).find('label');
            label.attr('for', id);
            $(this).addClass('fade-in-info').slideDown();
        },
        hide: function (deleteElement) {
            if (confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement);
            }
        },
        isFirstItemUndeletable: false
    })
});
