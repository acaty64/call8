<div>
	@if(env('APP_DEBUG'))
		View: resources/views/livewire/comment-index.blade.php
	@endif
@if( $status == 'index')
	<div class="container">
		<h1>Indice de Comentarios</h1>
		<table class="table table-striped">
			<thead>
				<tr class="row">
			    	<th class="col-sm-1">Id</th>
			    	<th class="col-sm-1">Fecha</th>
			    	<th class="col-sm-3">Cliente / Operador</th>
			    	<th class="col-sm-6">Pregunta y Respuesta</th>
			    	<th class="col-sm-1">Acciones</th>
				</tr>
			</thead>
			<tbody>
			    @foreach($index as $item)
			        <tr class="row">
			        	<td class="col-sm-1">{{ $item->id }}</td>
			        	<td class="col-sm-1">{{ $item->created_at->format('Y-m-d') }}</td>
			        	<td class="col-sm-3">
			        		<div class="row">
			        			<div class="card col-sm-12">
			        				{{ $item->client->name }}
			        			</div>
			        			<div class="card col-sm-12">
					        		{{ $item->host->name }}
			        			</div>
			        		</div>
			        	</td>
			        	<td class="col-sm-6">
			        		<div class="row">
			        			<div class="card col-sm-12">
					        		{{ $item->client_comment }}
				        		</div>
			        			<div class="card col-sm-12">
					        		{{ $item->host_comment }}
				        		</div>
			        		</div>
			        	</td>
			        	<td class="col-sm-1">
							<button class="btn-danger btn-md" wire:click="setStatus('destroy', {{ $item->id }})">Eliminar</button>
			        	</td>
			        </tr>
			    @endforeach
			</tbody>
		</table>
	</div>
	{{ $index->links() }}
@endif
@if( $status == 'destroy' )
	<div class="container">
		<div class="card-header">
			<h1>Comentario a Eliminar</h1>
			<div>Id: {{ $comment_id }}</div>
			<button class="btn-warning btn-lg" wire:click="setStatus('index')">Regresar</button>
			<button class="btn-danger btn-lg" wire:click="save">Eliminar</button>
		</div>
		<div class="card-body">
			<div class="input-group mb-3">
				<div class="col-sm-6">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Cliente</span>
						<input readonly type="text" wire:model="client_name" min="1" class="form-control" >
					</div>
				</div>

				<div class="col-sm-6">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Operador</span>
						<input readonly type="text" wire:model="host_name" min="1" class="form-control" >
					</div>
				</div>
			</div>
			<div class="input-group mb-3">
				<div class="col-sm-12">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Pregunta</span>
						<textarea readonly wire:model="client_comment" class="form-control" aria-label="With textarea"></textarea>
					</div>
				</div>
			</div>
			<div class="input-group mb-3">
				<div class="col-sm-12">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Respuesta</span>
						<textarea readonly wire:model="host_comment" class="form-control" aria-label="With textarea"></textarea>
					</div>
				</div>
			</div>
		</div>
	</div>
@endif
</div>
