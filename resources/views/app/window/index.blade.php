@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> MODULOS
                </div>
                <div class="card">
                    @livewire('window.index-screen')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('view','app/window/index.blade.php')