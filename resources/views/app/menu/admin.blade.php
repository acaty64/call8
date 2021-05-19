@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">MENU ADMINISTRADOR
                </div>
                <div class="card">
                    <a href="{{route('dashboard')}}" class="btn btn-success mb-2" role='button'>Dashboard</a>
                    <a href="{{route('schedule')}}" class="btn btn-success mb-2" role='button'>Schedule</a>
                    <a href="{{route('users.index')}}" class="btn btn-success mb-2" role='button'>Usuarios</a>
                    <a href="{{route('access.index')}}" class="btn btn-success mb-2" role='button'>Accesos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('view','app/menu/admin.blade.php')