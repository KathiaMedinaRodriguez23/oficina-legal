"use strict";

var FormControlsClient = {
    init: function () {
        var btn = $("form :submit");

        $.validator.addMethod("dniOrRuc", function (value, element) {
            var dniSelected = $("#dni").is(":checked");
            if (dniSelected) {
                return /^\d{8}$/.test(value);
            } else {
                return /^(10|20)\d{9}$/.test(value);
            }
        }, function(params, element) {
            return $("#dni").is(":checked")
                ? "El DNI debe tener exactamente 8 dígitos numéricos"
                : "El RUC debe tener 11 dígitos y empezar con 10 o 20";
        });

        $("#add_client").validate({
            debug: false,
            rules: {
                f_name: "required",
                m_name: "required",
                l_name: "required",
                address: "required",
                country: "required",
                state: "required",
                city_id: "required",
                document_number: "required",
                email: {
                    email: true
                },
                mobile: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    number: true
                },
                reference_mobile: {
                    minlength: 10,
                    maxlength: 10,
                    number: true
                }
            },
            messages: {
                f_name: "Por favor, ingrese el nombre.",
                m_name: "Por favor, ingrese el segundo nombre.",
                l_name: "Por favor, ingrese el apellido.",
                user_email: "Por favor, ingrese el correo electrónico.",
                address: "Por favor, ingrese la dirección.",
                country: "Por favor, seleccione el país.",
                state: "Por favor, seleccione el estado.",
                city_id: "Por favor, seleccione la ciudad.",
                document_number: "Por favor, ingrese el documento.",
                email: "Por favor, ingrese un correo electrónico válido.",
                mobile: {
                    required: "Por favor, ingrese el número de celular.",
                    minlength: "El número debe tener 10 dígitos.",
                    maxlength: "El número debe tener 10 dígitos.",
                    number: "Por favor, ingrese solo dígitos."
                },
                reference_mobile: {
                    minlength: "El número debe tener 10 dígitos.",
                    maxlength: "El número debe tener 10 dígitos.",
                    number: "Por favor, ingrese solo dígitos."
                }
            },
            highlight: function(el) {
                $(el).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function(el) {
                $(el).addClass('is-valid').removeClass('is-invalid');
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") === "document_number") {
                    $("#error_message").empty().show().append(error.addClass('text-danger'));
                } else {
                    error.appendTo(element.parent()).addClass('text-danger');
                }
            },
            submitHandler: function () {
                $('#show_loader').removeClass('fa-save');
                $('#show_loader').addClass('fa-spin fa-spinner');
                $("button[name='btn_add_user']").attr("disabled", "disabled").button('refresh');
                return true;
            }
        });

        // Al cambiar de radio (DNI/RUC), resetear el campo
        $("input[name='document_type']").on('change', function () {
            $("#document_number").val('');
            $("#document_number").valid(); // revalida el campo
        });
    }
};

jQuery(document).ready(function () {
    FormControlsClient.init();

    $("#change_court_chk").on("click", function () {
        $('#change_court_div').toggleClass('hidden', !this.checked);
    });

    $('.two').hide();

    $('input[type=radio][name=type]').on("change", function () {
        $('.one').toggle(this.value === 'single');
        $('.two').toggle(this.value === 'multiple');
    });

    $('.repeater').repeater({
        initEmpty: false,
        defaultValues: { 'text-input': 'foo' },
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            if (confirm('Estas seguro de eliminar este elemento?')) {
                $(this).slideUp(deleteElement);
            }
        },
        isFirstItemUndeletable: false
    });
});
