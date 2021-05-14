@extends('layouts.app')
@section('content')

<div>
	@if(env('APP_DEBUG'))
		<h1>VueJs index-chat.blade.php</h1>
		<div>user: {{ $user }}</div>
		<div>other: {{ $other }}</div>
	@endif
    <video-chat
    	:user="{{ $user }}"
    	:other="{{ $other }}"
    	:call="{{ $call }}"
    	pusher-key="{{ config('broadcasting.connections.pusher.key') }}" pusher-cluster="{{ config('broadcasting.connections.pusher.options.cluster') }}"></video-chat>
</div>

@endsection

@section('view','app/video/index.blade.php')