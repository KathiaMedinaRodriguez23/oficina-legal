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

        // 2) Ajusta label, placeholder y maxlength según tipo
        function handleDocTypeChange() {
            var isDni = $('#dni').is(':checked');
            var $input     = $("#document_number");
            var $label     = $("#dni_ruc_label");
            var $nameGroup = $('#f_name, #m_name, #l_name');
            var $gender    = $('#genderM, #genderF');
            var $rucGroup  = $('#razon_social');

            // Reset UI
            $input.val('').removeClass('is-valid is-invalid');
            $("#error_message").hide();
            $label.find('span.text-danger').remove(); // evitar duplicados
            $label.append('<span class="text-danger">*</span>');

            // Ajustes de placeholder/maxlength
            if (isDni) {
                $input.attr({ maxlength: 8, placeholder: "Ej: 01234567" });
            } else {
                $input.attr({ maxlength: 11, placeholder: "Ej: 20123456789" });
            }

            // Mostrar/ocultar bloques
            $('.block-dni').toggle(isDni);
            $('#block-gender').toggle(isDni);
            $('#block-ruc').toggle(!isDni);

            // ——— Aquí viene la clave ———
            // 1) Deshabilitar o habilitar inputs según tipo:
            $nameGroup
                .prop('disabled', !isDni)
                .toggleClass('disabled', !isDni);
            $gender
                .prop('disabled', !isDni)
                .toggleClass('disabled', !isDni);
            $rucGroup
                .prop('disabled',  isDni)
                .toggleClass('disabled', isDni);

            // 2) Ajustar required sólo en los visibles:
            $nameGroup.prop('required', isDni);
            $gender   .prop('required', isDni);
            $rucGroup .prop('required', !isDni);
        }

        // 3) Ejecuta al inicio y cuando cambie el tipo
        handleDocTypeChange();
        $('input[name="document_type"]').on('change', function(){
            handleDocTypeChange();
            $('#document_number').valid();
        });

        // 4) Inicializa el validateur de jQuery
        $("#add_client").validate({
            debug: false,
            rules: {
                address: "required",
                country: "required",
                state: "required",
                city_id: "required",
                document_number: { required: true, dniOrRuc: true },
                email: { required: true, email: true },
                mobile: { required: true, minlength: 9, maxlength: 9, number: true },
                reference_mobile: { minlength: 9, maxlength: 9, number: true }
            },
            messages: {
                address: "Por favor, ingrese la dirección.",
                country: "Por favor, seleccione el país.",
                state: "Por favor, seleccione el estado.",
                city_id: "Por favor, seleccione la ciudad.",
                document_number: "Por favor, ingrese el documento.",
                email: "Por favor, ingrese un correo electrónico válido.",
                mobile: {
                    required: "Por favor, ingrese el número de celular.",
                    minlength: "El número debe tener 9 dígitos.",
                    maxlength: "El número debe tener 9 dígitos.",
                    number: "Por favor, ingrese solo dígitos."
                },
                reference_mobile: {
                    minlength: "El número debe tener 9 dígitos.",
                    maxlength: "El número debe tener 9 dígitos.",
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
                $('#show_loader').removeClass('fa-save').addClass('fa-spin fa-spinner');
                $("button[name='btn_add_user']").attr("disabled", "disabled").button('refresh');
                return true;
            }
        });

        // 5) *** Nuevo: restringir tecleo en RUC ***
        $("#document_number").on('keypress', function(e) {
            var isRUC = $("#ruc").is(":checked");
            if (!isRUC) return;

            var char = String.fromCharCode(e.which);
            var val  = this.value;

            // solo dígitos
            if (!/^\d$/.test(char)) {
                e.preventDefault();
                return;
            }
            // primer carácter: solo 1 o 2
            if (val.length === 0 && !/^[12]$/.test(char)) {
                e.preventDefault();
                return;
            }
            // segundo carácter: solo 0 (para formar 10 o 20)
            if (val.length === 1 && char !== '0') {
                e.preventDefault();
                return;
            }
            // máximo 11 dígitos
            if (val.length >= 11) {
                e.preventDefault();
                return;
            }
        });

        // 6) Re-validar selects al cambiar
        $('#country, #state, #city_id').on('change', function(){
            $(this).valid();
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
        show: function () { $(this).slideDown(); },
        hide: function (deleteElement) {
            if (confirm('¿Estás seguro de eliminar este elemento?')) {
                $(this).slideUp(deleteElement);
            }
        },
        isFirstItemUndeletable: false
    });
});
