@extends('layouts.app')

@section('content')
<div class="container">
        {{-- class="mt-4 bg-white rounded-lg shadow-md p-6" --}}
        {{-- x-data="{{ json_encode(['messages' => $messages, 'messageBody' => '']) }}" --}}
                    {{-- .listen('MessageSentEvent', (e) => { --}}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Tests</div>
                <div class="card-header">User: {{\Auth::user()->name}}</div>
                <div class="card-header">User_id: {{\Auth::user()->id}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
                <div class="card-body">
                    <h1>Prueba Livewire Channel</h1>
                    @livewire('test.test1-screen', [], '1')
                </div>
                <div class="card-body">
                    <h1>Prueba Livewire Private Channel</h1>
                    @livewire('test.test2-screen', [], '2')
                </div>
                <div class="card-body">
                    <h1>Prueba Livewire Presence Channel</h1>
                    @livewire('test.test3-screen', [], '3')
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
{{-- @section('script')
    <script>
        Livewire.on('Test3Event', data => {
            console.log('A post was added with the id of: ' + data['id']);
        })
    </script>
@endsection --}}
@section('view','app/tests/tests.blade.php')
