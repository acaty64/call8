@extends('layouts.app')

@section('content')
<div class="container">
	<h1>Calls Index</h1>
    @foreach($data as $item)
        <div class="row">
        	<div class="col">{{ $item->id }}</div>
        	<div class="col">{{ $item->number }}</div>
        	<div class="col">{{ $item->user->name }}</div>
        	<div class="col">{{ $item->status->status }}</div>
        </div>
    @endforeach
</div>
@endsection

@section('view','app/call/index.blade.php')