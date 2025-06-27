@extends('admin.layout.app')
@section('title','Case History')
@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_content">
                    <div class="x_title">
                        <h2> Caso</h2>
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
                            <li role="presentation" class="@if(Request::segment(4)=='transfer')active @ else @endif"><a
                                    href="{{url('admin/case-transfer/'.$case_id)}}">Transferencia</a>
                            </li>
                        </ul>

                    </div>
                    <table id="case_history_list" class="table row-border" >
                        <thead>
                        <tr>

                            <th width="16%">Nº de registro</th>
                            <th width="23%">Juez</th>
                            <th width="15%">Fecha de la audiencia</th>
                            <th width="14%">Fecha de la audiencia</th>
                            <th width="35%">Objetivo de la audiencia</th>
                            <th width="2%" class="text-center">Observaciones</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>


    </div>

    <div id="load-modal"></div>

    <div id="remarkModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Encabezado modal</h4>
                </div>
                <div class="modal-body">

                </div>
            </div>

        </div>
    </div>
    <input type="hidden" name="token-value"
           id="token-value"
           value="{{csrf_token()}}">
    <input type="hidden" name="case_ids"
           id="case_ids"
           value="{{$case_id}}">
    <input type="hidden" name="allCaseHistoryList"
           id="allCaseHistoryList"
           value="{{ url('admin/allCaseHistoryList') }}">

@endsection
@push('js')
    <script src="{{asset('assets/js/case/case-history-datatable.js')}}"></script>
@endpush
