@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Chart with VueJS - in layout.app2</div>

                <div id="app">
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
var app = new Vue({
    el: '#app',
});
@endsection