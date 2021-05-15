@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">ACCESS INDEX
                </div>
                <div class="card">
                    @livewire('access-index')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('view','app/access/index.blade.php')