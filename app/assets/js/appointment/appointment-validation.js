"use strict";
var checkExistRoute = $('#common_check_exist').val();
var select2Case = $('#select2Case').val();
var token = $('#token-value').val();
var date_format_datepiker = $('#date_format_datepiker').val();
var getMobilenos = $('#getMobileno').val();


var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");

    }

};
jQuery(document).ready(function () {
    FormControlsClient.init();

    $('.exists').addClass("hidden");
    $('#date').datepicker({
        format: date_format_datepiker,
        autoclose: "close",
        startDate: '0d',
        todayHighlight: true,
    });

    $('#time').datetimepicker({
        format: 'hh:mm A'
    });

    $('#exists_client').select2({
        placeholder: 'Elija un Cliente'
    });

    $("#related").select2({
        allowClear: true,
        placeholder: 'No se ha seleccionado nada',});

    $('input[type=radio][name=type]').on('change', function () {

        if (this.value == 'exists') {

            $('.exists').removeClass("hidden");
            $('.new').addClass("hidden");

            $("#exists_client").val('').select2({
                placeholder: 'Elija un cliente'
            });

        } else if (this.value == 'new') {
            // alert("new");
            $('.exists').addClass("hidden");
            $('.new').removeClass("hidden");
            $('#mobile').val('').prop('disabled', false);

        }
    });

    $('#related').on('change', function () {
        var optionSelected = $(this).find("option:selected");
        var label_name = optionSelected.val();

        if (label_name == "case") {
            $('.task_selection').removeClass('hide');
        } else {
            $('.task_selection').addClass('hide');
        }
    });

    $('#related_id').select2({
        ajax: {
            url: select2Case,
            data: function (params) {
                return {
                    search: params.term,
                    //page: params.page || 1
                };
            },
            dataType: 'json',
            processResults: function (data) {
                //data.page = data.page || 1;
                return {
                    results: data.items.map(function (item) {
                        item.first_name = item.first_name || '';
                        item.middle_name = item.middle_name || '';
                        item.last_name = item.last_name || '';
                        return {
                            id: item.id,
                            text: `${item.first_name}  ${item.middle_name} ${item.last_name}`,
                            otherfield: item,
                        };
                    }),
                    pagination: {
                        more: data.pagination
                    }
                };
            },
            //cache: true,
            delay: 50
        },
        placeholder: 'Buscar cliente',
        // minimumInputLength: 1,
        templateResult: getfName,
    });


});

function getMobileno(id) {

    if (id != '') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $.ajax({
            url: getMobilenos,
            method: "POST",
            data: {id: id},
            success: function (data) {

                $('#email').val(data.email).prop('readonly', true);

            }
        });
    }
}

function getfName(data) {
    if (!data.id) {
        return data.text;
    }
    data = data.otherfield;
    var $html = $("<p style='margin-bottom: 0;'><b>" + data.first_name + ' ' + data.middle_name + ' ' + data.last_name + "</b> <br> " + data.act + "</p>");
    return $html;
}

