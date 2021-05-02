@extends('layouts.app')
@section('content')

<div>
	<h1>Livewire test index-chat.blade.php</h1>
	<div>user: {{ $user }}</div>
	<div>other: {{ $other }}</div>
    <video-chat 
    	:user="{{ $user }}" 
    	:other="{{ $other }}" 
    	pusher-key="{{ config('broadcasting.connections.pusher.key') }}" pusher-cluster="{{ config('broadcasting.connections.pusher.options.cluster') }}"></video-chat>
</div>

@endsection