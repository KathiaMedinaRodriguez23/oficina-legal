<div class="" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
        <li role="presentation" class="active"><a href="{{ route('clients.show', $client->id) }}">Detalle del Cliente</a>
        </li>
        <li role="presentation" class="@if(Request::segment(4)=='cases')active @ else @endif"><a
                href="{{ url('admin/client/view/cases') }}">Casos</a>

        </li>
        <li role="presentation" class="@if(Request::segment(4)=='account')active @ else @endif"><a
                href="{{ url('admin/client/view/account') }}">Cuenta</a>
        </li>
    </ul>

</div>
