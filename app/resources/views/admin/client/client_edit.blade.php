@extends('admin.layout.app')
@section('title','Editar Cliente')
@section('content')
    @component('component.heading' , [

    'page_title' => 'Editar Cliente',
    'action' => route('clients.index') ,
    'text' => 'Atras'
     ])
    @endcomponent
    @php
        $docType = old('document_type', $client->document_type);
    @endphp
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('component.error')
            <div class="x_panel">
                <form id="edit_client_form" name="edit_client_form" role="form" method="POST"
                      action="{{route('clients.update',$client->id)}}">
                    <input type="hidden" id="id" value="{{ $client->id}}" name="id">
                    {{ csrf_field() }}
                    <input name="_method" type="hidden" value="PATCH">
                    <div class="x_content">
                        {{-- BLOQUE DNI --}}
                        <div id="block-dni" style="display: {{ $docType==='dni' ? 'block':'none' }};">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="f_name">Primer nombre <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="f_name" name="f_name"
                                           value="{{ old('f_name', $client->first_name) }}">
                                    <div class="error-message">{{ $errors->first('f_name') }}</div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="m_name">Segundo nombre</label>
                                    <input type="text" class="form-control" id="m_name" name="m_name"
                                           value="{{ old('m_name', $client->middle_name) }}">
                                    <div class="error-message">{{ $errors->first('m_name') }}</div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="l_name">Apellidos <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="l_name" name="l_name"
                                           value="{{ old('l_name', $client->last_name) }}">
                                    <div class="error-message">{{ $errors->first('l_name') }}</div>
                                </div>
                            </div>
                        </div>
                        {{-- BLOQUE RUC --}}
                        <div id="block-ruc" style="display: {{ $docType==='ruc' ? 'block':'none' }};">
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="razon_social">Razón Social <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="razon_social" name="razon_social"
                                           value="{{ old('razon_social', $client->first_name) }}">
                                    <div class="error-message">{{ $errors->first('razon_social') }}</div>
                                </div>
                            </div>
                        </div>
                        {{-- FILA GÉNERO / EMAIL / CELULAR --}}
                        <div class="row">
                            <div id="block-gender" class="col-md-4 form-group">
                                <label>Género <span class="text-danger">*</span></label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="genderM" value="Male"
                                        {{ old('gender', $client->gender)=='Male'?'checked':'' }}> Masculino
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="gender" id="genderF" value="Female"
                                        {{ old('gender', $client->gender)=='Female'?'checked':'' }}> Femenino
                                </label>
                                <div class="error-message">{{ $errors->first('gender') }}</div>
                            </div>

                            <div id="block-email" class="col-md-4 form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ old('email', $client->email) }}">
                                <div class="error-message">{{ $errors->first('email') }}</div>
                            </div>

                            <div id="block-phone" class="col-md-4 form-group">
                                <label for="mobile">Celular <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="mobile" name="mobile" maxlength="9"
                                       value="{{ old('mobile', $client->mobile) }}">
                                <div class="error-message">{{ $errors->first('mobile') }}</div>
                            </div>
                        </div>
                        {{-- DOCUMENTO + DIRECCIÓN --}}
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Documento de Identidad <span class="text-danger">*</span></label><br>
                                <label class="radio-inline">
                                    <input type="radio" name="document_type" id="dni" value="dni"
                                        {{ $docType==='dni'?'checked':'' }}> DNI
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="document_type" id="ruc" value="ruc"
                                        {{ $docType==='ruc'?'checked':'' }}> RUC
                                </label>

                                <input type="text" class="form-control" id="document_number" name="document_number"
                                       placeholder="{{ $docType==='dni'?'Ej: 01234567':'Ej: 20123456789' }}"
                                       maxlength="{{ $docType==='dni'?8:11 }}"
                                       value="{{ old('document_number', $client->dni_ruc) }}">
                                <div class="error-message" id="error_message" style="display:none"></div>
                            </div>
                            <div class="col-md-8 form-group">
                                <label for="address">Dirección <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address" name="address"
                                       value="{{ old('address', $client->address) }}">
                                <div class="error-message">{{ $errors->first('address') }}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">Pais <span class="text-danger">*</span></label>
                                <select class="form-control select-change country-select2 selct2-width-100 "
                                        name="country" id="country"
                                        data-url="{{ route('get.country') }}"
                                        data-clear="#city_id,#state"
                                >
                                    <option value=""> Seleccione</option>
                                    @if ($client->country)
                                        <option value="{{ $client->country->id }}"
                                                selected>{{ $client->country->name }}</option>
                                    @endif
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">Departamento <span class="text-danger">*</span></label>
                                <select id="state" name="state"

                                        data-url="{{ route('get.state') }}"
                                        data-target="#country"
                                        data-clear="#city_id"
                                        class="form-control state-select2 select-change">
                                    <option value=""> Seleccione</option>
                                    @if ($client->state)
                                        <option value="{{ $client->state->id }}"
                                                selected>{{ $client->state->name }}</option>
                                    @endif

                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">Ciudad <span class="text-danger">*</span></label>
                                <select id="city_id" name="city_id"
                                        data-url="{{ route('get.city') }}"
                                        data-target="#state"

                                        class="form-control city-select2">
                                    <option value=""> Seleccione Ciudad</option>
                                    @if($client->city)
                                        <option value="{{ $client->city->id }}"
                                                selected>{{ $client->city->name }}</option>
                                    @endif

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">Nombre de referencia </label>
                                <input type="text" placeholder="" class="form-control" id="reference_name"
                                       name="reference_name" value="{{ $client->reference_name ?? ''}}">
                            </div>

                            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">Celular de referencia </label>
                                <input type="text" placeholder="" class="form-control" id="reference_mobile"
                                       name="reference_mobile" value="{{ $client->reference_mobile ?? ''}}">
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
                                    <label for="fullname">Cliente <span class="text-danger">*</span></label><br>
                                    <br>
                                    <input type="radio" name="type" id="test6"
                                           value="single" {{ (!empty($client->client_type) && $client->client_type =='single') ? "checked" : "" }} />
                                    &nbsp;&nbsp;Unico Defensor:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="type" id="test7"
                                           value="multiple" {{ (!empty($client->client_type) && $client->client_type =='multiple') ? "checked" : "" }} />&nbsp;&nbsp;Multiples defensores
                                </div>
                            </div>
                            <div class="repeater one">
                                <div data-repeater-list="group-a">
                                    @if(!empty($client_parties_invoive) && count($client_parties_invoive)>0 && $client->client_type =='single')
                                        @foreach($client_parties_invoive as $key=> $value)
                                            <div data-repeater-item>
                                                <div class="row border-addmore">
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">Primer nombre <span
                                                                    class="text-danger">*</span></label>
                                                        <input type="text" id="firstname" name="firstname"
                                                               data-rule-required="true"
                                                               data-msg-required="PPor favor, ingrese el primer nombre."
                                                               class="form-control"
                                                               value="{{ $value->party_firstname }}">
                                                    </div>

                                                   <!-- <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">Segundo nombre <span
                                                                    class="text-danger">*</span></label>
                                                        <input type="text" id="middlename" name="middlename"
                                                               data-rule-required="true"
                                                               data-msg-required="Por favor, ingrese el segundo nombre."
                                                               class="form-control"
                                                               value="{{ $value->party_middlename }}">
                                                    </div>-->

                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">Apellidos <span
                                                                    class="text-danger">*</span></label>
                                                        <input type="text" id="lastname" name="lastname"
                                                               data-rule-required="true"
                                                               data-msg-required="Por favor, ingrese el apellido."
                                                               class="form-control"
                                                               value="{{ $value->party_lastname }}">
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">Celular <span
                                                                    class="text-danger">*</span></label>
                                                        <input type="text" id="mobile_client" name="mobile_client"
                                                               data-rule-required="true"
                                                               data-msg-required="Por favor introduce el número de móvil."
                                                               data-rule-number="true"
                                                               data-msg-number="Por favor, ingrese solo dígitos del 0 al 9."
                                                               data-rule-minlength="9"
                                                               data-msg-minlength="El número debe tener 9 dígitos."
                                                               data-rule-maxlength="9"
                                                               data-msg-maxlength="El número debe tener 9 dígitos."
                                                               class="form-control" value="{{ $value->party_mobile }}"
                                                               maxlength="9">
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">Dirrecion <span class="text-danger">*</span></label>
                                                        <input type="text" id="address_client" name="address_client"
                                                               data-rule-required="true"
                                                               data-msg-required="Por favor, ingrese la dirección."
                                                               class="form-control" value="{{ $value->party_address }}">
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <br>
                                                        <button type="button" data-repeater-delete type="button"
                                                                class="btn btn-danger"><i class="fa fa-trash-o"
                                                                                          aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div data-repeater-item>
                                            <div class="row border-addmore">
                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">Primer nombre <span class="text-danger">*</span></label>
                                                    <input type="text" id="firstname" name="firstname"
                                                           data-rule-required="true"
                                                           data-msg-required="Por favor, ingrese el primer nombre."
                                                           class="form-control">
                                                </div>

                                             <!--   <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">Segundo nombre <span class="text-danger">*</span></label>
                                                    <input type="text" id="middlename" name="middlename"
                                                           data-rule-required="true"
                                                           data-msg-required="Por favor, ingrese el segundo nombre."
                                                           class="form-control">
                                                </div>-->

                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">Apellidos <span
                                                                class="text-danger">*</span></label>
                                                    <input type="text" id="lastname" name="lastname"
                                                           data-rule-required="true"
                                                           data-msg-required="Por favor, ingrese los apellidos."
                                                           class="form-control">
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">Celular <span class="text-danger">*</span></label>
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
                                                    <label for="fullname">Dirrecion <span
                                                                class="text-danger">*</span></label>
                                                    <input type="text" id="address_client" name="address_client"
                                                           data-rule-required="true"
                                                           data-msg-required="Por favor, ingrese la dirección."
                                                           class="form-control">
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <br>
                                                    <button type="button" data-repeater-delete type="button"
                                                            class="btn btn-danger"><i class="fa fa-trash-o"
                                                                                      aria-hidden="true"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                    @endif
                                </div>
                            </div>
                            <div class="repeater two">
                                <div data-repeater-list="group-b">
                                    @if(!empty($client_parties_invoive) && count($client_parties_invoive)>0 && $client->client_type =='multiple')
                                        @foreach($client_parties_invoive as $key=> $value)
                                            <div data-repeater-item>
                                                <div class="row border-addmore">
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">Primer nombre <span
                                                                    class="text-danger">*</span></label>
                                                        <input type="text" id="firstname" name="firstname"
                                                               data-rule-required="true"
                                                               data-msg-required="Por favor, ingrese el primer nombre."
                                                               class="form-control"
                                                               value="{{ $value->party_firstname }}">
                                                    </div>

                                                 <!--   <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">Segundo nombre <span
                                                                    class="text-danger">*</span></label>
                                                        <input type="text" id="middlename" name="middlename"
                                                               data-rule-required="true"
                                                               data-msg-required="Por favor, ingrese el segundo nombre."
                                                               class="form-control"
                                                               value="{{ $value->party_middlename }}">
                                                    </div>-->

                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">Apellidos <span
                                                                    class="text-danger">*</span></label>
                                                        <input type="text" id="lastname" name="lastname"
                                                               data-rule-required="true"
                                                               data-msg-required="Por favor, ingrese el apellido."
                                                               class="form-control"
                                                               value="{{ $value->party_lastname }}">
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">Celular <span
                                                                    class="text-danger">*</span></label>
                                                        <input type="text" id="mobile_client" name="mobile_client"
                                                               data-rule-required="true"
                                                               data-msg-required="Por favor, ingrese el número de celular."
                                                               data-rule-number="true"
                                                               data-msg-number="Por favor, ingrese solo dígitos del 0 al 9."
                                                               data-rule-minlength="9"
                                                               data-msg-minlength="El número debe tener 9 dígitos."
                                                               data-rule-maxlength="9"
                                                               data-msg-maxlength="El número debe tener 9 dígitos."
                                                               class="form-control" value="{{ $value->party_mobile }}"
                                                               maxlength="9">
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">Direccion <span class="text-danger">*</span></label>
                                                        <input type="text" id="address_client" name="address_client"
                                                               data-rule-required="true"
                                                               data-msg-required="Por favor, ingrese la dirección."
                                                               class="form-control" value="{{ $value->party_address }}">
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">Nombre del defensor(a). <span
                                                                    class="text-danger">*</span></label>
                                                        <input type="text" id="advocate_name" name="advocate_name"
                                                               data-rule-required="true"
                                                               data-msg-required="Por favor ingrese el nombre del defensor."
                                                               class="form-control"
                                                               value="{{ $value->party_advocate }}">
                                                    </div>
                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <br>
                                                        <button type="button" data-repeater-delete type="button"
                                                                class="btn btn-danger waves-effect waves-light"><i
                                                                    class="fa fa-trash-o" aria-hidden="true"></i>
                                                        </button>
                                                    </div>

                                                </div>

                                            </div>
                                        @endforeach
                                    @else
                                        <div data-repeater-item>
                                            <div class="row border-addmore">
                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">Primer nombre <span class="text-danger">*</span></label>
                                                    <input type="text" id="firstname" name="firstname"
                                                           data-rule-required="true"
                                                           data-msg-required="Por favor, ingrese el primer nombre." class="form-control">
                                                </div>

                                           <!--     <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">Segundo nombre <span class="text-danger">*</span></label>
                                                    <input type="text" id="middlename" name="middlename"
                                                           data-rule-required="true"
                                                           data-msg-required="Por favor, ingrese el segundo nombre." class="form-control">
                                                </div>-->

                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">Apellidos <span
                                                                class="text-danger">*</span></label>
                                                    <input type="text" id="lastname" name="lastname"
                                                           data-rule-required="true"
                                                           data-msg-required="Por favor, ingrese el apellido." class="form-control">
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">Celular <span class="text-danger">*</span></label>
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
                                                    <label for="fullname">Dirreccion <span
                                                                class="text-danger">*</span></label>
                                                    <input type="text" id="address_client" name="address_client"
                                                           data-rule-required="true"
                                                           data-msg-required="Por favor, ingrese la dirección."
                                                           class="form-control">
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">Nombre del defensor(a). <span
                                                                class="text-danger">*</span></label>
                                                    <input type="text" id="advocate_name" name="advocate_name"
                                                           data-rule-required="true"
                                                           data-msg-required="Por favor, ingrese el nombre del abogado."
                                                           class="form-control">
                                                </div>
                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <br>
                                                    <button type="button" data-repeater-delete type="button"
                                                            class="btn btn-danger waves-effect waves-light"><i
                                                                class="fa fa-trash-o" aria-hidden="true"></i></button>
                                                </div>

                                            </div>

                                        </div>

                                    @endif
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <br>
                                    <button data-repeater-create type="button" value="Add New"
                                            class="btn btn-success waves-effect waves-light btn btn-success-edit"
                                            type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group pull-right">
                            <div class="col-md-12 col-sm-6 col-xs-12">
                                <a href="{{ route('clients.index')  }}" class="btn btn-danger">Cancelar</a>
                                <button type="submit" class="btn btn-success"><i class="fa fa-save"
                                                                                 id="show_loader"></i>&nbsp;Guardar
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
    <script src="{{asset('assets/js/client/edit-client-validation.js')}}"></script>
    <script src="{{asset('assets/js/client/document-type-validation.js')}}"></script>
    <script src="{{asset('assets/js/client/validate-phone.js')}}"></script>
    @if(!empty($client->client_type) && $client->client_type =='single')
        <script type="text/javascript">
            'use strict';
            $('.two').css('display', 'none');
        </script>
    @endif
    @if(!empty($client->client_type) && $client->client_type =='multiple')
        <script type="text/javascript">
            'use strict';
            $('.one').css('display', 'none');
        </script>
    @endif
    @if(!empty($client_parties_invoive) && count($client_parties_invoive)>0  || !empty($client_parties_invoive) && count($client_parties_invoive)>0 )
        <script type="text/javascript">
            'use strict';
            $('#change_court_div').removeClass('hidden');
            $('#change_court_chk').prop('checked', true);
        </script>
    @endif
@endpush
