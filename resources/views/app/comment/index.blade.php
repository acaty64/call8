@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"> COMMENT INDEX
                </div>
                <div class="card">
                    @livewire('comment-index')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('view','app/comment/index.blade.php')