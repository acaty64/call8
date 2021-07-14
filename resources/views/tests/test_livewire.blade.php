@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tests Livewire</div>
                <div class="card-header">User: {{\Auth::user()->name}}</div>
                <div class="card-header">User_id: {{\Auth::user()->id}}</div>

                <div class="card-body">
                    <h1>Prueba Livewire Channel</h1>
                    @livewire('test.test1-screen')
                </div>
                <div class="card-body">
                    <h1>Prueba Livewire Private Channel</h1>
                    @livewire('test.test2-screen')
                </div>
                <div class="card-body">
                    <h1>Prueba Livewire Presence Channel</h1>
                    @livewire('test.test3-screen')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('view','app/tests/test_livewire.blade.php')
