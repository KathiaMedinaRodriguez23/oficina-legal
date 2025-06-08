@extends('admin.layout.app')
@section('title','Client Edit')
@section('content')
    @component('component.heading' , [

    'page_title' => 'Editar Cliente',
    'action' => route('clients.index') ,
    'text' => 'Atras'
     ])
    @endcomponent
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

                        <div class="row">

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="f_name">Primer nombre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="f_name" name="f_name"
                                       value="{{ $client->first_name ?? ''}}">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="m_name">Segundo nombre <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="m_name" name="m_name"
                                       value="{{ $client->middle_name ?? ''}}">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">Apellidos <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="l_name" name="l_name"
                                       value="{{ $client->last_name ?? ''}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">Genero <span class="text-danger">*</span></label><br>

                                <input type="radio" name="gender" id="genderM"
                                       value="Male" {{ (!empty($client->gender) && $client->gender =='Male') ? "checked" : "" }} />
                                &nbsp;&nbsp;Masculino:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="gender" id="genderF"
                                       value="Female" {{ (!empty($client->gender) && $client->gender =='Female') ? "checked" : "" }}/>&nbsp;&nbsp;Femenino
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">Email</label>
                                <input type="text" value="{{ $client->email ?? ''}}" placeholder="" class="form-control"
                                       id="email" name="email">
                            </div>

                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">Celular <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" class="form-control" id="mobile" name="mobile"
                                       value="{{ $client->mobile ?? ''}}" maxlength="10">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">Celular</label>
                                <input type="text" value="{{ $client->alternate_no ?? ''}}" placeholder=""
                                       class="form-control" id="alternate_no" name="alternate_no" maxlength="10">
                            </div>
                            <div class="col-md-9 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">Direccion <span class="text-danger">*</span></label>
                                <input type="text" placeholder="" value="{{ $client->address ?? ''}}"
                                       class="form-control" id="address" name="address">
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

                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">Segundo nombre <span
                                                                    class="text-danger">*</span></label>
                                                        <input type="text" id="middlename" name="middlename"
                                                               data-rule-required="true"
                                                               data-msg-required="Por favor, ingrese el segundo nombre."
                                                               class="form-control"
                                                               value="{{ $value->party_middlename }}">
                                                    </div>

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
                                                               data-msg-required="Please enter mobile number."
                                                               data-rule-number="true"
                                                               data-msg-number="Por favor, ingrese solo dígitos del 0 al 9."
                                                               data-rule-minlength="10"
                                                               data-msg-minlength="El número debe tener 9 dígitos."
                                                               data-rule-maxlength="10"
                                                               data-msg-maxlength="El número debe tener 9 dígitos."
                                                               class="form-control" value="{{ $value->party_mobile }}"
                                                               maxlength="10">
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

                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">Segundo nombre <span class="text-danger">*</span></label>
                                                    <input type="text" id="middlename" name="middlename"
                                                           data-rule-required="true"
                                                           data-msg-required="Por favor, ingrese el segundo nombre."
                                                           class="form-control">
                                                </div>

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
                                                           data-rule-minlength="10"
                                                           data-msg-minlength="El número debe tener 9 dígitos."
                                                           data-rule-maxlength="10"
                                                           data-msg-maxlength="El número debe tener 9 dígitos."
                                                           class="form-control" maxlength="10">
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
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <br>
                                    <button data-repeater-create type="button" value="Add New"
                                            class="btn btn-success waves-effect waves-light btn btn-success-edit"
                                            type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
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

                                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                        <label for="fullname">Segundo nombre <span
                                                                    class="text-danger">*</span></label>
                                                        <input type="text" id="middlename" name="middlename"
                                                               data-rule-required="true"
                                                               data-msg-required="Por favor, ingrese el segundo nombre."
                                                               class="form-control"
                                                               value="{{ $value->party_middlename }}">
                                                    </div>

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
                                                               data-rule-minlength="10"
                                                               data-msg-minlength="El número debe tener 9 dígitos."
                                                               data-rule-maxlength="10"
                                                               data-msg-maxlength="El número debe tener 9 dígitos."
                                                               class="form-control" value="{{ $value->party_mobile }}"
                                                               maxlength="10">
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

                                                <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                                    <label for="fullname">Segundo nombre <span class="text-danger">*</span></label>
                                                    <input type="text" id="middlename" name="middlename"
                                                           data-rule-required="true"
                                                           data-msg-required="Por favor, ingrese el segundo nombre." class="form-control">
                                                </div>

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
                                                           data-rule-minlength="10"
                                                           data-msg-minlength="El número debe tener 9 dígitos."
                                                           data-rule-maxlength="10"
                                                           data-msg-maxlength="El número debe tener 9 dígitos.."
                                                           class="form-control" maxlength="10">
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
                                                                                 id="show_loader"></i>&nbsp;Save
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
