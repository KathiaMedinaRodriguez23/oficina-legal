"use strict";
var checkExistRoute = $('#route-exist-check').val();
var token = $('#token-value').val();
var FormControlsProfile = {

    init: function () {
        var btn = $("form :submit");
        $("#add_user").validate({
            // ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {

                f_name: "required",
                l_name: "required",
                mobile: {
                    required: true,
                    minlength: 9,
                    maxlength: 9,
                    number: true
                },
                address: "required",
                zip_code: {
                    required: true,
                    minlength: 6,
                    maxlength: 6,
                    number: true
                },
                country: "required",
                registration_no: "required",
                associated_name: "required",
                state: "required",
                city_id: "required",
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: checkExistRoute,
                        type: "post",
                        data: {
                            _token: function () {
                                return token;
                            },
                            email: function () {
                                return $("#email").val();
                            },
                            id: function () {
                                return $("#id").val();
                            }
                        }
                    }
                },

            },
            messages: { 
                username: {
                    required: "Por favor, ingrese el nombre de usuario.",
                    remote: "El nombre de usuario ya existe."
                },
                f_name: "Por favor, ingrese el nombre.",
                l_name: "Por favor, ingrese el apellido.",
                email: {
                    required: "Por favor, ingrese el correo electrónico.",
                    email: "Por favor, ingrese un correo electrónico válido.",
                    remote: "El correo electrónico ya existe."
                },
                mobile: {
                    required: "Por favor, ingrese el número de celular.",
                    minlength: "El número de celular debe tener 9 dígitos.",
                    maxlength: "El número de celular debe tener 9 dígitos.",
                    number: "Por favor, ingrese solo dígitos del 0 al 9."
                },
                registration_no: "Por favor, ingrese el número de registro.",
                associated_name: "Por favor, ingrese el nombre asociado.",
                address: "Por favor, ingrese la dirección.",
                zip_code: {
                    required: "Por favor, ingrese el código postal.",
                    minlength: "El código postal debe tener 6 dígitos.",
                    maxlength: "El código postal debe tener 6 dígitos.",
                    number: "Por favor, ingrese solo dígitos del 0 al 9."
                },
                country: "Por favor, seleccione el país.",
                state: "Por favor, seleccione el estado.",
                city_id: "Por favor, seleccione la ciudad."
            },
            
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function () {
                $('#show_loader').removeClass('fa-save');
                $('#show_loader').addClass('fa-spin fa-spinner');
                $("button[name='btn_add_user']").attr("disabled", "disabled").button('refresh');
                return true;
            }
        })
    }

};
jQuery(document).ready(function () {
    FormControlsProfile.init();

});
