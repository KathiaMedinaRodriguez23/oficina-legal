$(function(){
    // Elementos
    var $dniRadio       = $('#dni'),
        $rucRadio       = $('#ruc'),
        $docInput       = $('#document_number'),
        $label          = $('#dni_ruc_label'),
        $error          = $('#error_message');

    // Mostrar error
    function showError(message){
        $error.text(message).show();
        $docInput
            .addClass('is-invalid')
            .removeClass('is-valid');
    }

    // Ocultar error y marcar válido
    function hideError(){
        $error.hide();
        $docInput
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    // Limpiar validaciones
    function clearValidation(){
        $error.hide();
        $docInput.removeClass('is-invalid is-valid');
    }

    // Ajustar label, placeholder y maxlength según tipo
    function handleTypeChange(){
        clearValidation();
        $docInput.val('');

        if ($dniRadio.is(':checked')) {
            $docInput
                .attr('maxlength', 8)
                .attr('placeholder', 'Ej: 01234567');
        } else {
            $docInput
                .attr('maxlength', 11)
                .attr('placeholder', 'Ej: 20123456789');
        }
    }

    // Detectar cambio de DNI/RUC
    $dniRadio.add($rucRadio).on('change', handleTypeChange);

    // Validación en tiempo real mientras escribe
    $docInput.on('input', function(){
        var val = $(this).val().replace(/\D/g, ''); // solo dígitos

        if ($dniRadio.is(':checked')) {
            // DNI: exactamente 8 dígitos, permite empezar en 0
            val = val.substring(0, 8);
            $(this).val(val);

            if (val.length === 8) {
                hideError();
            } else {
                clearValidation();
            }

        } else {
            // RUC: exactamente 11 dígitos, debe empezar 10 o 20
            val = val.substring(0, 11);

            // si ya hay al menos 2 dígitos, validar prefijo
            if (val.length >= 2) {
                var prefix = val.substring(0, 2);
                if (!/^(10|20)$/.test(prefix)) {
                    showError('El RUC debe empezar con 10 o 20');
                    $(this).val('');
                    return;
                }
            }

            $(this).val(val);

            if (val.length === 11) {
                hideError();
            } else {
                clearValidation();
            }
        }
    });

    // Validación al perder el foco
    $docInput.on('blur', function(){
        var val = $(this).val();
        if (!val) return;

        if ($dniRadio.is(':checked') && val.length !== 8) {
            showError('El DNI debe tener exactamente 8 dígitos');
        }
        if ($rucRadio.is(':checked') && !/^(10|20)\d{9}$/.test(val)) {
            showError('El RUC debe tener 11 dígitos y empezar con 10 o 20');
        }
    });

    // Prevenir pegado de texto no numérico
    $docInput.on('paste', function(e){
        e.preventDefault();
        var text = (e.originalEvent.clipboardData || window.clipboardData)
            .getData('text')
            .replace(/\D/g, '');
        // recortar a la longitud adecuada
        if ($dniRadio.is(':checked')) {
            text = text.substring(0, 8);
        } else {
            text = text.substring(0, 11);
        }
        $(this).val(text).trigger('input');
    });

    // Estado inicial
    handleTypeChange();
});
