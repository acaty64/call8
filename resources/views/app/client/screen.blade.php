@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> USUARIO
                </div>
                <div class="card">
                    @livewire('client-screen')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('view','app/client/screen.blade.php')