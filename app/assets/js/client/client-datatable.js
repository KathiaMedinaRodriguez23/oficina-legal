var DatatableRemoteAjaxDemo = (function() {
    // Función privada para inicializar la tabla
    function initTable() {
        var $tbl = $('#clientDataTable');

        // Si ya existe, lo destruyo y limpio el <tbody>
        if ( $.fn.DataTable.isDataTable($tbl) ) {
            $tbl.DataTable().destroy();
            $tbl.find('tbody').empty();
        }

        // CSRF token para Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $tbl.DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            stateSave: false,       // Deshabilitado mientras pruebas
            lengthMenu: [5, 10, 25, 50],
            responsive: true,
            width: 200,
            ajax: {
                url: $('#clientDataTable').data('url'),
                type: 'POST',
                dataType: 'json'
            },
            order: [[0, 'desc']],
            columns: [
                { data: 'id' },
                { data: 'first_name' },
                { data: 'alternate_no' },
                { data: 'mobile' },
                { data: 'case',   orderable: false },
                { data: 'is_active', orderable: false },
                {
                    data: 'action',
                    orderable: false,
                    className: 'text-center'
                }
            ],
            language: {
                processing:   "<div class='loader-container'><div id='loader'></div></div>",
                emptyTable:   "No hay datos disponibles en la tabla",
                zeroRecords:  "No se encontraron registros que coincidan",
                lengthMenu:   "Mostrar _MENU_ registros",
                info:         "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty:    "Mostrando 0 a 0 de 0 registros",
                infoFiltered: "(filtrado de _MAX_ registros totales)",
                search:       "Buscar:",
                paginate: {
                    first:    "Primero",
                    previous: "Anterior",
                    next:     "Siguiente",
                    last:     "Último"
                },
                aria: {
                    sortAscending:  ": activar para ordenar columna ascendente",
                    sortDescending: ": activar para ordenar columna descendente"
                }
            }
        });
    }

    // API pública
    return {
        init: initTable
    };
})();

// Arranca la tabla cuando el DOM esté listo
jQuery(document).ready(function() {
    if ( ! $.fn.DataTable.isDataTable('#clientDataTable') ) {
        DatatableRemoteAjaxDemo.init();
    }
});
