@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tests Vue JS</div>
                <div class="card-header">User: {{\Auth::user()->name}}</div>
                <div class="card-header">User_id: {{\Auth::user()->id}}</div>

                <div class="card-body">
                    <h1>Prueba Channel</h1>
                    <test1-component></test1-component>
                </div>
                <div class="card-body">
                    <h1>Prueba Private Channel</h1>
                    <test2-component :user="{{$user}}"></test2-component>
                </div>
                <div class="card-body">
                    <h1>Prueba Presence Channel</h1>
                    <test3-component :user="{{$user}}"></test3-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('view','app/tests/test_vue.blade.php')
