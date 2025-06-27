$(function(){
    // Elementos
    var $dniRadio  = $('#dni'),
        $rucRadio  = $('#ruc'),
        $docInput  = $('#document_number'),
        $error     = $('#error_message');

    // Bloques de campos
    var $blockDni    = $('#block-dni'),
        $blockRuc    = $('#block-ruc'),
        $blockGender = $('#block-gender'),
        $blockEmail  = $('#block-email'),
        $blockPhone  = $('#block-phone');

    // Campos individuales
    var $firstName   = $('#f_name'),
        $middleName  = $('#m_name'),
        $lastName    = $('#l_name'),
        $razonSocial = $('#razon_social');

    var $nameFields = $('#f_name, #m_name, #l_name').closest('.form-group');

    // 1) Si usas InputMask u otro plugin que borre el valor, quítalo:
    if ($.fn.inputmask) {
        $docInput.inputmask('remove');
    }

    // Capturamos lo que vino del servidor
    var origVal = $docInput.val();

    // Variable para controlar si es la primera carga
    var isInitialLoad = true;

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

    // Ajustar placeholder y maxlength según tipo
    function handleTypeChange(){
        clearValidation();

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

    function toggleNameVsRazon(){
        var isDni = $dniRadio.is(':checked');

        // ➤ Mostrar/ocultar bloques completos
        $nameFields.toggle(isDni);
        $blockRuc.toggle(!isDni);
        $blockGender.toggle(isDni);

        // ➤ Ajustar required sólo en los campos visibles
        $firstName  .prop('required', isDni);
        $lastName   .prop('required', isDni);
        $('#genderM, #genderF').prop('required', isDni);
        $razonSocial.prop('required', !isDni);

        // ➤ Limpiar valores y estados de validación de los ocultos
        if (isDni) {
            $razonSocial.val('').removeClass('is-valid is-invalid');
        } else {
            $firstName.add($middleName).add($lastName)
                .val('').removeClass('is-valid is-invalid');
            $blockGender.find('input').prop('checked', false);
        }

        // ➤ Ajustar ancho de email y teléfono
        if (!isDni) {
            $blockEmail
                .removeClass('col-md-4').addClass('col-md-6');
            $blockPhone
                .removeClass('col-md-4').addClass('col-md-6');
        } else {
            $blockEmail
                .removeClass('col-md-6').addClass('col-md-4');
            $blockPhone
                .removeClass('col-md-6').addClass('col-md-4');
        }

        // ➤ Re-validar si ya usas jQuery Validate
        if ($firstName.valid) {
            $firstName.add($lastName).add($razonSocial).add($('#genderM, #genderF')).valid();
        }
    }

    // Detectar cambio de DNI/RUC
    $dniRadio.add($rucRadio).on('change', function() {
        if (!isInitialLoad) {
            $docInput.val('');
        }
        handleTypeChange();
        toggleNameVsRazon();
        isInitialLoad = false;
    });

    function setInitialDocumentType() {
        var v = $docInput.val();
        if (v.length === 8 && /^\d{8}$/.test(v)) {
            $dniRadio.prop('checked', true);
        } else if (v.length === 11 && /^(10|20)\d{9}$/.test(v)) {
            $rucRadio.prop('checked', true);
        }
    }

    // ---------- INICIALIZACIÓN ----------
    setInitialDocumentType();
    handleTypeChange();

    // 3) ¡Reponemos el valor que vino del servidor!
    setTimeout(function(){
        $docInput.val(origVal);
    }, 0);

    // Validación en tiempo real
    $docInput.on('input', function(){
        var val = $(this).val().replace(/\D/g, '');
        if ($dniRadio.is(':checked')) {
            val = val.substring(0, 8);
            $(this).val(val);
            if (val.length === 8) hideError();
            else clearValidation();
        } else {
            val = val.substring(0, 11);
            if (val.length >= 2 && !/^(10|20)$/.test(val.substring(0,2))) {
                showError('El RUC debe empezar con 10 o 20');
                $(this).val('');
                return;
            }
            $(this).val(val);
            if (val.length === 11) hideError();
            else clearValidation();
        }
    });

    // Validación al perder foco
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
        var text = (e.originalEvent.clipboardData||window.clipboardData)
            .getData('text').replace(/\D/g, '');
        text = $dniRadio.is(':checked')
            ? text.substring(0,8)
            : text.substring(0,11);
        $(this).val(text).trigger('input');
    });
});
