var token                 = $('#token-value').val();
var date_format_datepiker = $('#date_format_datepiker').val();
var common_change_state   = $('#common_change_state').val();
var t; // Variable global para compatibilidad con funciones existentes

var DatatableRemoteAjaxDemo = (function () {
    var table = null; // Variable privada para almacenar la instancia de DataTable

    var initDataTable = function () {
        var $tbl = $('#Appointmentdatatable');

        // Si ya existe una instancia, destruirla completamente
        if (table !== null) {
            try {
                table.destroy();
                console.log('Tabla anterior destruida correctamente');
            } catch (e) {
                console.warn('Error al destruir tabla anterior:', e);
            }
            table = null;
        }

        // También verificar con el método estático de DataTables
        if ($.fn.DataTable.isDataTable('#Appointmentdatatable')) {
            try {
                $('#Appointmentdatatable').DataTable().destroy();
                console.log('Instancia estática destruida');
            } catch (e) {
                console.warn('Error al destruir instancia estática:', e);
            }
        }

        // Limpiar completamente la tabla HTML
        $tbl.empty();

        // Configurar headers AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Crear nueva instancia de DataTable
        try {
            table = $tbl.DataTable({
                destroy: true,
                processing: true,
                serverSide: true,
                stateSave: true,
                lengthMenu: [10, 25, 50],
                responsive: true,
                language: {
                    processing: "<div class='loader-container'><div id='loader'></div></div>",
                    search:     "Buscar:",
                    emptyTable: "No hay datos disponibles en la tabla",
                    zeroRecords:"No se encontraron registros que coincidan",
                    lengthMenu: "Mostrar _MENU_ registros",
                    info:       "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty:  "Mostrando 0 a 0 de 0 registros",
                },
                ajax: {
                    url: $tbl.attr('data-url'),
                    type: 'POST',
                    data: function (d) {
                        // añade parámetros de filtro
                        d._token = token;
                        d.appoint_date_from = $('#date_from').val();
                        d.appoint_date_to   = $('#date_to').val();
                    }
                },
                order: [[0, 'desc']],
                columns: [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'mobile' },
                    { data: 'date' },
                    { data: 'time' },
                    { data: 'is_active' },
                    { data: 'action' }
                ],
                drawCallback: function () {
                    // re-inicializa Select2 tras cada redraw
                    $('.appointment-select2').select2();
                }
            });

            // Asignar a la variable global para compatibilidad con funciones existentes
            t = table;
            console.log('DataTable inicializada correctamente');

        } catch (e) {
            console.error('Error al inicializar DataTable:', e);
        }
    };

    return {
        // función pública de arranque
        init: function () {
            initDataTable();

            // Recargar datos al buscar
            $("#search").off('click').on('click', function () {
                if (table) {
                    table.ajax.reload();
                }
            });

            // Reset filtros y recarga
            $("#btn_clear").off('click').on('click', function () {
                $('#date_from, #date_to').val('');
                if (table) {
                    table.ajax.reload();
                }
            });

            // Clear + deshabilitar botón Buscar + recarga
            $("#clear").off('click').on('click', function () {
                $('#date_from, #date_to').val('');
                $("#search").attr("disabled", "disabled");
                if (table) {
                    table.ajax.reload();
                }
            });

            // Habilita/deshabilita botón Buscar según fechas
            $('#date_from, #date_to').off('change').on('change', function () {
                if ($('#date_from').val() === "" && $('#date_to').val() === "") {
                    $("#search").attr("disabled", "disabled");
                } else {
                    $("#search").removeAttr("disabled");
                }
            });

            // Datepicker rango desde
            $(".dateFrom").datepicker('destroy').datepicker({
                format: date_format_datepiker,
                autoclose: true,
                todayHighlight: true
            }).off('changeDate clearDate').on('changeDate', function (e) {
                $('.dateTo').datepicker('setStartDate', e.date);
            }).on('clearDate', function () {
                $('.dateTo').datepicker('setStartDate', null);
            });

            // Datepicker rango hasta
            $(".dateTo").datepicker('destroy').datepicker({
                format: date_format_datepiker,
                autoclose: true,
                todayHighlight: true
            }).off('changeDate clearDate').on('changeDate', function (e) {
                $('.dateFrom').datepicker('setEndDate', e.date);
            }).on('clearDate', function () {
                $('.dateFrom').datepicker('setEndDate', null);
            });
        },

        // Función pública para destruir la tabla
        destroy: function () {
            if (table !== null) {
                try {
                    table.destroy();
                    table = null;
                    t = null;
                    console.log('Tabla destruida manualmente');
                } catch (e) {
                    console.error('Error al destruir tabla:', e);
                }
            }
        },

        // Función pública para recargar datos
        reload: function () {
            if (table) {
                table.ajax.reload();
            }
        },

        // Función pública para obtener la instancia de la tabla
        getTable: function () {
            return table;
        }
    };
})();

