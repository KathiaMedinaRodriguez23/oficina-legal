"use strict";
var getNextDateModals = $('#getNextDateModals').val();

function nextDateAdd(case_id) {

    // ajax get modal
    $.ajax({
        url: getNextDateModals + "/" + case_id,
        success: function (data) {

            $('#show_modal_next_date').html(data);
            $('#modal-next-date').modal({
                backdrop: false,
                show: true,
            });

            // show bootstrap modal
            $('.modal-title').text('Añadir próxima fecha'); // Set Title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error al agregar o actualizar los datos');
        }
    });
}

