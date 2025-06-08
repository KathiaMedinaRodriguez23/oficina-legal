/* jshint esversion: 6 */
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('mobile');
        if (!input) return;

        function formatPhone() {
            // 1) Extraer solo dígitos
            let digits = input.value.replace(/\D/g, '');
            // 2) Si hay al menos un dígito y NO es "9", lo borramos todo
            if (digits.length > 0 && digits.charAt(0) !== '9') {
                digits = '';
            }
            // 3) Limitar a 9 dígitos (9XXXXXXXX)
            digits = digits.substring(0, 9);
            // 4) Volver a volcar el valor limpio
            input.value = digits;
        }

        // 5) Enlazar eventos
        input.addEventListener('input', formatPhone);
        input.addEventListener('blur',  formatPhone);
    });
})();