// Inicialización segura
jQuery(document).ready(function () {
    // Asegurarse de que solo se ejecute una vez
    if (typeof window.datatableInitialized === 'undefined') {
        window.datatableInitialized = true;
        DatatableRemoteAjaxDemo.init();
        console.log('DataTable inicializada en document.ready');
    } else {
        console.log('DataTable ya fue inicializada previamente');
    }
});

// También manejar caso de Turbo/PJAX si se usa
$(document).on('turbo:load pjax:complete', function() {
    if (typeof window.datatableInitialized === 'undefined' || !window.datatableInitialized) {
        window.datatableInitialized = true;
        DatatableRemoteAjaxDemo.init();
        console.log('DataTable inicializada en turbo/pjax');
    }
});

// Limpiar al salir de la página
$(window).on('beforeunload', function() {
    DatatableRemoteAjaxDemo.destroy();
    window.datatableInitialized = false;
});

// Funciones de utilidad originales (sin cambios)
function confirmDelete() {
    return confirm("¿Estás seguro de que deseas eliminar esta cita?");
}

function getval(sel) {
    return sel.value;
}

function ajaxindicatorstart(text) {
    if (jQuery('body').find('#resultLoading').length === 0) {
        jQuery('body').append(
            '<div id="resultLoading" style="display:none">' +
            '<div><img src=""><div>' + text + '</div></div>' +
            '<div class="bg"></div>' +
            '</div>'
        );
    }
    jQuery('#resultLoading').css({
        width: '100%', height: '100%', position: 'fixed', zIndex: 10000000,
        top: 0, left: 0, right: 0, bottom: 0, margin: 'auto', cursor: 'wait'
    });
    jQuery('#resultLoading .bg').css({
        background: '#000', opacity: 0.7, width: '100%', height: '100%',
        position: 'absolute', top: 0
    });
    jQuery('#resultLoading>div:first').css({
        width: '250px', height: '75px', textAlign: 'center',
        position: 'fixed', top: 0, left: 0, right: 0, bottom: 0,
        margin: 'auto', fontSize: '16px', zIndex: 10, color: '#fff'
    });
    jQuery('#resultLoading').fadeIn(300);
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
            confirmar: {
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
                            sí: {
                                text: 'Sí, cambiar',
                                btnClass: 'btn-orange',
                                action: function () {
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });
                                    $.ajax({
                                        url: common_change_state,
                                        type: "POST",
                                        dataType: "JSON",
                                        data: { id: id, status: status, table: table },
                                        success: function (data) {
                                            if (data.errors) {
                                                $.alert('Ocurrió un error. Intenta de nuevo.');
                                            } else {
                                                $.alert('Estado modificado correctamente.');
                                            }
                                            // Usar la instancia correcta para recargar
                                            if (t) {
                                                t.ajax.reload();
                                            } else {
                                                DatatableRemoteAjaxDemo.reload();
                                            }
                                        },
                                        error: function () {
                                            $.alert('Error del servidor. Intenta más tarde.');
                                        }
                                    });
                                }
                            },
                            cancelar: function () {
                                // Usar la instancia correcta para recargar
                                if (t) {
                                    t.ajax.reload();
                                } else {
                                    DatatableRemoteAjaxDemo.reload();
                                }
                                $.alert('Operación cancelada.');
                            }
                        }
                    });
                }
            },
            cancelar: function () {
                // Usar la instancia correcta para recargar
                if (t) {
                    t.ajax.reload();
                } else {
                    DatatableRemoteAjaxDemo.reload();
                }
                $.alert('Operación cancelada.');
            }
        }
    });
}
