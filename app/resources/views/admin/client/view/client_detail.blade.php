@extends('admin.layout.app')
@section('title','Client Detail')
@section('content')
    <div class="page-title">
        <div class="title_left">
            <h4>Nombre del Cliente : {{$name}} </h4>
        </div>


    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="{{ request()->is('admin/clients/*') ? 'active' : '' }}"><a
                                href="{{ route('clients.show', [$client->id]) }}">Detalles</a>
                        </li>

                        @if($adminHasPermition->can(['case_list']) =="1")
                            <li class="{{ request()->is('admin/client/case-list/*') ? 'active' : '' }}"
                                role="presentation"><a href="{{route('clients.case-list',[$client->id])}}">Casos</a>
                            </li>
                        @endif


                        {{--
                        @if($adminHasPermition->can(['invoice_list']) =="1")
                            <li class="{{ request()->is('admin/client/account-list/*') ? 'active' : '' }}"
                                role="presentation"><a
                                    href="{{route('clients.account-list',[$client->id])}}">Cuenta</a>
                            </li>
                        @endif
                        --}}
                    </ul>

                </div>

                <div class="x_content">

                    <div class="dashboard-widget-content">
                        <div class="col-md-6 hidden-small">
                            <table class="countries_list">
                                <tbody>
                                <tr>
                                    <td>Cliente</td>
                                    <td class="fs15 fw700 text-right">{{ $client->full_name}}</td>
                                </tr>
                                <tr>
                                    <td>Celular</td>
                                    <td class="fs15 fw700 text-right">{{ $client->mobile ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Referencias</td>
                                    <td class="fs15 fw700 text-right">{{ $client->reference_name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>País</td>
                                    <td class="fs15 fw700 text-right">{{ $client->country->name }}</td>
                                </tr>
                                <tr>
                                    <td>Departamento</td>
                                    <td class="fs15 fw700 text-right">{{ $client->state->name }}</td>
                                </tr>
                                <tr>
                                    <td>Ciudad</td>
                                    <td class="fs15 fw700 text-right">{{ $client->city->name }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6 hidden-small">

                            <table class="countries_list">
                                <tbody>

                                <tr>
                                    <td>Email</td>
                                    <td class="fs15 fw700 text-right s">{{ $client->email ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>DNI/RUC</td>
                                    <td class="fs15 fw700 text-right">{{ $client->alternate_no ?? '' }} </td>
                                </tr>
                                <tr>
                                    <td>Celular de Referencia</td>
                                    <td class="fs15 fw700 text-right">{{ $client->reference_mobile ?? '' }}</td>
                                </tr>
                                <tr>
                                    <td>Dirección</td>
                                    <td class="fs15 fw700 text-right">{{ $client->address ?? '' }}</td>

                                </tr>


                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            @if(count($single)>0 && !empty($single))
                <div class="x_panel">

                    <div class="x_content">
                        <div class="dashboard-widget-content">
                            @php
                                $i=1;
                            @endphp
                            @if(isset($single) && !empty($single))
                                @foreach($single as $s)
                                    <div class="col-md-6 hidden-small">
                                        <h4 class="line_30">Defensor</h4>


                                        <table class="countries_list">
                                            <tbody>

                                            <tr>
                                                <td>{{$i.' ) '.$s->party_firstname.' '.$s->party_middlename.' '.$s->party_lastname }}</td>

                                            </tr>
                                            <tr>
                                                <td>Celular :- {{ $s->party_mobile}}</td>

                                            </tr>
                                            <tr>
                                                <td>Dirección :-{{ $s->party_address}}</td>

                                            </tr>
                                            @if($client->client_type=="multiple")
                                                <tr>
                                                    <td>Defensor:-{{ $s->party_advocate}}</td>

                                                </tr>

                                            @endif


                                            </tbody>
                                        </table>
                                    </div>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach

                            @endif


                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection
