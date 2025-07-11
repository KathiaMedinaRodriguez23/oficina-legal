@extends('admin.layout.app')
@section('title','Member Edit')
@push('style')
    <link href="{{ asset('assets/admin/Image-preview/dist/css/bootstrap-imageupload.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/jcropper/css/cropper.min.css') }}" rel="stylesheet">
@endpush
@section('content')

    <div class="page-title">
        <div class="title_left">
            <h3>Editar Miembro</h3>
        </div>

        <div class="title_right">
            <div class="form-group pull-right top_search">
                <a href="{{ url('admin/client_user') }}" class="btn btn-primary">Atras</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('component.error')
            <div class="x_panel">
                <div class="x_content">
                    <form id="add_user" name="add_user" role="form" method="POST" enctype="multipart/form-data"
                          action="{{route('client_user.update',$users->id)}}">
                        @csrf
                        <input name="_method" type="hidden" value="PATCH">
                        <input type="hidden" id="id" name="id" value="{{ $users->id}}">
                        <input type="hidden" id="imagebase64" name="imagebase64">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12">


                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div class="imageupload">
                                            <div class="file-tab">
                                                @if($users->profile_img!='')
                                                    <img id="crop_image"
                                                         src='{{asset('public/'.config('constants.CLIENT_FOLDER_PATH') .'/'. $users->profile_img)}}'
                                                         width='100px' height='100px'
                                                         class="crop_image_img"
                                                    >
                                                    <br>
                                                    <label id="remove_crop">
                                                        <input type="checkbox" value="Yes" name="is_remove_image"
                                                               id="is_remove_image">&nbsp;Eliminar imagen destacada.</label>
                                                @else
                                                    <img id="demo_profile" src="{{asset('public/upload/profile.png')}}"
                                                         width='100px' height='100px'
                                                         class="demo_profile"
                                                    >
                                                @endif
                                                <div id="upload-demo" class="upload-demo-img"></div>


                                                <br>

                                                <label class="btn btn-link btn-file">
                                        <span class="fa fa-upload text-center font-15"><span
                                                class="set-profile-picture"> &nbsp; Establecer foto de perfil</span>
                                        </span>
                                                    <!-- The file is stored here. -->
                                                    <input type="file" id="upload" name="image" data-src="">

                                                </label>
                                                <button type="button" class="btn btn-default" id="cancel_img">Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="f_name">Nombres <span class="text-danger">*</span></label>
                                        <input type="text" id="f_name" name="f_name" placeholder="" class="form-control"
                                               value="{{ $users->first_name}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="last_name">Apellidos <span class="text-danger">*</span></label>
                                        <input type="text" id="l_name" name="l_name" class="form-control"
                                               value="{{ $users->last_name}}">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="text" id="email" name="email" class="form-control"
                                               value="{{ $users->email}}" readonly="">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mobile">Nº celular <span class="text-danger">*</span></label>
                                        <input type="text" id="mobile" name="mobile" class="form-control" maxlength="10"
                                               value="{{ $users->mobile}}" readonly="">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-9">
                                        <label for="address">Dirección <span class="text-danger">*</span></label>
                                        <input type="text" id="address" name="address" class="form-control"
                                               value="{{ $users->address}}">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="document_number">DNI <span class="text-danger">*</span></label>
                                        <input type="text" id="document_number" name="document_number" class="form-control"
                                               maxlength="" value="{{ $users->zipcode}}">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label for="country">País <span class="text-danger">*</span></label>
                                        <select class="form-control select-change country-select2 selct2-width-100"
                                                name="country" id="country"
                                                data-url="{{ route('get.country') }}"
                                                data-clear="#city_id,#state"
                                        >
                                            <option value=""> Seleccionar País</option>
                                            @if ($users->country)
                                                <option value="{{ $users->country->id }}"
                                                        selected>{{ $users->country->name }}</option>
                                            @endif

                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="state">Departamento <span class="text-danger">*</span></label>
                                        <select id="state" name="state"

                                                data-url="{{ route('get.state') }}"
                                                data-target="#country"
                                                data-clear="#city_id"
                                                class="form-control state-select2 select-change">
                                            <option value=""> Seleccionar Departamento</option>
                                            @if ($users->state)
                                                <option value="{{ $users->state->id }}"
                                                        selected>{{ $users->state->name }}</option>
                                            @endif


                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="city">Ciudad <span class="text-danger">*</span></label>
                                        <select id="city_id" name="city_id"
                                                data-url="{{ route('get.city') }}"
                                                data-target="#state"

                                                class="form-control city-select2">
                                            <option value=""> Seleccionar Ciudad</option>
                                            @if($users->city)
                                                <option value="{{ $users->city->id }}"
                                                        selected>{{ $users->city->name }}</option>
                                            @endif


                                        </select>
                                    </div>

                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label for="Role">Rol <span class="text-danger">*</span></label>
                                        <select id="role" name="role" required class="form-control select2">
                                            <option value=""> Seleccionar Rol</option>
                                            @foreach($roles as $roal)
                                                <option
                                                    value="{{ $roal->id}}" {{ ($users->roles->contains($roal->id) ) ? 'selected=""' : '' }}>{{$roal->slug}}</option>

                                            @endforeach


                                        </select>
                                    </div>

                                </div>

                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <input type="checkbox" id="chk_pass" name="chk_pass" value="yes"> Cambiar la contraseña
                                    </div>
                                </div>
                                <div class="row form-group chk">

                                    <div class="col-md-6">
                                        <label for="password">Contraseña <span class="text-danger">*</span></label>
                                        <input type="password" id="password" name="password" class="form-control"
                                               autocomplete="off">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cnm_password">Confirmar Contraseña <span
                                                class="text-danger">*</span></label>
                                        <input type="password" id="cnm_password" name="cnm_password"
                                               class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group pull-right">
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <br>
                                    <a class="btn btn-danger" href="{{ url('admin/client_user') }}">Cancelar</a>
                                    <button type="submit" class="btn btn-success" id="upload-result"><i
                                            class="fa fa-save" id="show_loader"></i>&nbsp;Guardar
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="token-value"
           id="token-value"
           value="{{csrf_token()}}">
    <input type="hidden" name="check_user_email_exits"
           id="check_user_email_exits"
           value="{{ url('admin/check_user_email_exits') }}">
@endsection

@push('js')
    <script src="{{asset('assets/admin/js/selectjs.js')}}"></script>
    <script src="{{ asset('assets/admin/jcropper/js/cropper.min.js') }}"></script>
    <script src="{{asset('assets/js/team_member/member-validation_edit.js')}}"></script>
    <script src="{{asset('assets/js/client/validate-phone.js')}}"></script>
    <script>
        const dniInput = document.getElementById('document_number');
        dniInput.addEventListener('input', formatDni);

        function formatDni(){
            // Eliminar cualquier carácter que no sea un dígito o el símbolo '+'
            const value = dniInput.value.replace(/[^\d+]/g, '');

            // Asegurar que el número no tenga más de 8 caracteres
            dniInput.value = value.substring(0, 8);
        }
    </script>
    <script>
        $(function(){
            var myLang = {
                errorLoading: () => 'No se pudieron cargar los resultados.',
                noResults:    () => 'No hay resultados',
                searching:    () => 'Buscando…'
            };

            // Forzar idioma por defecto
            $.fn.select2.defaults.set('language', myLang);

            // Inicializar sólo el rol para testear
            $('#role').select2({
                allowClear: true,
                placeholder: 'Selecciona Rol'
            });
        });
    </script>

@endpush
