@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($data as $item)
        <div class="row">
            {{ $item }}
        </div>
        <div class="row">
        	<div class="col">{{ $item->id }}</div>
        	<div class="col">{{ $item->name }}</div>
        	<div class="col">{{ $item->is_host }}</div>
        	<div class="col">{{ $item->is_free }}</div>
        	<div class="col">{{ $item->is_client }}</div>
        	<div class="col">{{ $item->is_paused }}</div>
        </div>
    @endforeach
</div>
@endsection

@section('view','app/user/index.blade.php')