@extends('admin.layout.app')
@section('title','Editar Citacion')
@push('style')
    <style>
        .error-message {
            color: #a94442;
            font-size: 12px;
        }
        .alert.alert-info.alert-dismissible.fade.in {
            background-color: #a94442;
            border-color: #a94442;
            color: white;
        }
    </style>
@endpush
@section('content')

    <div class="page-title">
        <div class="title_left">
            <h3>Editar Cita</h3>
        </div>

        <div class="title_right">
            <div class="form-group pull-right top_search">
                <a href="{{ route('appointment.index') }}" class="btn btn-primary">Cerrar</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('component.error')
            <div class="x_panel">
                <div class="x_content">
                    <form id="add_appointment" name="add_appointment" role="form" method="POST"
                          action="{{route('appointment.update',$appointment->id)}}">
                        <input name="_method" type="hidden" value="PATCH">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="x_content">

                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <strong>Ups!</strong> Revise las siguientes indicaciones:.<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                                <div class="row">
                                    <div class="form-group col-md-6">

                                        <input type="radio" id="test5" value="new" name="type"
                                               @if($appointment->type=="new") checked @endif>

                                        <b> Nuevo Cliente
                                        </b>


                                    </div>

                                    <div class="form-group col-md-6">

                                        <input type="radio" id="test4" value="exists" name="type"
                                               @if($appointment->type=="exists") checked @endif>

                                        <b> Cliente Existente
                                        </b>


                                    </div>
                                </div>
                                <br>
                                <div class="row exists">
                                    <div class="col-md-12">

                                        <div class="form-group">
                                            @if(count($client_list)>0)
                                                <label class="discount_text">Seleccionar Cliente
                                                    <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select class="form-control selct2-width-100" name="exists_client"
                                                        id="exists_client"
                                                        onchange="getMobileno(this.value);">
                                                    <option value="">Seleccionar Cliente</option>
                                                    @foreach($client_list as $list)
                                                        <option value="{{ $list->id}}"
                                                                @if(!empty($appointment->client_id) && $appointment->client_id==$list->id)
                                                                selected @endif>{{  $list->full_name}}</option>
                                                    @endforeach
                                                </select>
                                            @endif


                                        </div>

                                    </div>
                                </div>


                                <div class="row new">
                                    <div class="col-md-12 form-group">
                                        <label for="newclint_name">Nuevo Cliente <span
                                                    class="text-danger">*</span></label>
                                        <input type="text" placeholder="" class="form-control" id="new_client"
                                               name="new_client" autocomplete="off"
                                               value="{{ $appointment->name ?? ''}}">
                                    </div>
                                </div>
                                <div class="row">

                                        <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                            <label for="fullname">Relacionar con</label>
                                            <select  class="form-control selct2-width-100" id="related" name="related">
                                                <option value="">Seleccionar</option>
                                                <option value="case"
                                                        @if(isset($appointment) && $appointment->related=='case') selected="" @endif
                                                >Caso
                                                </option>

                                                <option value="other"
                                                        @if(isset($appointment) && $appointment->related=='other') selected="" @endif>Otro
                                                </option>
                                            </select>
                                        </div>


                                        @php
                                            $style = ($appointment->related=="case")? '' : 'hide';

                                        @endphp


                                        <div class="col-md-6 col-sm-12 col-xs-12 form-group task_selection {{ $style }}">
                                            <label for="fullname">Caso</label>
                                            <select  class="form-control selct2-width-100" id="related_id" name="related_id">
                                                <option value="">Seleccionar usuario</option>
                                                @foreach($cases as $key=>$val)

                                                    <option value="{{$val->id}}"
                                                            @if(isset($appointment) && $appointment->case_id == $val->id) selected="" @endif
                                                    >
                                                        <strong>{{  $val->first_name.' '.$val->middle_name.' '.$val->last_name }}</strong><br>
                                                        <div>{{ 'No- '.$val->case_number }}</div>
                                                    </option>
                                                @endforeach
                                            </select>


                                        </div>
                                    </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="text" placeholder="" class="form-control" id="email" name="email"
                                               autocomplete="off" value="{{ $appointment->mobile}}">
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label for="date">Fecha <span class="text-danger">*</span></label>

                                        <input type="text" class="form-control" id="date" name="date"
                                               value="{{ date($date_format_laravel, strtotime($appointment->date)) }}">


                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label for="time">Hora <span class="text-danger">*</span></label>

                                        <input type="text" class="form-control" id="time" name="time"
                                               value="{{ $appointment->time }}">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="note">Nota</label>
                                        <textarea type="text" placeholder="" class="form-control" id="note"
                                                  name="note">{{ $appointment->note ?? ''}}</textarea>
                                    </div>
                                </div>


                            </div>
                            <div class="form-group pull-right">
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <br>
                                    <a href="{{ route('appointment.index') }}" class="btn btn-danger">Cancel</a>

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
    </div>

    <input type="hidden" name="date_format_datepiker"
           id="date_format_datepiker"
           value="{{$date_format_datepiker}}">

    <input type="hidden" name="getMobileno"
           id="getMobileno"
           value="{{ route('getMobileno') }}">

    <input type="hidden" name="type_chk"
           id="type_chk"
           value="{{$appointment->type}}">

    <input type="hidden" name="select2Case"
           id="select2Case"
           value="{{route('select2Case') }}">

@endsection

@push('js')
    <script src="{{asset('assets/admin/appointment/appointment.js') }}"></script>
    <script src="{{asset('assets/js/appointment/appointment-validation_edit.js')}}"></script>

@endpush
