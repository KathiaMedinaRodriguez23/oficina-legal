// Validation

$('#add_appointment').validate({   
        debug: false,
        //ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                    mobile: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        number: true
                    },
                     date:"required",
                     time:"required",
                     new_client:"required",
                     exists_client:"required",
                },
        messages: {
           mobile: {
                    required: "Por favor, introduzca el móvil.",
                    minlength: "El móvil debe tener 10 dígitos.",
                    maxlength: "El móvil debe tener 10 dígitos.",
                    number: "Por favor, introduzca los dígitos del 0 al 9.",
                    },
                    date: "Seleccione la fecha.",
                    time: "Por favor, introduzca la hora.",
                    new_client: "Por favor, introduzca el nombre del cliente.",
                    existe_client: "Por favor, seleccione el nombre del cliente."         
        },
        errorPlacement: function (error, element) {            
            error.appendTo(element.parent()).addClass('text-danger');
        },
        submitHandler: function (e) {
          $('#show_loader').removeClass('fa-save');
               $('#show_loader').addClass('fa-spin fa-spinner');
               $("button[name='btn_add_appointment']").attr("disabled", "disabled").button('refresh');
            return true;
        }
    })



  