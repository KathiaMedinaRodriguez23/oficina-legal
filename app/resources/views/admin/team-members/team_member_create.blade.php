@extends('admin.layout.app')
@section('title','Member Create')
@push('style')
    <link href="{{ asset('assets/admin/Image-preview/dist/css/bootstrap-imageupload.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/jcropper/css/cropper.min.css') }}" rel="stylesheet">
@endpush
@section('content')

    <div class="page-title">
        <div class="title_left">
            <h3>Agregar Nuevo Miembro</h3>
        </div>

        <div class="title_right">
            <div class="form-group pull-right top_search">
                <a href="{{ url('admin/client_user') }}" class="btn btn-primary">Atrás</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('component.error')
            <div class="x_panel">
                <div class="x_content">
                    <form id="add_user" name="add_user" role="form" method="POST"
                          action="{{route('client_user.store')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" id="imagebase64" name="imagebase64">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div class="imageupload">
                                            <div class="file-tab">

                                                <img id="demo_profile" src="{{asset('public/upload/profile.png')}}"
                                                     width='100px' height='100px'
                                                     class="demo_profile">

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
                                        <input type="text" id="f_name" name="f_name" placeholder=""
                                               class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="last_name">Apellidos <span class="text-danger">*</span></label>
                                        <input type="text" id="l_name" name="l_name" class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="text" id="email" name="email" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="mobile">Nº de celular <span class="text-danger">*</span></label>
                                        <input type="text" id="mobile" name="mobile" class="form-control"
                                               maxlength="10">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-9">
                                        <label for="address">Dirección <span class="text-danger">*</span></label>
                                        <input type="text" id="address" name="address" class="form-control">
                                    </div>
                                   <div class="col-md-3">
                                        <label for="zipcode">Código postal <span class="text-danger">*</span></label>
                                        <input type="text" id="zip_code" name="zip_code" class="form-control"
                                               maxlength="">
                                    </div> 
                                </div>
                                <div class="row form-group">
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

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label for="country">País <span class="text-danger">*</span></label>
                                        <select class="form-control select-change country-select2 selct2-width-100"
                                                name="country" id="country"
                                                data-url="{{ route('get.country') }}"
                                                data-clear="#city_id,#state"
                                        >
                                            <option value=""> Seleccionar País</option>

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


                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="city">Ciudad <span class="text-danger">*</span></label>
                                        <select id="city_id" name="city_id"
                                                data-url="{{ route('get.city') }}"
                                                data-target="#state"

                                                class="form-control city-select2">
                                            <option value=""> Seleccionar Ciudad</option>


                                        </select>
                                    </div>

                                </div>

                                <div class="row form-group">
                                    <div class="col-md-4">
                                        <label for="Role">Rol <span class="text-danger">*</span></label>
                                        <select id="role" name="role" required class="form-control select2">
                                            <option value=""> Seleccionar Rol</option>
                                            @foreach($roles as $roal)
                                                <option value="{{ $roal->id}}">{{$roal->slug}}</option>

                                            @endforeach


                                        </select>
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
    <script src="{{asset('assets/js/team_member/member-validation.js')}}"></script>
@endpush
