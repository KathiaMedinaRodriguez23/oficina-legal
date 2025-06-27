// Validation

$('#add_appointment').validate({
    debug: false,
    rules: {
             date:"required",
             time:"required",
             new_client:"required",
             exists_client:"required",
        },
    messages: {
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
});



