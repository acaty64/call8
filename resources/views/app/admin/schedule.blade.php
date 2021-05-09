@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"> OPERADOR
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