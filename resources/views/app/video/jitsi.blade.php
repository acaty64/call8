@extends('layouts.app2')
@section('content')

<div>
	@if(env('APP_DEBUG'))
		<h1 class="row justify-content-center">Video Chat</h1>
		<div>user: {{ $user }}</div>
		<div>other: {{ $other }}</div>
		<div>cal_id: {{ $call->id }}</div>
	@endif
    <jitsi-chat
    	:user="{{ $user }}"
    	:other="{{ $other }}"
    	:call="{{ $call }}"
    	:documents="{{ $documents }}">
    </jitsi-chat>
</div>

@endsection

@section('view','app/video/jitsi.blade.php')