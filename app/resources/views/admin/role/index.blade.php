@extends('admin.layout.app')
@section('title','Roles')
@section('content')
    <div class="">

        @component('component.modal_heading',
             [
             'page_title' => 'Rol',
             'action'=>route("role.create"),
             'model_title'=>'Crear Rol',
             'modal_id'=>'#addtag',
              'permission' => '1'
             ] )
            Role
        @endcomponent


        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <table id="roleDataTable" class="table" data-url="{{ route('role.list') }}" >
                            <thead>
                            <tr>
                                <th width="5%">Nº</th>
                                <th width="5%">Rol</th>
                                <th width="2%" data-orderable="false">Acción</th>
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
    <script src="{{asset('assets/js/role/role-datatable.js')}}"></script>
@endpush
