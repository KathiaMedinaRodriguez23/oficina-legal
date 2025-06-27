"use strict";

var DatatableRemoteAjaxDemo = (function () {
    function initTable() {
        var $table  = $('#user_table');
        var listUrl = $('#list').val();

        console.log('DataTables list URL →', listUrl);

        // Si ya había una instancia, la destruimos
        if ($.fn.DataTable.isDataTable($table)) {
            $table.DataTable().clear().destroy();
            $table.find('tbody').empty();
        }

        // CSRF en todos los $.ajax
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Inicializamos DataTable
        $table.DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            lengthMenu: [5, 10, 25, 50],
            ordering: false,
            language: {
                processing: "<div class='loader-container'><div id='loader'></div></div>",
                search:     "Buscar:",
                emptyTable: "No hay datos disponibles en la tabla",
                zeroRecords:"No se encontraron registros que coincidan",
                lengthMenu: "Mostrar _MENU_ registros",
                info:       "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty:  "Mostrando 0 a 0 de 0 registros"
            },
            ajax: {
                url:  listUrl,
                type: "POST",
                // opcional: si tu controlador devuelve JSON correcto, no necesitas forzar dataType
                // dataType: "json",
                error: function(xhr, status, errorThrown) {
                    console.error("DataTables Ajax error:", xhr.status, errorThrown);
                    console.log("Response text:", xhr.responseText);
                    alert("Error en carga de datos. Revisa la consola para más detalles.");
                }
            },
            columns: [
                { data: "id" },
                { data: "name" },
                { data: "email" },
                { data: "mobile" },
                { data: "role_id" },
                { data: "status" },
                { data: "options", orderable: false, className: "text-center" }
            ]
        });
    }

    return {
        init: initTable
    };
})();

jQuery(document).ready(function () {
    DatatableRemoteAjaxDemo.init();
});
