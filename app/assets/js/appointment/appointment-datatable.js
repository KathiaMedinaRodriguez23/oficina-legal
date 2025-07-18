"use strict";

var token = $('#token-value').val();
var date_format_datepiker = $('#date_format_datepiker').val();
var common_change_state = $('#common_change_state').val();

var token = $('#token-value').val();
var t;
var DatatableRemoteAjaxDemo = function () {

    var lsitDataInTable = function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        t = $('#Appointmentdatatable').DataTable({
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
                sInfoEmpty:  "Mostrando 0 a 0 de 0 registros",
            },
            "width": 200,
            // "iDisplayLength": 2,
            "ajax": {
                "url": $('#Appointmentdatatable').attr('data-url'),
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: token,
                    appoint_date_from: $('#date_from').val(),
                    appoint_date_to: $('#date_to').val(),
                }
            },
            // "order": [
            //     [0, "desc"]
            // ],
            "columns": [
                {"data": "id"},
                {"data": "name"},
                {"data": "mobile"},
                {"data": "date"},
                {"data": "time"},
                {"data": "is_active"},
                {"data": "action"},
            ],
            drawCallback: function () {
                $('.appointment-select2').select2();
            }
        });

    }

    //== Public Functions
    return {
        // public functions
        init: function () {
            lsitDataInTable();


            $("#btn_clear").click(function(){
                $('#date_from').val('');
                $('#date_to').val('');
                var d = $('#Appointmentdatatable').DataTable();
                d.destroy();
                DatatableRemoteAjaxDemo.init()

            });


            $("#search").click(function () {
                t.destroy();
                DatatableRemoteAjaxDemo.init()
            });

            $("#clear").click(function () {
                $('#date_from').val('');
                $('#date_to').val('');
                t.destroy();
                DatatableRemoteAjaxDemo.init()
                $("#search").attr("desactivada", "desactivada");
            });


            $('#date_from,#date_to').on('change', function () {
                if ($('#date_from').val() == "" && $('#date_to').val() == "") {
                    $("#search").attr("disabled", "disabled");
                } else {
                    $('#search').removeAttr('disabled');
                }
            });
            $(".dateFrom").datepicker({
                format: date_format_datepiker,
                autoclose: true,
                todayHighlight: true,
            }).on('changeDate', function (selected) {
                var startDate = new Date(selected.date.valueOf());
                $('.dateTo').datepicker('setStartDate', startDate);
            }).on('clearDate', function (selected) {
                $('.dateTo').datepicker('setStartDate', null);
            });

            $(".dateTo").datepicker({
                format: date_format_datepiker,
                autoclose: true,
                todayHighlight: true,
            }).on('changeDate', function (selected) {
                var endDate = new Date(selected.date.valueOf());
                $('.dateFrom').datepicker('setEndDate', endDate);
            }).on('clearDate', function (selected) {
                $('.dateFrom').datepicker('setEndDate', null);
            });


        }
    };
}();
jQuery(document).ready(function () {
    DatatableRemoteAjaxDemo.init()
});

function confirmDelete() {
    var x = confirm("¿Estás seguro que deseas eliminar esta cita?");
    if (x)
        return true;
    else
        return false;
}

function getval(sel) {
    return sel.value;
}

function ajaxindicatorstart(text) {
    if (jQuery('body').find('#resultLoading').attr('id') != 'resultLoading') {
        jQuery('body').append('<div id="resultLoading" style="display:none"><div><img src=""><div>' + text + '</div></div><div class="bg"></div></div>');
    }
    jQuery('#resultLoading').css({
        'width': '100%',
        'height': '100%',
        'position': 'fixed',
        'z-index': '10000000',
        'top': '0',
        'left': '0',
        'right': '0',
        'bottom': '0',
        'margin': 'auto'
    });

    jQuery('#resultLoading .bg').css({
        'background': '#000000',
        'opacity': '0.7',
        'width': '100%',
        'height': '100%',
        'position': 'absolute',
        'top': '0'
    });

    jQuery('#resultLoading>div:first').css({
        'width': '250px',
        'height': '75px',
        'text-align': 'center',
        'position': 'fixed',
        'top': '0',
        'left': '0',
        'right': '0',
        'bottom': '0',
        'margin': 'auto',
        'font-size': '16px',
        'z-index': '10',
        'color': '#ffffff'

    });

    jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeIn(300);
    jQuery('body').css('cursor', 'wait');
}


function change_status(id, status, table) {

    $.confirm({
        title: 'Confirmar cambio de estado',
        content: '¿Deseas continuar con el cambio de estado?',
        icon: 'fa fa-question-circle',
        animation: 'scale',
        closeAnimation: 'scale',
        opacity: 0.5,
        buttons: {
            'confirm': {
                text: 'Continuar',
                btnClass: 'btn-blue',
                action: function () {
                    $.confirm({
                        title: 'Confirmación final',
                        content: 'Esta acción no se puede deshacer.',
                        icon: 'fa fa-warning',
                        animation: 'scale',
                        closeAnimation: 'zoom',
                        buttons: {
                            confirm: {
                                text: 'Sí, cambiar',
                                btnClass: 'btn-orange',
                                action: function () {
                                    // ajax adding data to database
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                        }
                                    });
                                    $.ajax({
                                        url: common_change_state,
                                        type: "POST",
                                        dataType: "JSON",
                                        data: {id: id, status: status, table: table},
                                        async: false,
                                        success: function (data) {
                                            if (data.errors) {
                                                message.fire({
                                                    type: 'error',
                                                    title: 'Error',
                                                    text: "Ocurrió un error. Intenta de nuevo."
                                                });
                                                var d = $('#Appointmentdatatable').DataTable();
                                                d.destroy();
                                                // tab_appoint_list();
                                                DatatableRemoteAjaxDemo.init()
                                            }
                                            //error_massage('Problem in delete!!! Please try again.');                                             }
                                            else {
                                                message.fire({
                                                    type: 'success',
                                                    title: 'Éxito',
                                                    text: "Estado cambiado correctamente."
                                                });
                                                var d = $('#Appointmentdatatable').DataTable();
                                                d.destroy();
                                                // tab_appoint_list();
                                                DatatableRemoteAjaxDemo.init()
                                                //success_massage('Status changed successfully.');
                                                //tab_appoint_list();
                                            }
                                        },
                                        error: function (jqXHR, textStatus, errorThrown) {
                                            alert('Error del servidor. Intenta más tarde.');
                                        }
                                    });
                                }
                            },
                            cancel: function () {
                                var d = $('#Appointmentdatatable').DataTable();
                                d.destroy();
                                // tab_appoint_list();
                                DatatableRemoteAjaxDemo.init()
                                $.alert('Operación cancelada.');
                            }
                        }
                    });
                }
            },
            cancel: function () {
                var d = $('#Appointmentdatatable').DataTable();
                d.destroy();
                // tab_appoint_list();
                DatatableRemoteAjaxDemo.init()
                $.alert('Operación cancelada.');
            },
        }
    });
}


