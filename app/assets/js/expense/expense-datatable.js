"use strict";

var expense_list = $('#expense-list').val();
var token_value = $('#token-value').val();
var t;
var DatatableRemoteAjaxDemo = function () {


    var lsitDataInTable = function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        t = $('#ExpenseDatatable').DataTable({
            "destroy": true,
            "processing": true,
            "serverSide": true,
            // "order": [[0, "desc"]],
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
            "ajax": {
                "url": expense_list,
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: token_value
                }
            },
            "columns": [
                {"data": "id"},
                {"data": "invoice_no"},
                {"data": "vandor"},
                {"data": "amount"},
                {"data": "paidAmount"},
                {"data": "dueAmount"},
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


function confirmDelete() {
    var x = confirm("Are you sure you want to delete this expense?");
    if (x)
        return true;
    else
        return false;
}

