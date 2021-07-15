@extends('layouts.app2')
@section('content')

<div>
	@if(env('APP_DEBUG'))
		<h1 class="row justify-content-center">Video Chat</h1>
		<div>user: {{ $user }}</div>
		<div>other: {{ $other }}</div>
	@endif
    <jitsi-chat
    	:user="{{ $user }}"
    	:other="{{ $other }}"
    	:call="{{ $call }}">
    </jitsi-chat>
</div>

@endsection

@section('view','app/video/jitsi.blade.php')