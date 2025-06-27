var check_user_email_exits = $('#check_user_email_exits').val();
var token = $('#token-value').val();
var FormControlsClient = {

    init: function () {
        var btn = $("form :submit");
        $.validator.addMethod("pwcheck", function (value) {
            return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/.test(value) // consists of only these
        });
        $("#add_user").validate({
            rules: {
                f_name: "required",
                l_name: "required",
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: check_user_email_exits,
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
                mobile: {
                    required: true,
                    minlength: 9,
                    maxlength: 9,
                    number: true
                },
                address: "required",
                document_number: {
                    required: true,
                    minlength: 8,
                    maxlength: 8,
                    number: true
                },
                password: {
                    required: true,
                    pwcheck: true,
                    minlength: 8,
                },
                cnm_password: {
                    required: true,
                    equalTo: "#password",

                },
                country: "required",
                state: "required",
                city_id: "required",
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
                address: "Por favor, ingrese la dirección.",
                document_number: {
                    required: "Por favor, ingrese DNI.",
                    minlength: "El DNI debe tener 8 dígitos.",
                    maxlength: "El DNI debe tener 8 dígitos.",
                    number: "Por favor, ingrese solo dígitos del 0 al 9."
                },
                password: {
                    required: "Por favor, ingrese la contraseña.",
                    pwcheck: "La contraseña debe tener al menos 8 caracteres e incluir al menos una minúscula, una mayúscula, un número y un carácter especial.",
                    minlength: "La contraseña debe tener al menos 8 caracteres."
                },
                cnm_password: {
                    required: "Por favor, confirme la contraseña."
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
        });
    }

};
jQuery(document).ready(function () {
    FormControlsClient.init();

    $(".chk").hide();
    $('#chk_pass').on('click', function (ev) {
        $(this).is(':checked') ? $(".chk").show() : $(".chk").hide();
    });

    $("#role").select2({
        allowClear: true,
        placeholder: 'Seleccionar Rol',
        // multiple:true
    });

    $uploadCrop = $('#upload-demo').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200,
            type: 'circle'
        },
        boundary: {
            width: 300,
            height: 300
        }
    });

    $("#upload-demo").hide();

    var fileTypes = ['jpg', 'jpeg', 'png'];

    $('#upload').on('change', function () {

        var reader = new FileReader();
        if (this.files[0].size > 5242880) { // 2 mb for bytes.

            message.fire({
                type: 'error',
                title: 'Error',
                text: 'El archivo es demasiado grande. El tamaño máximo permitido es 5 MB.',
            });
            return false;
        }

        reader.onload = function (e) {
            result = e.target.result;
            arrTarget = result.split(';');
            tipo = arrTarget[0];

            if (tipo == 'data:image/jpeg' || tipo == 'data:image/png') {
                $("#upload-demo").show();
                $("#upload_img").show();
                $('#upload-demo-i').hide();
                $('#crop_image').hide();
                $('#demo_profile').hide();
                $('#remove_crop').hide();
                //$('#cancel_img').show();
                $uploadCrop.croppie('bind', {
                    url: e.target.result

                }).then(function () {
                    console.log('jQuery bind complete');
                });
            } else {
                message.fire({
                    type: 'error',
                    title: 'Error',
                    text: 'Se aceptan solo .jpg .png imagenes',
                });

            }
        };
        reader.readAsDataURL(this.files[0]);
    });

    $('#cancel_img').on('click', function () {

        $("#upload-demo").hide();
        $("#upload_img").hide();
        $('#upload-demo-i').show();
        $('#crop_image').show();
        $('#demo_profile').show();
        $('#remove_crop').show();
    });
    $('#upload-result').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {

            $('#imagebase64').val(resp);

        });
    });

});

$(document).ready(function () {
    $("#role").select2({
        allowClear: true,
        placeholder: 'Seleccionar Rol',
    });
});


