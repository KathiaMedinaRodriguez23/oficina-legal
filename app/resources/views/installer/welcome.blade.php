@extends('installer.app')
@section('title','Thank you')
@section('content')
    <section class="login_content">

        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2 style="float: none;">Gracias</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/login') }}">
                            {{ csrf_field() }}

                            <h2> Bienvenido al asistente de configuración </h2>
                            <p class="text-left">Ofice Legal System es una aplicación web para abogados y bufetes de abogados que permite el mantenimiento de sus oficinas. Este software es muy fácil de usar y una herramienta de sistema sencilla para gestionar información sobre clientes, casos, audiencias, etc.</p>
                            <div>
                                <a href="{{route('check.requirements')}}" class="btn btn-default pull-right">
                                    siguiente
                                </a>
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">

                                <div class="clearfix"></div>
                                <br/>

                                <div>

                                    <p>©2025 All Rights Reserved. Ofice Legal </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection