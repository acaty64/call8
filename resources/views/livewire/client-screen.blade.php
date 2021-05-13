<div>
	@if(env('APP_DEBUG'))
	<div>
    	View: resources/views/livewire/client-screen.blade.php
	</div>
	@endif
    <div>
        {{-- @if (session()->has('message')) --}}
        @if ($message)
            <div class="alert alert-warning">
                {{ $message }}
            </div>
        @endif
    </div>
    office_id: {{$office_id}}
    <div class="card-header" align="center">
	    <h1>Hora: {{Carbon\Carbon::now()->format('H:m:s')}}</h1>
    </div>
    @if( $office_id == '' )
	    <div class="row">
	    	<div class="col-sm-6">
		    	<div class="card-header" align="center">
					<b>Hoy: {{ $horarios['today']['date'] }}</b>
		    	</div>
		    	<div class="card-body">
			    	@foreach($horarios['today']['offices'] as $key => $horario_office)
			    		<div align="center">{{ $key }}</div>
			    		@foreach($horario_office['horarios'] as $franja)
							<div align="center">
								{{$franja['ini']}} - {{$franja['fin']}}
							</div>
							{{-- id: {{$horario_office['id'][0]}} --}}
							@if($franja['ini'] <= \Carbon\Carbon::now()->format('H:m') && $franja['fin'] >= \Carbon\Carbon::now()->format('H:m'))
								<button class="btn-success" wire:click="setOfficeId({{$horario_office['id'][0]}})">Ingresar</button>
							@endif
				    	@endforeach
			    	@endforeach
		    	</div>
	    	</div>
	    	<div class="col-sm-6">
		    	<div class="card-header" align="center">
					<b>Mañana: {{ $horarios['tomorrow']['date'] }}</b>
		    	</div>
		    	<div class="card-body">
			    	@foreach($horarios['tomorrow']['offices'] as $key2 => $horario_office2)
			    		<div align="center">{{ $key2 }}</div>
			    		@foreach($horario_office2['horarios'] as $franja)
							<div align="center">
								{{$franja['ini']}} - {{$franja['fin']}}
							</div>

				    	@endforeach
			    	@endforeach
	    		</div>
	    	</div>
	    </div>
    @endif
    @if( $office_id != '' )
	    <div class="container">
	    	El horario de atención de hoy en {{ $office['name'] }} es:
	    	@foreach($horario as $hora)
		    <div class="row">
				<div class=col-sm-2>
				</div>
				<div class=col-sm-4>
		    		{{ $hora['ini']}} - {{ $hora['fin'] }}
				</div>
			</div>
	    	@endforeach
		</div>
	    <div class="container">
		    <div class="row">
				<div class=col-sm>
					Estado: {{ $status }}
				</div>
				<div class=col-sm>
					Esperando: {{ $qclients }}
				</div>
				<div class=col-sm>
					Atendiendo: {{ $qwindows }}
				</div>
		    </div>
		</div>
		<div class="container" align="center">
			@if($status == 'Atendiendo')
				<h1>Espere, conectándose ....</h1>
			@endif
		</div>
		<div>
			@if($status == '')
				<button wire:click="wait" class="btn btn-large btn-warning">Poner en Cola</button>
			@endif
			@if($status == 'Llamando')
				<button wire:click="answer" class="btn btn-large btn-success">Responder</button>
			@endif
			@if($status == 'Atendiendo')
				<button wire:click="stop" class="btn btn-large btn-danger">Colgar</button>
			@endif
		</div>
    @endif
</div>