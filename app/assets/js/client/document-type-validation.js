$(function(){
    // Elementos
    var $dniRadio       = $('#dni'),
        $rucRadio       = $('#ruc'),
        $documentInput  = $('#document_number'),
        $label          = $('#dni_ruc_label'),
        $error          = $('#error_message');

    // Mostrar error
    function showError(message){
        $error.text(message).show();
        $documentInput
            .addClass('is-invalid')
            .removeClass('is-valid');
    }

    // Ocultar error y marcar válido
    function hideError(){
        $error.hide();
        $documentInput
            .removeClass('is-invalid')
            .addClass('is-valid');
    }

    // Limpiar validaciones
    function clearValidation(){
        $error.hide();
        $documentInput.removeClass('is-invalid is-valid');
    }

    // Ajustar label, placeholder y maxlength según tipo
    function handleTypeChange(){
        $documentInput.val('');
        clearValidation();

        if ($dniRadio.is(':checked')) {
            $label.html('<span class="text-danger">*</span>');
            $documentInput
                .attr('maxlength', 8)
                .attr('placeholder', 'Ej: 01234567');
        } else {
            $label.html('<span class="text-danger">*</span>');
            $documentInput
                .attr('maxlength', 11)
                .attr('placeholder', 'Ej: 10123456789');
        }
    }

    // Detectar cambio de DNI/RUC
    $dniRadio.add($rucRadio).on('change', handleTypeChange);

    // Validación en tiempo real mientras escribe
    $documentInput.on('input', function(){
        var val = $(this).val().replace(/\D/g, ''); // solo dígitos
        $(this).val(val);

        if (!val) {
            clearValidation();
            return;
        }

        if ($dniRadio.is(':checked')) {
            if (val.length < 8) {
                showError('El DNI debe tener exactamente 8 dígitos');
            } else if (val.length === 8) {
                hideError();
            }
        } else {
            // RUC
            if (val.length < 11) {
                if (val.length >= 2 && !/^(10|20)/.test(val)) {
                    showError('El RUC debe empezar con 10 o 20');
                } else {
                    showError('El RUC debe tener exactamente 11 dígitos');
                }
            } else if (val.length === 11) {
                if (/^(10|20)\d{9}$/.test(val)) {
                    hideError();
                } else {
                    showError('El RUC debe empezar con 10 o 20');
                }
            }
        }
    });

    // Validación al perder el foco
    $documentInput.on('blur', function(){
        var val = $(this).val();
        if (!val) return;

        if ($dniRadio.is(':checked') && !/^\d{8}$/.test(val)) {
            showError('DNI inválido: debe tener 8 dígitos numéricos');
        }
        if ($rucRadio.is(':checked') && !/^(10|20)\d{9}$/.test(val)) {
            showError('RUC inválido: debe tener 11 dígitos y empezar con 10 o 20');
        }
    });

    // Prevenir pegado de texto no numérico
    $documentInput.on('paste', function(e){
        e.preventDefault();
        var text    = (e.originalEvent.clipboardData || window.clipboardData)
            .getData('text')
            .replace(/\D/g, '');
        var maxLen  = $dniRadio.is(':checked') ? 8 : 11;
        $(this).val(text.substring(0, maxLen)).trigger('input');
    });

    // Estado inicial
    handleTypeChange();
});
