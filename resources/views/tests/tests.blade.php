@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tests</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
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
