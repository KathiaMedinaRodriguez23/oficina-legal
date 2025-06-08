/* jshint esversion: 6 */
(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('mobile');
        if (!input) return;

        function formatPhone() {
            // 1) Extraer solo dígitos
            let digits = input.value.replace(/\D/g, '');
            // 2) Limitar a 10 dígitos
            digits = digits.substring(0, 10);
            // 3) Si arranca con '0', los quitamos y anteponemos '+'
            if (digits.startsWith('0')) {
                digits = digits.replace(/^0+/, '');
                input.value = '+' + digits;
            } else {
                input.value = digits;
            }
        }

        // 4) Enlazar eventos
        input.addEventListener('input', formatPhone);
        input.addEventListener('blur', formatPhone);
    });
})();
