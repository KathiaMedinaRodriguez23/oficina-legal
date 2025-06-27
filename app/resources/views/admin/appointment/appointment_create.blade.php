@extends('admin.layout.app')
@section('title','Agregar Citacion')
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
            <h3>Agregar Citacion</h3>
        </div>

        <div class="title_right">
            <div class="form-group pull-right top_search">
                <a href="{{ route('appointment.index') }}" class="btn btn-primary">Atras</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('component.error')
            <div class="x_panel">
                <div class="x_content">
                    <form id="add_appointment" name="add_appointment" role="form" method="POST"
                          action="{{route('appointment.store')}}" enctype="multipart/form-data" autocomplete="off">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="x_content">

                                <div class="row">
                                    <div class="form-group col-md-6">

                                        <input type="radio" id="test5" value="new" name="type" checked>

                                        <b> Nuevo Cliente
                                        </b>

                                    </div>

                                    <div class="form-group col-md-6">

                                        <input type="radio" id="test4" value="exists" name="type">

                                        <b> Cliente Existente
                                       </b>

                                    </div>
                                </div>
                                <br>
                                <div class="row exists">
                                    <div class="col-md-12">

                                        <div class="form-group">
                                            @if(!empty($client_list) && count($client_list)>0)
                                                <label class="discount_text">Seleccione Cliente
                                                    <er class="rest">*</er>
                                                </label>
                                                <select class="form-control selct2-width-100" name="exists_client"
                                                        id="exists_client"
                                                        onchange="getMobileno(this.value);">
                                                    <option value="">Seleccione cliente</option>
                                                    @foreach($client_list as $list)
                                                        <option value="{{ $list->id}}">{{  $list->full_name}}</option>
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
                                               name="new_client" autocomplete="off">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                                        <label for="fullname">Relacionado con</label>
                                        <select class="form-control selct2-width-100" id="related" name="related">
                                            <option value="">Seleccionar nota</option>
                                            <option value="case">Caso</option>
                                            <option value="other">Otro</option>
                                        </select>
                                    </div>


                                    <div class="col-md-6 col-sm-12 col-xs-12 form-group task_selection hide">
                                        <label for="fullname">Caso</label>
                                        <select class="form-control selct2-width-100" id="related_id" name="related_id">
                                            <option value="">Seleccionar usuario</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="email">Correo Electrónico <span class="text-danger">*</span></label>
                                        <input type="email" placeholder="ejemplo@correo.com" class="form-control" id="email" name="email"
                                               autocomplete="off">
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label for="date">Fecha <span class="text-danger">*</span></label>

                                        <input type="text" class="form-control" id="date" name="date">


                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label for="time">Hora <span class="text-danger">*</span></label>

                                        <input type="text" class="form-control" id="time" name="time">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="note">Nota</label>
                                        <textarea type="text" placeholder="" class="form-control" id="note"
                                                  name="note"></textarea>
                                    </div>
                                </div>


                            </div>
                            <div class="form-group pull-right">
                                <div class="col-md-12 col-sm-6 col-xs-12">
                                    <br>
                                    <a href="{{ route('appointment.index') }}" class="btn btn-danger">Cancelar</a>
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
    </div>
    <input type="hidden" name="date_format_datepiker"
           id="date_format_datepiker"
           value="{{$date_format_datepiker}}">

    <input type="hidden" name="getMobileno"
           id="getMobileno"
           value="{{ route('getMobileno') }}">
@endsection

@push('js')
    <input type="hidden" name="select2Case"
           id="select2Case"
           value="{{route('select2Case') }}">
    <script src="{{asset('assets/admin/appointment/appointment.js') }}"></script>
    <script src="{{asset('assets/js/appointment/appointment-validation.js')}}"></script>
@endpush
