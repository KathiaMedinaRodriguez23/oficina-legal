@extends('admin.layout.app')
@section('title','Case Status')
@section('content')
    <div class="">

        @component('component.modal_heading',
             [
             'page_title' => 'Estado de Caso',
             'action'=>route("case-status.create"),
             'model_title'=>'Crear Estado de Caso',
             'modal_id'=>'#addtag',
             'permission' => $adminHasPermition->can(['case_status_add'])
             ] )
            Status
        @endcomponent


        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <table id="tagDataTable" class="table" data-url="{{ route('case.status.list') }}"
                              >
                            <thead>
                            <tr>
                                <th width="5%">Nº</th>
                                <th width="5%">Estado de Caso</th>
                                <th width="5%" data-orderable="false">Estado</th>
                                <th width="2%" data-orderable="false" class="text-center">Acción</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div id="load-modal"></div>
@endsection

@push('js')
    <script src="{{asset('assets/js/settings/case-statue-datatable.js')}}"></script>
@endpush
