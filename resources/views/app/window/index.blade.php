@extends('layouts.app')

@section('content')
<div class="container">
	<h1>Windows Index</h1>
    @foreach($data as $item)
        <div class="row">
        	<div class="col">{{ $item->id }}</div>
        	<div class="col">{{ $item->window }}</div>
            @if($item->host)
        	   <div class="col">{{ $item->host->name }}</div>
            @else
               <div class="col"></div>
            @endif
            @if($item->client)
                <div class="col">{{ $item->client->name }}</div>
            @else
               <div class="col"></div>
            @endif
            @if($item->status)
            	<div class="col">{{ $item->status->status }}</div>
            @else
               <div class="col"></div>
            @endif
        	<div class="col">{{ $item->link }}</div>
        </div>
    @endforeach
</div>
@endsection

@section('view','app/window/index.blade.php')