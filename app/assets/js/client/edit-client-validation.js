"use strict";

// Rutas y tokens inyectados en tu Blade
var checkExistRoute       = $('#route-exist-check').val();
var token                 = $('#token-value').val();

var FormControlsClient = {

    init: function () {

        $.validator.addMethod("dniOrRuc", function (value, element) {
            if ($("#dni").is(":checked")) {
                return /^\d{8}$/.test(value);
            } else {
                return /^(10|20)\d{9}$/.test(value);
            }
        }, function () {
            return $("#dni").is(":checked")
                ? "El DNI debe tener exactamente 8 dígitos numéricos"
                : "El RUC debe tener 11 dígitos y comenzar con 10 o 20";
        });

        function handleDocTypeChange() {
            var $input = $("#document_number"),
                $label = $("#dni_ruc_label");

            $("#error_message").hide();

            if ($("#dni").is(":checked")) {
                $label.html('<span class="text-danger">*</span>');
                $input
                    .attr("maxlength", 8)
                    .attr("placeholder", "Ej: 01234567");
            } else {
                $label.html('<span class="text-danger">*</span>');
                $input
                    .attr("maxlength", 11)
                    .attr("placeholder", "Ej: 20123456789");
            }
        }

        handleDocTypeChange();

        $("input[name='document_type']").on('change', function () {
            $("#document_number")
                .val('')
                .removeClass('is-invalid is-valid');
            handleDocTypeChange();
            $("#document_number").valid();
        });

        $("#document_number").on('keypress', function (e) {
            if (!$("#ruc").is(":checked")) return;
            var char = String.fromCharCode(e.which),
                val  = this.value;
            if (!/^\d$/.test(char)) { e.preventDefault(); return; }
            if (val.length === 0 && !/^[12]$/.test(char)) { e.preventDefault(); return; }
            if (val.length === 1 && char !== '0') { e.preventDefault(); return; }
            if (val.length >= 11) { e.preventDefault(); return; }
        });

        // 4) Inicializa validación jQuery Validate
        $("#edit_client_form").validate({
            debug: false,
            rules: {
                f_name:           "required",
                m_name:           "required",
                l_name:           "required",
                address:          "required",
                country:          "required",
                state:            "required",
                city_id:          "required",
                document_number:  { required: true, dniOrRuc: true },
                email: {
                    required: true,
                    email:    true,
                },
                mobile: {
                    required: true,
                    minlength: 9,
                    maxlength: 9,
                    number:    true,
                },
                reference_mobile: {
                    minlength: 10,
                    maxlength: 10,
                    number:    true
                }
            },
            messages: {
                f_name:  "Ingrese el nombre.",
                m_name:  "Ingrese el segundo nombre.",
                l_name:  "Ingrese el apellido.",
                address: "Ingrese la dirección.",
                country: "Seleccione el país.",
                state:   "Seleccione el estado.",
                city_id: "Seleccione la ciudad.",
                document_number: {
                    required: "Por favor, ingrese el documento."
                },
                email: {
                    required: "Por favor, ingrese el correo.",
                    email:    "Por favor, ingrese un correo válido.",
                    remote:   "Este correo ya está registrado."
                },
                mobile: {
                    required: "Por favor, ingrese el móvil.",
                    minlength:"El móvil debe tener 9 dígitos.",
                    maxlength:"El móvil debe tener 9 dígitos.",
                    number:   "Por favor, ingrese solo dígitos.",
                    remote:   "Este móvil ya está registrado."
                },
                reference_mobile: {
                    minlength:"El número debe tener 9 dígitos.",
                    maxlength:"El número debe tener 9 dígitos.",
                    number:   "Por favor, ingrese solo dígitos."
                }
            },
            highlight: function (el) {
                $(el).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function (el) {
                $(el).addClass('is-valid').removeClass('is-invalid');
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") === "document_number") {
                    $("#error_message").empty().show().append(error.addClass('text-danger'));
                } else {
                    error.appendTo(element.parent()).addClass('text-danger');
                }
            },
            submitHandler: function () {
                $('#show_loader').removeClass('fa-save').addClass('fa-spin fa-spinner');
                $("button[name='btn_update_user']").attr("disabled", true);
                return true;
            }
        });
    }
};

jQuery(document).ready(function () {
    FormControlsClient.init();

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

    $('input[type=radio][name=type]').on("change", function () {

        if (this.value == 'single') {
            $('.one').css('display', 'block');
            $('.two').css('display', 'none');
        }

        else if (this.value == 'multiple') {
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
            label.attr('for',id);
            $(this).addClass('fade-in-info').slideDown();
        },
        hide: function (deleteElement) {
            if (confirm('¿Estás seguro de eliminar este elemento?')) {
                $(this).slideUp(deleteElement);
            }
        },
        isFirstItemUndeletable: false
    });
});
