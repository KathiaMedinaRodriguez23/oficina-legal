"use strict";
var token = $('#token-value').val();
var list = $('#list').val();

var DatatableRemoteAjaxDemo = function () {

    var lsitDataInTable = function () {
        var t;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        t = $('#user_table').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "order": [[0, "desc"]],
            "oLanguage": {
                sProcessing: "<div class='loader-container'><div id='loader'></div></div>",
                sSearch:     "Buscar:",
                sEmptyTable: "No hay datos disponibles en la tabla",
                sZeroRecords:"No se encontraron registros que coincidan",
                sLengthMenu: "Mostrar _MENU_ registros",
                sInfo:       "Mostrando _START_ a _END_ de _TOTAL_ registros",
                sInfoEmpty:  "Mostrando 0 a 0 de 0 registros"
            },
                "ajax": {
                    "url": list,
                    "dataType": "json",
                    "type": "POST",
                    "data": {_token: token}
                },
                "columns": [
                    {"data": "id"},
                    {"data": "name"},
                    {"data": "email"},
                    {"data": "mobile"},
                    {"data": "role_id"},
                    {"data": "status"},
                    {"data": "options"},
                ],
                //Set column definition initialisation properties.
                "columnDefs": [
                    {
                        "targets": [-1], //last column
                        "orderable": false, //set not orderable
                    },
                    {
                        "targets": [-2], //last column
                        "orderable": false, //set not orderable
                    },
                    {
                        "targets": [-3], //last column
                        "orderable": false, //set not orderable
                    },
                ],

            });

    }

    //== Public Functions
    return {
        // public functions
        init: function () {
            lsitDataInTable();
        }
    };
}();
jQuery(document).ready(function () {
    DatatableRemoteAjaxDemo.init()
});
