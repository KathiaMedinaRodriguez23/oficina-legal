define('select2/i18n/es', [], function () {
  // Español
  return {
    errorLoading: function () {
      return 'No se pudieron cargar los resultados.';
    },
    inputTooLong: function (args) {
      var overChars = args.input.length - args.maximum;

      var message = 'Por favor, elimina ' + overChars + ' carácter';

      if (overChars != 1) {
        message += 'es';
      }

      return message;
    },
    inputTooShort: function (args) {
      var remainingChars = args.minimum - args.input.length;

      var message = 'Por favor, ingresa ' + remainingChars + ' carácter';

      if (remainingChars != 1) {
        message += 'es';
      }

      return message;
    },
    loadingMore: function () {
      return 'Cargando más resultados…';
    },
    maximumSelected: function (args) {
      var message = 'Solo puedes seleccionar ' + args.maximum + ' elemento';

      if (args.maximum != 1) {
        message += 's';
      }

      return message;
    },
    noResults: function () {
      return 'No se encontraron resultados';
    },
    searching: function () {
      return 'Buscando…';
    }
  };
});
