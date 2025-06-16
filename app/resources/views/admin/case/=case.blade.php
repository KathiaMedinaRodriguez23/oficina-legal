@extends('admin.layout.app')
@section('title','Case')

@section('content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Casos</h3>
            </div>

            <div class="title_right">
                <div class="form-group pull-right top_search">


                    <a href="{{ route('case.index') }}" class="btn btn-primary">Agregar caso</a>


                </div>
            </div>
        </div>


        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <div class="row">


                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">A partir de la próxima fecha: <span class="text-danger"></span></label>
                                <input type="text" placeholder="" class="form-control filter1">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                <label for="fullname">Hasta la próxima fecha: <span class="text-danger"></span></label>
                                <input type="text" class="form-control filter2">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 form-group">

                                <br>
                                <button class="btn btn-primary case-margin-top-3" type="button" >Limpiar</button>
                                <button type="submit" class="btn btn-success case-margin-top-3" ><i
                                        class="fa fa-search"></i>&nbsp;Buscar
                                </button>
                            </div>


                        </div>

                    </div>
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <h4><a href="">Casos en Ejecución</a></h4>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <h4><a href="">Casos Importante</a></h4>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <h4><a href="">Nº Casos de Comité/Junta </a></h4>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group">
                            <h4><a href="">Casos Archivados</a></h4>
                        </div>
                        <table id="datatable" class="table">
                            <thead>
                            <tr>
                                <th>Nº</th>
                                <th>Detalle del cliente y del caso</th>
                                <th>Detalles del Tribunal</th>
                                <th>Detalles del demandante vs. demandado</th>
                                <th>Próxima fecha</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                            </thead>


                            <tbody>
                            <tr>
                                <td>1</td>
                                <td><i class="fa fa-star-half-o"></i> <a href="{{ url('admin/case/list') }}"
                                                                        >MILIND RASHMIBHAI
                                        DAVE</a><br>
                                    Nº :1089/2016<br>
                                    Caso: CRMA S – Criminal Misc. Application – Sessions
                                </td>
                                <td>Tribunal: Tribunal de Distrito y de Sesiones
                                    <br>
                                    Nº : 5<br>
                                    Magistrado: Juez de Distrito del 5.º ADDL
                                </td>
                                <td>MILIND RASHMIBHAI DAVE<br>
                                    VS<br>
                                    GOVERNMENT OF GUJARAT
                                </td>
                                <td>23-06-2016<br>
                                    Darshan Tank
                                </td>

                                <td>Audiencia</td>
                                <td>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                               aria-expanded="true"><i class="fa fa-ellipsis-h"
                                                                      ></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="{{ url('admin/case/view/detail') }}"><i
                                                            class="fa fa-eye"></i>&nbsp;&nbsp;Mostrar</a>
                                                </li>
                                                <li><a href="#"><i class="fa fa-edit"></i>&nbsp;&nbsp;Editar</a>
                                                </li>
                                                <li><a class="call-model" data-url="{{ url('admin/detail/modal') }}"
                                                       data-target-modal="#Detailmodal"><i
                                                            class="fa fa-calendar-plus-o"></i>&nbsp;&nbsp;Fecha Siguiente</a>
                                                </li>
                                                <li><a class="call-model"
                                                       data-url="{{ url('admin/casetransfer/modal') }}"
                                                       data-target-modal="#Casetransfermodal"><i
                                                            class="fa fa-gavel"></i>&nbsp;&nbsp;Transferencia de casos</a>
                                                </li>
                                            </ul>
                                        </li>

                                    </ul>
                                </td>
                            </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div id="load-modal"></div>
@endsection

@push('js')


    <script type="text/javascript">

        $('.filter1').datetimepicker({
            format: 'DD.MM.YYYY'
        });
        $('.filter2').datetimepicker({
            format: 'DD.MM.YYYY'
        });

    </script>
@endpush
