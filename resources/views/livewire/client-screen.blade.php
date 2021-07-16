<div>
	@if(env('APP_DEBUG'))
	<div>
    	View: resources/views/livewire/client-screen.blade.php <br>
	    office_id: {{$office_id}}
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
    <div class="card-header" align="center">
	    <h1>Hora: {{ $custom_time }}</h1>
    </div>
    <br>
    @if( $office_id == '' )
    	<div class="card-header" align="center">
			<b><h2>HORARIOS DE ATENCIÓN</h2></b>
    	</div>
	    <div class="row">
	    	<div class="col-sm-6">
		    	<div class="card-header" align="center">
					<b>Hoy: {{ $horarios['today']['date'] }}</b>
		    	</div>
		    	<div class="card-body">
		    		@if($horarios['today']['offices'] == [])
		    			<div style="color: red">El día de hoy ya no hay operadores programados para su atención. <br>
		    			Por favor, ingrese el siguiente día hábil.</div>
		    		@endif
			    	@foreach($horarios['today']['offices'] as $key => $horario_office)
			    		<div align="center">{{ $key }}</div>
			    		@foreach($horario_office['horarios'] as $franja)
							<div align="center">
								{{-- {{$franja['ini']}} - {{$franja['fin']}} --}}
							{{-- id: {{$horario_office['id'][0]}} --}}
							{{-- @if($franja['ini'] <= \Carbon\Carbon::now()->format('H:m') && $franja['fin'] >= \Carbon\Carbon::now()->format('H:m')) --}}
								@if($franja['ini'] <= $custom_time && $franja['fin'] >= $custom_time)
									<button class="btn btn-success mb-3" wire:click="setOfficeId({{$horario_office['id'][0]}})">{{$franja['ini']}} - {{$franja['fin']}} Ingresar</button>
								@else
									<button class="btn btn-warning mb-3" disabled>{{$franja['ini']}} - {{$franja['fin']}} Espere al horario</button>
								@endif
							</div>
				    	@endforeach
			    	@endforeach
		    	</div>
	    	</div>
	    	<div class="col-sm-6">
		    	<div class="card-header" align="center">
					<b>Mañana: {{ $horarios['tomorrow']['date'] }}</b>
		    	</div>
		    	<div class="card-body">
		    		@if($horarios['tomorrow']['offices'] == [])
		    			<div style="color: red">El día de mañana no hay operadores programados para su atención. </div>
		    		@endif
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
				<button wire:click="wait" class="btn btn-large btn-success">Poner en Cola</button>
			@endif
			@if($status == 'Llamando')
				<button wire:click="answer" class="btn btn-large btn-success">Responder</button>
			@endif
			@if($status == 'Atendiendo')
				<button wire:click="stop" class="btn btn-large btn-danger">Colgar</button>
			@endif
		</div>
    @endif
    <div class="card">
    	 <div class="card-header" align="center">
    	 	OTROS ENLACES
    	</div>
    	<div class="card-body col-12">
			<table class="table table-striped">
				<thead>
					<tr>
						<th scope="col">Tipo</th>
						<th scope="col">Descripción</th>
						<th scope="col">Enlace</th>
					</tr>
				</thead>
				<tbody>
					@foreach($links as $link)
						<tr>
							<td>{{$link->name}}</td>
							<td>{{$link->description}}</td>
							<td><a href="{{$link->link}}">{{$link->link}}</a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
    	 </div>
    </div>
</div>