@extends('admin.layout.app')
@section('title','Cliente')
@push('style')
    <style>
        table.dataTable th.sorting:after,
        table.dataTable th.sorting_asc:after,
        table.dataTable th.sorting_desc:after {
            display: none;
        }
        table.dataTable th {
            cursor: default;
        }
    </style>
@endpush
@section('content')
<div class="">
    @component('component.heading', [
    'page_title' => 'Cliente',
    'action'     => route('clients.create'),
    'text'       => 'Agregar Cliente',
    'permission' => $adminHasPermition->can(['client_add'])
    ])
    @endcomponent

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <table id="clientDataTable"
                           class="table"
                           data-url="{{ route('clients.list') }}">
                        <thead>
                        <tr>
                            <th width="1%">No</th>
                            <th width="10%">Cliente</th>
                            <th width="5%">DNI/RUC</th>
                            <th width="5%">Celulares</th>
                            <th width="5%" data-orderable="false">Caso</th>
                            <th width="5%" data-orderable="false">Estado</th>
                            <th width="5%" data-orderable="false" class="text-center">Accion</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script src="{{ asset('assets/js/client/client-datatable.js') }}"></script>
@endpush
