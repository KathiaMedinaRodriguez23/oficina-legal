@extends('admin.layout.app')
@section('title','Case List')
@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_content">
                    <div class="x_title">
                        <h2> Caso</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a href=""><i class="fa fa-download case-transfer-font-size"></i></a>
                            </li>

                            <li><a href=""><i class="fa fa-file-pdf-o case-transfer-font-size"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <br>
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                        <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                            <li role="presentation"
                                class="@if(Request::segment(2)=='case-running')active @ else @endif"><a
                                        href="{{route('case-running.show',$case_id)}}">Detalle</a>
                            </li>
                            <li role="presentation"
                                class="@if(Request::segment(2)=='case-history')active @ else @endif"><a
                                        href="{{url( 'admin/case-history/'.$case_id)}}">Historia</a>

                            </li>
                            <li role="presentation"
                                class="@if(Request::segment(2)=='case-transfer')active @ else @endif"><a
                                        href="{{url('admin/case-transfer/'.$case_id)}}">Transferencia</a>
                            </li>
                        </ul>

                    </div>

                    <table id="case_transfer_list" class="table row-border">
                        <thead>
                        <tr>
                            <th width="5%">Nº</th>
                            <th width="25%">Nº Registro</th>
                            <th width="15%">Fecha de Transferencia</th>
                            <th width="25%">Del Número de Tribunal y Juez</th>
                            <th width="30%">Al Número de Tribunal y Juez</th>

                        </tr>
                        </thead>

                    </table>

                </div>
            </div>
        </div>


    </div>

    <div id="load-modal"></div>

@endsection
@push('js')
    <script src="{{asset('assets/js/case/case-transfer-datatable.js')}}"></script>
@endpush
