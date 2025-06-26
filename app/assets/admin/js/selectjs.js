$(document).ready(function () {
   countrySelect2 = $('.country-select2');
   stateSelect2 = $('.state-select2');
   citySelect2 = $('.city-select2');
   roleSelect2 = $('.role-select2');

    var myLang = {
        errorLoading: function() {
            return 'No se pudieron cargar los resultados.';
        },
        noResults: function() {
            return 'No hay resultados';
        },
        searching: function() {
            return 'Buscando…';
        }
    };

    countrySelect2.select2({
        allowClear :true,
        language: myLang,
        ajax: {
            url: countrySelect2.data('url'),
            data: function (params) {
                return {
                    search: params.term,
                    id : $(countrySelect2.data('target')).val()
                };
            },
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.name,
                            otherfield: item,
                        };
                    }),
                }
            },
            cache: true,
            delay: 250
        },
        placeholder: 'Selecciona Pais'
        // minimumInputLength: 1,
    });

    stateSelect2.select2({
        allowClear :true,
        language: myLang,
        ajax: {
            url: stateSelect2.data('url'),
            data: function (params) {
                return {
                    search: params.term,
                    id : $(stateSelect2.data('target')).val()
                };
            },
            dataType: 'json',
            processResults: function (data) {
                 if($("#country").val() !='')
                {
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.name,
                            otherfield: item,
                        };
                    }),
                }
               }else{
                    return false;
               }
            },
            cache: true,
            delay: 250
        },
        placeholder: 'Selecciona Departamento'
        // minimumInputLength: 1,
    });

     citySelect2.select2({
        allowClear :true,
        language: myLang,
        ajax: {
            url: citySelect2.data('url'),
            data: function (params) {
                return {
                    search: params.term,
                    id : $(citySelect2.data('target')).val()
                };
            },
            dataType: 'json',
            processResults: function (data) {
                   if($("#state").val() !='')
                {
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.name,
                            otherfield: item,
                        };
                    }),
                }
               }else{
                return false;
               }
            },
            cache: true,
            delay: 250
        },
        placeholder: 'Selecciona Ciudad'
        // minimumInputLength: 1,
    });

    roleSelect2.select2({
        allowClear: true,
        language: myLang,
        placeholder: "Selecciona Rol",
    });

    $('.country-select2, .state-select2, .city-select2, .role-select2')
        .on('select2:select', function(e){
            var el = $(this);
            var clearInput = el.data('clear');       // asegúrate de tener data-clear="…"
            if (clearInput) {
                $(clearInput).val(null).trigger('change');
            }
        });
});
