@extends('layouts.app')

@section('content')
<div class="container">
	<h1>Calls Index</h1>
    <div class="row">
    	<div class="col">Id</div>
    	<div class="col">Number</div>
    	<div class="col">User</div>
    	<div class="col">Office</div>
    	<div class="col">Status</div>
    </div>
    @foreach($data as $item)
        <div class="row">
        	<div class="col">{{ $item->id }}</div>
        	<div class="col">{{ $item->number }}</div>
        	<div class="col">{{ $item->user->name }}</div>
        	<div class="col">{{ $item->office->name }}</div>
        	<div class="col">{{ $item->status->status }}</div>
        </div>
    @endforeach
</div>
@endsection

@section('view','app/call/index.blade.php')