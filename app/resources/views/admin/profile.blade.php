@extends('admin.layout.app')
@section('title','Profile')
@push('style')
    <link href="{{ asset('assets/admin/Image-preview/dist/css/bootstrap-imageupload.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/jcropper/css/cropper.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="">

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">
                    <div class="x_title">
                        <h2>Perfil</h2>
                        <div class="clearfix"></div>
                    </div>

                    <div class="x_content">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Ups!</strong> Por favor corrige los siguientes errores:<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_content">

                                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                        <li role="presentation"
                                            class="@if(request()->segment(2)=='admin-profile') active @else @endif"><a
                                                href="{{ url('admin/admin-profile') }}">Detalle</a>
                                        </li>

                                        <li role="presentation"
                                            class="@if(request()->segment(3)=='password') active @else @endif"><a
                                                href="{{ url('admin/change/password') }}">Modificar Contraseña</a>

                                        </li>
                                    </ul>
                                    <div id="myTabContent" class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade active in" id="profile_detail"
                                             aria-labelledby="profile">
                                            <form id="add_user" name="add_user" role="form" method="POST"
                                                  enctype="multipart/form-data"
                                                  action="{{ url('admin/edit-profile')}}">
                                                @csrf

                                                <input type="hidden" id="id" name="id" value="{{ $users->id}}">
                                                <input type="hidden" id="imagebase64" name="imagebase64">
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-12 col-xs-12">

                                                        <div class="row">
                                                            <div class="col-md-12 text-center dimage">
                                                                @if($users->profile_img!='')
                                                                    <img id="crop_image"
                                                                         src='{{asset('public/'.config('constants.CLIENT_FOLDER_PATH') .'/'. $users->profile_img)}}'
                                                                         width='100px' height='100px'
                                                                         class="crop_image_profile"
                                                                    >
                                                                    <div class="contct-info">
                                                                        <label id="remove_crop">
                                                                            <input type="checkbox" value="Yes"
                                                                                   name="is_remove_image"
                                                                                   id="is_remove_image">&nbsp;Eliminar Imagen
                                                                        </label>
                                                                    </div>
                                                                @else
                                                                    <img id="demo_profile"
                                                                         src='{{asset('public/upload/profile.png')}}'
                                                                         width='100px'
                                                                         height='100px'
                                                                         class="crop_image_profile"
                                                                    >

                                                                @endif


                                                                <div class="imageupload">
                                                                    <div class="file-tab">

                                                                        <div
                                                                            id="upload-demo"
                                                                            class="upload-demo"


                                                                        ></div>
                                                                        <div id="upload-demo-i"
                                                                        ></div>

                                                                        <br>
                                                                        <label class="btn btn-link btn-file">
                                      <span class="fa fa-upload text-center font-15 set-profile-picture" ><span
                                           > &nbsp;Colocar Imagen de Perfil</span>
                                      </span>
                                                                            <!-- The file is stored here. -->
                                                                            <input type="file" id="upload" name="image"
                                                                                   data-src="{{ $users->id}}">

                                                                        </label>
                                                                        <button type="button" class="btn btn-default"
                                                                                id="cancel_img">Cancel
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <br>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                                        <div class="row form-group">
                                                            <div class="col-md-6">
                                                                <label for="f_name">Primer Nombre <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" id="f_name" name="f_name"
                                                                       placeholder="" class="form-control"
                                                                       value="{{ $users->first_name}}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="last_name">Apellidos <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" id="l_name" name="l_name"
                                                                       class="form-control"
                                                                       value="{{ $users->last_name}}">
                                                            </div>
                                                        </div>


                                                        <div class="row form-group">
                                                            <div class="col-md-6">
                                                                <label for="email">Email <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" id="email" name="email"
                                                                       class="form-control" value="{{ $users->email}}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="mobile">Celular <span class="text-danger">*</span></label>
                                                                <input type="text" id="mobile" name="mobile"
                                                                       class="form-control" maxlength="10"
                                                                       value="{{ $users->mobile}}">
                                                            </div>
                                                        </div>


                                                        @if(Auth::guard('admin')->user()->user_type=="Admin")
                                                            <div class="row form-group">
                                                                <div class="col-md-6">
                                                                    <label for="email">Número de Registro<span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" id="registration_no"
                                                                           name="registration_no"
                                                                           value="{{ $users->registration_no}}"
                                                                           class="form-control" autocomplete="off">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="mobile">Nombre de Asociado <span
                                                                            class="text-danger">*</span></label>
                                                                    <input type="text" id="associated_name"
                                                                           name="associated_name" class="form-control"
                                                                           autocomplete="off"
                                                                           value="{{ $users->associated_name}}">
                                                                </div>
                                                            </div>
                                                        @endif

                                                        <div class="row form-group">
                                                            <div class="col-md-9">
                                                                <label for="address">Dirección <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" id="address" name="address"
                                                                       class="form-control"
                                                                       value="{{ $users->address}}">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="zipcode">Codigo Postal<span class="text-danger">*</span></label>
                                                                <input type="text" id="zip_code" name="zip_code"
                                                                       class="form-control" maxlength=""
                                                                       value="{{ $users->zipcode}}">
                                                            </div>
                                                        </div>


                                                        <div class="row form-group">
                                                            <div class="col-md-4">
                                                                <label for="country">País <span
                                                                        class="text-danger">*</span></label>
                                                                <select
                                                                    class="form-control select-change country-select2 select2-profile-country"
                                                                    name="country" id="country"
                                                                    data-url="{{ route('get.country') }}"
                                                                    data-clear="#city_id,#state"
                                                                >
                                                                    <option value=""> Selecciona País</option>
                                                                    @if ($users->country)
                                                                        <option value="{{ $users->country->id }}"
                                                                                selected>{{ $users->country->name }}</option>
                                                                    @endif

                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="state">Departamento <span
                                                                        class="text-danger">*</span></label>
                                                                <select id="state" name="state"

                                                                        data-url="{{ route('get.state') }}"
                                                                        data-target="#country"
                                                                        data-clear="#city_id"
                                                                        class="form-control state-select2 select-change select2-profile-state">
                                                                    <option value=""> Elije Departamento</option>
                                                                    @if ($users->state)
                                                                        <option value="{{ $users->state->id }}"
                                                                                selected>{{ $users->state->name }}</option>
                                                                    @endif


                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="city">Provincia <span
                                                                        class="text-danger">*</span></label>
                                                                <select id="city_id" name="city_id"
                                                                        data-url="{{ route('get.city') }}"
                                                                        data-target="#state"

                                                                        class="form-control city-select2">
                                                                    <option value=""> Elije Provincia</option>
                                                                    @if($users->city)
                                                                        <option value="{{ $users->city->id }}"
                                                                                selected>{{ $users->city->name }}</option>
                                                                    @endif


                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group pull-right">
                                                        <div class="col-md-12 col-sm-6 col-xs-12">
                                                            <br>
                                                            <input type="hidden" name="route-exist-check"
                                                                   id="route-exist-check"
                                                                   value="{{ url('admin/check_user_email_exits') }}">
                                                            <input type="hidden" name="token-value"
                                                                   id="token-value"
                                                                   value="{{csrf_token()}}">

                                                            <button type="submit" class="btn btn-success"
                                                                    id="upload-result"><i class="fa fa-save"
                                                                                          id="show_loader"></i>&nbsp;Actualizar
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{asset('assets/admin/js/selectjs.js')}}"></script>
    <script src="{{ asset('assets/admin/jcropper/js/cropper.min.js') }}"></script>
    <script src="{{asset('assets/js/profile/image-crop.js')}}"></script>
    <script src="{{asset('assets/js/profile/profile-validation.js')}}"></script>
    <script src="{{asset('assets/js/profile/change-password-validation.js')}}"></script>
@endpush
