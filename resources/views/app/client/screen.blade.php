@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="row">
                    <div class="col-md-10"><h1>USUARIO </h1><h3>{{ \Auth::user()->name }}</h3></div>
                    @if(\Auth::user()->is_master || \Auth::user()->is_admin)
                        <div class="col-md-2" align="right"><a href="{{ (\Auth::user()->is_master) ? route('master.menu') : route('admin.menu') }}" class="btn btn-warning">Regresar</a></div>
                    @endif
                </div>
                <div class="card">
                    @livewire('client-screen')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    var audio = new Audio("/sounds/misc237.mp3");
    Livewire.on('sound_play', $var => {
        if($var == true){
            audio.play();
        }else{
            audio.pause();
        }
    })
</script>
@endsection
@section('view','app/client/screen.blade.php')