@extends('admin.layout.app')
@section('title','Court Type')
@section('content')
    <div class="">

        @component('component.modal_heading',
             [
             'page_title' => 'Tipo Tribunal',
             'action'=>route("court-type.create"),
             'model_title'=>'Crear Tipo de Tribunal',
             'modal_id'=>'#addtag',
              'permission' => $adminHasPermition->can(['court_type_add'])
             ] )
            Status
        @endcomponent


        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <table id="tagDataTable" class="table" data-url="{{ route('court.type.list') }}"
                               >
                            <thead>
                            <tr>
                                <th width="2%">Nº</th>
                                <th width="5%">Tipo de Tribunal</th>
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

    <script src="{{asset('assets/js/settings/cort-type-datatable.js')}}"></script>

@endpush
