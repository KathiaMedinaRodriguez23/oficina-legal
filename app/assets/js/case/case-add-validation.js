"use strict";
var select2Case = $('#select2Case').val();
var date_format_datepiker = $('#date_format_datepiker').val();
var getCaseSubTypes = $('#getCaseSubType').val();
var getCourts = $('#getCourt').val();


var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");
        $("#add_case").validate({
            rules: {
                client_name: "required",
                party_name: "required",
                party_advocate: "required",
                case_no: "required",
                case_type: "required",
                case_status: "required",
                act: "required",
                court_type: "required",
                next_date: "required",
                court_no: "required",
                court_name: "required",
                judge_type: "required",
                filing_number: "required",
                filing_date: "required",
                registration_number: "required",
                registration_date: "required",

            },
            messages: {
                client_name: "Por favor, ingrese el nombre del cliente.",
                party_name: "Por favor, ingrese el nombre.",
                party_advocate: "Por favor, ingrese el nombre del abogado.",
                case_no: "Por favor, ingrese el número del caso.",
                case_type: "Por favor, seleccione el tipo de caso.",
                case_status: "Por favor, seleccione la etapa del caso.",
                act: "Por favor, ingrese la ley aplicable.",
                court_type: "Por favor, seleccione el tipo de Tribunal.",
                next_date: "Por favor, seleccione la fecha de la primera audiencia.",
                court_no: "Por favor, ingrese el número de sala.",
                court_name: "Por favor, ingrese el nombre del juzgado.",
                judge_type: "Por favor, seleccione el tipo de juez.",
                filing_number: "Por favor, ingrese el número de presentación.",
                filing_date: "Por favor, seleccione la fecha de presentación.",
                registration_number: "Por favor, ingrese el número de registro.",
                registration_date: "Por favor, seleccione la fecha de registro.",

            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },

            submitHandler: function () {
                $('#show_loader').removeClass('fa-save');
                $('#show_loader').addClass('fa-spin fa-spinner');
                $("button[name='btn_add_case']").attr("disabled", "disabled").button('refresh');
                return true;
            }
        })
    }

};
jQuery(document).ready(function () {
    FormControlsClient.init();


    $('.datetimepickerfilingdate').datepicker({
        format: date_format_datepiker,
        autoclose: "close",
        todayHighlight: true,
        clearBtn: true,
    });

    $('.datetimepickerregdate').datepicker({
        format: date_format_datepiker,
        autoclose: "close",
        todayHighlight: true,
        clearBtn: true,
    });

    $('.datetimepickernextdate').datepicker({
        format: date_format_datepiker,
        autoclose: "close",
        todayHighlight: true,
        clearBtn: true,
    });

    $('input[type=radio][name=position]').on('change', function () {
        if (this.value == 'Respondent') {
            $('.position_name').html('Nombre del peticionario');
            $('.position_advo').html('Defensor del peticionario');
        } else if (this.value == 'Petitioner') {
            $('.position_name').html('Nombre del demandado');
            $('.position_advo').html('Abogado del demandado');
        }
    });


    $("#assigned_to").select2({
        allowClear: true,
        placeholder: 'Seleccionar usuarios',
        multiple: true
    });

    $("#case_type").select2({
        allowClear: true,
        placeholder: 'Seleccione el tipo de caso'
    });

    $("#case_sub_type").select2({
        allowClear: true,
        placeholder: 'Seleccionar subtipo de caso'
    });

    $("#case_status").select2({
        allowClear: true,
        placeholder: 'Seleccionar la etapa del caso'
    });
    $("#court_type").select2({
        allowClear: true,
        placeholder: 'Seleccione el tipo de Tribunal'
    });
    $("#court_name").select2({
        allowClear: true,
        placeholder: 'Seleccione Tribunal'
    });
    $("#judge_type").select2({
        allowClear: true,
        placeholder: 'Seleccione el tipo de juez'
    });
    $("#client_name").select2({
        allowClear: true,
        placeholder: 'Seleccionar nombre del cliente'
    });

    $('.position_name').html('Nombre del demandado');
    $('.position_advo').html('Abogado del demandado');
    $('.repeater').repeater({
        // (Optional)
        // start with an empty list of repeaters. Set your first (and only)
        // "data-repeater-item" with style="display:none;" and pass the
        // following configuration flag
        initEmpty: false,
        // (Optional)
        // "defaultValues" sets the values of added items.  The keys of
        // defaultValues refer to the value of the input's name attribute.
        // If a default value is not specified for an input, then it will
        // have its value cleared.
        defaultValues: {
            'text-input': 'foo'
        },
        // (Optional)
        // "show" is called just after an item is added.  The item is hidden
        // at this point.  If a show callback is not given the item will
        // have $(this).show() called on it.
        show: function () {
            $(this).slideDown();
            var test = $('input[name=position]:checked').val();

            if (test == 'Respondent') {

                $('.position_name').html('Nombre del demandante');
                $('.position_advo').html('Abogado del demandante');
            } else if (test == 'Petitioner') {

                $('.position_name').html('Nombre del demandado');
                $('.position_advo').html('Abogado del demandado');
            }
        },
        // (Optional)
        // "hide" is called when a user clicks on a data-repeater-delete
        // element.  The item is still visible.  "hide" is passed a function
        // as its first argument which will properly remove the item.
        // "hide" allows for a confirmation step, to send a delete request
        // to the server, etc.  If a hide callback is not given the item
        // will be deleted.
        hide: function (deleteElement) {
            if (confirm('¿Estás seguro que deseas eliminar este elemento?')) {
                $(this).slideUp(deleteElement);
            }
        },
        // (Optional)
        // You can use this if you need to manually re-index the list
        // for example if you are using a drag and drop library to reorder
        // list items.
        ready: function (setIndexes) {
            //$dragAndDrop.on('drop', setIndexes);
        },
        // (Optional)
        // Removes the delete button from the first list item,
        // defaults to false.
        isFirstItemUndeletable: true
    })


});

function getCaseSubType(id) {

    if (id == "") {
        $('#case_sub_type').html('');
    } else {
        $('#case_sub_type').html('');
        $('#case_sub_type').prepend($('<option></option>').html('cargando...'));
    }
    if (id != '') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $.ajax({
            url: getCaseSubTypes,
            method: "POST",
            data: {id: id},
            success: function (result) {
                if (result.errors) {
                    $('.alert-danger').html('');
                } else {
                    $('#case_sub_type').html(result);
                }
            }
        });
    }
}

function getCourt(id) {

    if (id == "") {
        $('#court_name').html('');
    } else {
        $('#court_name').html('');
        $('#court_name').prepend($('<option></option>').html('Cargando...'));
    }


    if (id != '') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        });
        $.ajax({
            url: getCourts,
            method: "POST",
            data: {id: id},
            success: function (result) {
                if (result.errors) {
                    $('.alert-danger').html('');
                } else {
                    $('#court_name').html(result);
                }
            }
        });
    }
}
