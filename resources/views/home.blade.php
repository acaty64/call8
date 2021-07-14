@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <ul>
                        <li><a href="{{ env('APP_URL') . '/laravel-websockets'}}">Laravel Websockets</a></li>
                        <li><a href="{{ env('APP_URL') . '/master/menu'}}">Master</a></li>
                        <li><a href="{{ env('APP_URL') . '/call/client'}}">Cliente</a></li>
                        <li><a href="{{ env('APP_URL') . '/test/vue'}}">Test Vue JS</a></li>
                        <li><a href="{{ env('APP_URL') . '/test/livewire'}}">Test Livewire</a></li>
                        <li><a href="{{ env('APP_URL') . '/web-rtc'}}">web-rtc - incompleto</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
