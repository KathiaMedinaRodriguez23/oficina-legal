"use strict";

var token = $('#token-value').val();
var case_ids = $('#case_ids').val();
var allCaseHistoryList = $('#allCaseHistoryList').val();

var DatatableRemoteAjaxDemo = function () {

    var lsitDataInTable = function () {
        var $tbl = $('#case_history_list');

        // Si ya existe, lo destruyo y limpio el <tbody>
        if ( $.fn.DataTable.isDataTable($tbl) ) {
            $tbl.DataTable().destroy();
            $tbl.find('tbody').empty();
        }

        var t;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        t = $('#case_history_list').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "ordering": false,
            "oLanguage": {
                sProcessing: "<div class='loader-container'><div id='loader'></div></div>",
                sSearch:     "Buscar:",
                sEmptyTable: "No hay datos disponibles en la tabla",
                sZeroRecords:"No se encontraron registros que coincidan",
                sLengthMenu: "Mostrar _MENU_ registros",
                sInfo:       "Mostrando _START_ a _END_ de _TOTAL_ registros",
                sInfoEmpty:  "Mostrando 0 a 0 de 0 registros"
            },
            // "order": [[0, "asc"]],
            "ajax": {
                "url": allCaseHistoryList,
                "dataType": "json",
                "type": "POST",
                "data": {_token: token, case_id: case_ids}
            },
            "columns": [
                {"data": "registration_no"},
                {"data": "judge"},
                {"data": "business_on_date"},
                {"data": "hearing_date"},
                {"data": "purpose_of_hearing"},
                {"data": "remarks"}
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
                    "targets": [-4], //last column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [-5], //last column
                    "orderable": false, //set not orderable
                },
                {
                    "targets": [-6], //last column
                    "orderable": false, //set not orderable
                }
            ]


        })

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


function showRemark(bussinessOnDate, remarks) {

    $('.modal-body').html(remarks);

    $('#remarkModal').modal('show'); // show bootstrap modal

    $('.modal-title').text('Observación de la actividad en la fecha:' + bussinessOnDate); // Set Title to Bootstrap modal title
}
