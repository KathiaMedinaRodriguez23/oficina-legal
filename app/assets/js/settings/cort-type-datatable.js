"use strict";
var t;
var DatatableRemoteAjaxDemo = function () {


    var lsitDataInTable = function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        t = $('#tagDataTable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "lengthMenu": [10, 25, 50],
            "responsive": true,
            "oLanguage": {
                sProcessing: "<div class='loader-container'><div id='loader'></div></div>",
                sSearch:     "Buscar:",
                sEmptyTable: "No hay datos disponibles en la tabla",
                sZeroRecords:"No se encontraron registros que coincidan",
                sLengthMenu: "Mostrar _MENU_ registros",
                sInfo:       "Mostrando _START_ a _END_ de _TOTAL_ registros",
                sInfoEmpty:  "Mostrando 0 a 0 de 0 registros"
            },
            "width":200,
            // "iDisplayLength": 2,
            "ajax": {
                "url": $('#tagDataTable').attr('data-url'),
                "dataType": "json",
                "type": "POST",
                "data": function (d) {
                    return $.extend({}, d, {});
                }
            },
            "order": [
                [0, "desc"]
            ],
            "columns": [
                { "data": "id" },
                { "data": "type" },
                { "data":"is_active"},
                { "data": "action" }
            ]
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




