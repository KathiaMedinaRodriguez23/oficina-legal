<div class="x_title">
    <h2> Caso</h2>
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
