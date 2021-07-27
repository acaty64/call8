@extends('layouts.app2')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8"><h1>ESTADÍSTICAS</h1></div>
        <div class="col-md-2" align="right"><a href="{{ (\Auth::user()->is_master) ? route('master.menu') : route('admin.menu') }}" class="btn btn-warning">Regresar</a></div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('statistics.chart') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group row">
                <div class="col-sm-12">
                    <div class="input-group mb">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon0">Office</span>
                        </div>
                        <div class="col-md-8 pl-0">
                            <select name="office_id" value="selectedOffice" class="form-control">
                                <option value="" selected>Seleccione la oficina</option>
                                @foreach($offices as $office)
                                    <option value="{{ $office->id }}">{{ $office->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @error('office_id') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>
        <button type="submit">Ver cuadros</button>
        </form>
    </div>
</div>
@endsection


@section('view','statistics/dashboard.blade.php')