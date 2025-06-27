"use strict";

var get_case_important_modal = $('#get_case_important_modal').val();
var get_case_next_modal = $('#get_case_next_modal').val();
var get_case_cort_modal = $('#get_case_cort_modal').val();
var advo_client_id = $('#advo_client_id').val();

var token = $('#token-value').val();
var t;
var DatatableRemoteAjaxDemo = function () {

    var lsitDataInTable = function () {
        var $tbl = $('#case_list');

        // Si ya existe, lo destruyo y limpio el <tbody>
        if ( $.fn.DataTable.isDataTable($tbl) ) {
            $tbl.DataTable().destroy();
            $tbl.find('tbody').empty();
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        t = $('#client_case_listDatatable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "lengthMenu": [10, 25, 50],
            "responsive": true,
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
            "width": 200,
            // "iDisplayLength": 2,
            "ajax": {
                "url": $('#client_case_listDatatable').attr('data-url'),
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: token,
                    advocate_client_id: advo_client_id
                }

            },
            // "order": [
            //     [0, "desc"]
            // ],
            "columns": [{
                "data": "id"
            },
                {"data": "name"},
                {"data": "court"},
                {"data": "case"},
                {"data": "next_date"},
                {"data": "status"},
                {"data": "options"}
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

// Arranca la tabla cuando el DOM esté listo
jQuery(document).ready(function() {
    if ( ! $.fn.DataTable.isDataTable('#case_list') ) {
        DatatableRemoteAjaxDemo.init();
    }
});


function nextDateAdd(case_id) {
    // ajax get modal
    $.ajax({
        url: get_case_next_modal + "/" + case_id,
        success: function (data) {
            $('#show_modal_next_date').html(data);
            $('#modal-next-date').modal('show'); // show bootstrap modal
            $('.modal-title').text('Añadir próxima fecha'); // Set Title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error al agregar/actualizar datos');
        }
    });
}

function change_case_important(case_id) {
    // ajax get modal
    $.ajax({
        url: get_case_important_modal + '/' + case_id,
        success: function (data) {
            $('#show_modal').html(data);
            $('#modal-case-priority').modal('show'); // show bootstrap modal
            $('.modal-title').text('Cambiar caso importante'); // Set Title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error al agregar/actualizar datos');
        }
    });
}

function transfer_case(case_id) {

    // ajax get modal
    $.ajax({
        url: get_case_cort_modal + "/" + case_id,
        success: function (data) {
            $('#show_modal_transfer').html(data);
            $('#modal-change-court').modal('show'); // show bootstrap modal
            $('.modal-title').text('Transferencia de casos'); // Set Title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error al agregar/actualizar datos');
        }
    });
}



