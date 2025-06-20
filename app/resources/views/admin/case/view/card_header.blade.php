<div class="x_title">
    <h2> Caso</h2>
    <ul class="nav navbar-right panel_toolbox">
        <li>

            <a class="card-header-color"  href="{{url('admin/case-running-download/'.$case->case_id.'/download')}}"
               title="Descargar caso de cómite o junta"><i class="fa fa-download fa-2x "></i></a>
        </li>
        <li>
            <a class="card-header-color"  href="{{url('admin/case-running-download/'.$case->case_id.'/print')}}"
               title="Imprimir caso de cómite o junta" target="_blank"><i class="fa fa-print fa-2x"></i></a>
        </li>

    </ul>
    <div class="clearfix"></div>
</div>

<br>
<div class="" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
        <li role="presentation" class="@if(Request::segment(2)=='case-running')active @ else @endif"><a
                href="{{route('case-running.show',$case->case_id)}}">Detalle</a>
        </li>
        <li role="presentation" class="@if(Request::segment(4)=='histroy')active @ else @endif"><a
                href="{{url( 'admin/case-history/'.$case->case_id)}}">Historia</a>

        </li>
        <li role="presentation" class="@if(Request::segment(4)=='transfer')active @ else @endif"><a
                href="{{url('admin/case-transfer/'.$case->case_id)}}">Transferencia</a>
        </li>
        @if($adminHasPermition->can(['case_edit']) =="1")
            <li role="presentation" class="pull-right udt-nd"><a href="javascript:void(0);"
                                                                 onClick="nextDateAdd({{$case->case_id}});"><i
                        class="fa fa-calendar"></i> Actualizar próxima fecha</a>
            </li>
        @else
            <li role="presentation" class="pull-right udt-nd"><a href="javascript:void(0);"><i
                        class="fa fa-calendar"></i> Actualizar próxima fecha</a>
            </li>
        @endif
    </ul>

</div>
