@extends('admin.layout.app')
@section('title','Task')
@section('content')

    <div class="">
        @component('component.heading' , [
       'page_title' => 'Tarea',
       'action' => route('tasks.create') ,
       'text' => 'Añadir Tarea',
       'permission' => $adminHasPermition->can(['task_add'])
        ])
        @endcomponent

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">

                    <div class="x_content">

                        <table id="clientDataTable" class="table" data-url="{{ route('task.list') }}"
                              >
                            <thead>
                            <tr>
                                <th>Nº</th>
                                <th>Nombre de Tarea</th>
                                <th>Relacionada con</th>
                                <th>Fecha de inicio</th>
                                <th>Fecha límite</th>
                                <th>Miembros</th>
                                <th>Estado</th>
                                <th>Prioridad</th>
                                <th data-orderable="false" class="text-center">Acción</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{asset('assets/js/task/task-datatable.js')}}"></script>
@endpush
