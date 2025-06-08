@extends('admin.layout.app')
@section('title','Client Create')
@push('style')
    <style>
        .error-message {
            color: #a94442;
            font-size: 1em;
            margin-top: 5px;
            font-weight: 700;
        }
        .form-control.is-invalid {
            border-color: #a94442;
        }
        .form-control.is-valid {
            border-color: #28a745;
        }
    </style>
@endpush
@section('content')
    @component('component.heading' , [
    'page_title' => 'Agregar Cliente',
    'action' => route('clients.index') ,
    'text' => 'Atras'
     ])
    @endcomponent
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('component.error')
            <div class="x_panel">
                <form id="add_client" name="add_client" role="form" method="POST" autocomplete="nope"
                      action="{{route('clients.store')}}">
                    {{ csrf_field() }}
                    <div class="x_content">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="f_name">Primer nombre <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="f_name" name="f_name">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="m_name">Segundo nombre <span class="text-danger"></span></label>
                                <input type="text" placeholder="" class="form-control" id="m_name" name="m_name">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="l_name">Apellidos <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="l_name" name="l_name">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label>Genero <span class="text-danger">*</span></label><br>
                                <input type="radio" name="gender" id="genderM" value="Male" checked required/>
                                &nbsp;&nbsp;Masculino&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="gender" id="genderF" value="Female"/>&nbsp;&nbsp;Femenino
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="email">Email </label>
                                <input type="text" placeholder="" class="form-control" id="email" name="email">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="mobile">Celular <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="mobile" maxlength="9"
                                       name="mobile">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <div class="row">
                                    <label for="document_number" id="dni_ruc_label">
                                        <br />
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input
                                        type="radio" name="document_type" id="dni" value="dni" checked required
                                    /> DNI
                                    &nbsp;&nbsp;
                                    <input type="radio" name="document_type" id="ruc" value="ruc" />
                                    RUC
                                </div>

                                <input
                                    type="text"
                                    class="form-control"
                                    id="document_number"
                                    name="document_number"
                                    placeholder="Ej: 01234567"
                                />
                                <div class="error-message" id="error_message" style="display: none;"></div>
                            </div>

                            <div class="col-md-8 col-sm-12 col-xs-12 form-group">
                                <label for="address">Dirección <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="address" name="address">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="country">Pais <span class="text-danger">*</span></label>
                                <select class="form-control select-change country-select2"
                                        name="country" id="country"
                                        data-url="{{ route('get.country') }}"
                                        data-clear="#city_id,#state"
                                >
                                    <option value=""> Selecciona un Pais</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="state">Departamento <span class="text-danger">*</span></label>
                                <select id="state" name="state"
                                        data-url="{{ route('get.state') }}"
                                        data-target="#country"
                                        data-clear="#city_id"
                                        class="form-control state-select2 select-change">
                                    <option value=""> Selecciona</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="city_id">Ciudad <span class="text-danger">*</span></label>
                                <select id="city_id" name="city_id"
                                        data-url="{{ route('get.city') }}"
                                        data-target="#state"
                                        class="form-control city-select2">
                                    <option value=""> Elije Ciudad</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="reference_name">Persona de referencia </label>
                                <input type="text" placeholder="" class="form-control" id="reference_name"
                                       name="reference_name">
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="reference_mobile">Celular de Referencia </label>
                                <input type="text" placeholder="" class="form-control" id="reference_mobile"
                                       name="reference_mobile">
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <br>
                            <input type="checkbox" value="Yes" name="change_court_chk" id="change_court_chk"> Agrega a mas personas
                            <br/>
                        </div>

                        <div id="change_court_div" class="hidden">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label>Defensor <span class="text-danger">*</span></label><br>
                                    <br>
                                    <input type="radio" name="type" id="test6" value="single" checked required/>
                                    &nbsp;&nbsp;Defensor unico&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="type" id="test7" value="multiple"/>&nbsp;&nbsp;Multiples Defensores
                                </div>
                            </div>

                            <div class="repeater one">
                                <div data-repeater-list="group-a">
                                    <div data-repeater-item>
                                        <div class="row border-addmore">
                                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                <label for="firstname">Primer nombre <span class="text-danger">*</span></label>
                                                <input type="text" id="firstname" name="firstname"
                                                       data-rule-required="true"
                                                       data-msg-required="Por favor, ingrese el nombre."
                                                       class="form-control">
                                            </div>

                                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                <label for="middlename">Segundo nombre <span class="text-danger">*</span></label>
                                                <input type="text" id="middlename" name="middlename"
                                                       data-rule-required="true"
                                                       data-msg-required="Por favor, ingrese el segundo nombre."
                                                       class="form-control">
                                            </div>

                                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                <label for="lastname">Apellido <span class="text-danger">*</span></label>
                                                <input type="text" id="lastname" name="lastname"
                                                       data-rule-required="true"
                                                       data-msg-required="Por favor, ingrese el apellido."
                                                       class="form-control">
                                            </div>

                                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                <label for="mobile_client">Celular <span class="text-danger">*</span></label>
                                                <input type="text" id="mobile_client" name="mobile_client"
                                                       data-rule-required="true"
                                                       data-msg-required="Por favor, ingrese el número de celular."
                                                       data-rule-number="true"
                                                       data-msg-number="Por favor, ingrese solo dígitos del 0 al 9."
                                                       data-rule-minlength="9"
                                                       data-msg-minlength="El número debe tener 9 dígitos."
                                                       data-rule-maxlength="10"
                                                       data-msg-maxlength="El número debe tener 9 dígitos."
                                                       class="form-control" maxlength="9">
                                            </div>

                                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                <label for="address_client">Direccion <span class="text-danger">*</span></label>
                                                <input type="text" id="address_client" name="address_client"
                                                       data-rule-required="true"
                                                       data-msg-required="Por favor, ingrese la dirección."
                                                       class="form-control">
                                            </div>

                                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                <br>
                                                <button data-repeater-delete type="button" class="btn btn-danger">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <br>
                                    <button data-repeater-create type="button" value="Add New"
                                            class="btn btn-success waves-effect waves-light btn btn-success-edit">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="repeater two">
                                <div data-repeater-list="group-b">
                                    <div data-repeater-item>
                                        <div class="row border-addmore">
                                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                <label for="firstname">Primer nombre <span class="text-danger">*</span></label>
                                                <input type="text" id="firstname" name="firstname"
                                                       data-rule-required="true"
                                                       data-msg-required="Por favor, ingrese el primer nombre."
                                                       class="form-control">
                                            </div>

                                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                <label for="middlename">Segundo nombre <span class="text-danger">*</span></label>
                                                <input type="text" id="middlename" name="middlename"
                                                       data-rule-required="true"
                                                       data-msg-required="Por favor, ingrese el segundo nombre."
                                                       class="form-control">
                                            </div>

                                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                <label for="lastname">Apellidos <span class="text-danger">*</span></label>
                                                <input type="text" id="lastname" name="lastname"
                                                       data-rule-required="true"
                                                       data-msg-required="Por favor, ingrese el apellido."
                                                       class="form-control">
                                            </div>

                                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                <label for="mobile_client">Celular <span class="text-danger">*</span></label>
                                                <input type="text" id="mobile_client" name="mobile_client"
                                                       data-rule-required="true"
                                                       data-msg-required="Por favor, ingrese el número de celular."
                                                       data-rule-number="true"
                                                       data-msg-number="Por favor, ingrese solo dígitos del 0 al 9."
                                                       data-rule-minlength="9"
                                                       data-msg-minlength="El número debe tener 9 dígitos."
                                                       data-rule-maxlength="9"
                                                       data-msg-maxlength="El número debe tener 9 dígitos."
                                                       class="form-control" maxlength="9">
                                            </div>

                                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                <label for="address_client">Direccion <span class="text-danger">*</span></label>
                                                <input type="text" id="address_client" name="address_client"
                                                       data-rule-required="true"
                                                       data-msg-required="Por favor, ingrese la dirección."
                                                       class="form-control">
                                            </div>

                                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                <label for="advocate_name">Defensor <span class="text-danger">*</span></label>
                                                <input type="text" id="advocate_name" name="advocate_name"
                                                       data-rule-required="true"
                                                       data-msg-required="Por favor, ingrese el nombre del abogado."
                                                       class="form-control">
                                            </div>

                                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                <br>
                                                <button data-repeater-delete type="button"
                                                        class="btn btn-danger waves-effect waves-light">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <br>
                                    <button data-repeater-create type="button" value="Add New"
                                            class="btn btn-success waves-effect waves-light btn btn-success-edit">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group pull-right">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <a href="{{ route('clients.index')  }}" class="btn btn-danger">Cancelar</a>
                                <input type="hidden" name="route-exist-check"
                                       id="route-exist-check"
                                       value="{{ url('admin/check_client_email_exits') }}">
                                <input type="hidden" name="token-value"
                                       id="token-value"
                                       value="{{csrf_token()}}">

                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save" id="show_loader"></i>&nbsp;Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('assets/admin/js/selectjs.js')}}"></script>
    <script src="{{asset('assets/admin/vendors/repeter/repeater.js')}}"></script>
    <script src="{{asset('assets/admin/vendors/jquery-ui/jquery-ui.js') }}"></script>
    <script src="{{asset('assets/js/client/add-client-validation.js')}}"></script>
    <script src="{{asset('assets/js/client/document-type-validation.js') }}"></script>
@endpush
