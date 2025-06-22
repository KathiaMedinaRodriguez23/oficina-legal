<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $image_logo->company_name ?? '' }} | Recuperar Contraseña </title>
    @if($image_logo->favicon_img!='')
        <link rel="shortcut icon" href="{{asset(config('constants.FAVICON_FOLDER_PATH') .'/'. $image_logo->favicon_img)}}" >
    @endif

    <!-- Bootstrap -->
    <link href="{{asset('assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('assets/admin/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{asset('assets/admin/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- Animate.css -->
    <link href="{{asset('assets/admin/vendors/animate.css/animate.min.css') }}" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{asset('assets/admin/build/css/custom.min.css') }}" rel="stylesheet">

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>

<body class="login">
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/password/email') }}">
                    {{ csrf_field() }}
                    <img src="{{ asset('public/upload/logo.png') }}" style="margin-bottom: 10px; width: 60%">
                    <h2> Recuperar Contraseña </h2>
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>

                        @if ($errors->has('email'))
                            <span class="help-block text-left">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="btn btn-default">
                            Enviar enlace para recuperar contraseña
                        </button>

                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">

                        <div class="clearfix"></div>
                        <br />

                        <div>

                            <p>©2025 Todos los derechos reservados. Horizonte Legal</p>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
<script src="{{asset('assets/admin/vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/js/sweetalert2.all.min.js') }}"></script>
<script>
    $(document).ready(function () {
        const CleanAlert = Swal.mixin({
            position: 'center',
            showConfirmButton: true,
            confirmButtonText: 'Aceptar',
            allowOutsideClick: true,
            allowEscapeKey: true,
            background: '#ffffff',
            backdrop: true
        });

        @if(Session::has('error'))
        CleanAlert.fire({
            icon: 'error',
            title: '¡Atención!',
            html: `
                <div style="color: #2c3e50; font-size: 16px; margin-top: 1rem;">
                    {{ session('error') }}
            </div>
            <p style="color: #7f8c8d; font-size: 14px; margin-top: 1rem;">
                Por favor, verifica la información e intenta nuevamente.
            </p>`,
            confirmButtonText: '<i class="fa fa-check"></i> Entendido',
            customClass: {
                confirmButton: 'swal2-confirm error-button'
            },
            buttonsStyling: false,
            width: '450px'
        });
        @endif

        @if(Session::has('success'))
        CleanAlert.fire({
            icon: 'success',
            title: '¡Perfecto!',
            html: `
                <div style="color: #2c3e50; font-size: 16px; margin-top: 1rem;">
                    {{ session('success') }}
            </div>
            <p style="color: #7f8c8d; font-size: 14px; margin-top: 1rem;">
                Revisa tu bandeja de entrada o carpeta de spam.
            </p>
            `,
        });
        @endif

        @if(Session::has('status'))
        CleanAlert.fire({
            icon: 'success',
            title: '¡Enviado!',
            html: `
                <div style="color: #2c3e50; font-size: 16px; margin-top: 1rem;">
                    {{ session('status') }}
            </div>
            <p style="color: #FF0000FF; font-size: 14px; margin-top: 1rem;">
                El enlace de recuperación llegará en unos momentos.
            </p>
`,
            confirmButtonText: '<i class="fa fa-thumbs-up"></i> Perfecto',
            buttonsStyling: false,
            width: '450px'
        });
        @endif
    });
</script>
</body>
</html>
