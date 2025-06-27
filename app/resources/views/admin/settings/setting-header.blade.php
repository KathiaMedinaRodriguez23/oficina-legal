<br>
<div class="" role="tabpanel" data-example-id="togglable-tabs">
    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
        <li class="{{ Request::segment(2)=='general-setting' ? 'active' :'' }}" role="presentation"><a
                href="{{ url('admin/general-setting') }}">Datos de la empresa</a>
        </li>
        <li class="{{ Request::segment(2)=='date-timezone' ? 'active' :'' }}"
            role="presentation" class=""><a href="{{ url('admin/date-timezone') }}">Fecha y zona horaria</a>

        </li>

        <li class="{{ Request::segment(2)=='mail-setup' ? 'active' :'' }}"
            role="presentation" class=""><a href="{{ url('admin/mail-setup') }}">Configuración de correo</a>
        </li>

        <li class="{{ Request::segment(2)=='invoice-setting' ? 'active' :'' }}" role="presentation" class=""><a
                href="{{ url('admin/invoice-setting') }}">Configuración de factura</a>
        </li>
    </ul>

</div>
