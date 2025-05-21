"use strict";

var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");
        $('#installerForm').validate({
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                app_name: "required",
                app_url: "required",
                db_host: "required",
                db_port: "required",
                db_database: "required",
                db_username: "required",
                //db_password: "required",
                user_name: "required",
                user_email: {
                    required: true,
                    email: true
                },
                user_pwd: {
                    required: true,
                    minlength : 6,
                    maxlength: 8,
                },
                user_cpwd: {
                    required: true,
                    minlength : 6,
                    maxlength: 8,
                    equalTo : "#user_pwd"
                }

            },
            messages: {
                app_name: "Por favor, ingrese el nombre de la aplicación.",
                app_url: "Por favor, ingrese la URL de la aplicación.",
                db_host: "Por favor, ingrese el host de la base de datos.",
                db_port: "Por favor, ingrese el puerto de la base de datos.",
                db_database: "Por favor, ingrese el nombre de la base de datos.",
                db_username: "Por favor, ingrese el nombre de usuario de la base de datos.",
                // db_password: "Por favor, ingrese la contraseña de la base de datos.",
                user_name: "Por favor, ingrese su nombre.",
                user_email: {
                    required: "Por favor, ingrese el correo electrónico de inicio de sesión.",
                    email: "Por favor, ingrese un correo electrónico válido.",
                },
                user_pwd: {
                    required: "Por favor, ingrese la contraseña de inicio de sesión.",
                    minlength: "La contraseña debe tener al menos 6 dígitos.",
                    maxlength: "La contraseña no debe exceder los 8 dígitos.",
                },
                user_cpwd: {
                    required: "Por favor, ingrese la confirmación de la contraseña.",
                    minlength: "La confirmación de la contraseña debe tener al menos 6 dígitos.",
                    maxlength: "La confirmación de la contraseña no debe exceder los 8 dígitos.",
                }
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function (e) {
                $('#show_loader').text('installing...');
                $("button[name='btn_add_client']").attr("disabled", "disabled").button('refresh');
                return true;
            }
        })
    }

};
jQuery(document).ready(function () {
    FormControlsClient.init();
});
