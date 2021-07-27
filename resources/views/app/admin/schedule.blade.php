@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8"><h1>SCHEDULE SCREEN</h1></div>
                        <div class="col-md-2" align="right"><a href="{{ route('statistics.index') }}" class="btn btn-success">Estadísticas</a></div>
                        <div class="col-md-2" align="right"><a href="{{ (\Auth::user()->is_master) ? route('master.menu') : route('admin.menu') }}" class="btn btn-warning">Regresar</a></div>
                    </div>
                </div>
                <div class="card">
                    @livewire('schedule-screen')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('view','app/admin/schedule.blade.php')