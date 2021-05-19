@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8"><h1>INDICE DE HORARIOS</h1></div>
                        <div class="col-md-2" align="right"><a href="{{ URL::previous() }}" class="btn btn-warning">Regresar</a></div>
                    </div>
                </div>
                <div class="card">
                    @livewire('schedule-crud')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('view','app/schedule/crud.blade.php')