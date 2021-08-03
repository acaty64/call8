@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="row">
                    <div class="col-md-10"><h1>USUARIO </h1><h3>{{ \Auth::user()->name }}</h3></div>
                </div>
                <div class="card-header">
                    <h1>
                        Ha terminado la conexión.
                    </h1>
                </div>
                <div class="card-body">
                    <h3>
                        Puede ingresar nuevamente al módulo <a href={{ env('APP_URL') }}>aquí.</a>
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('view','app/host/stop.blade.php')