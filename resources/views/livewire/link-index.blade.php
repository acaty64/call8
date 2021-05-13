<div>
	@if(env('APP_DEBUG'))
		View: resources/views/livewire/link-index.blade.php
	@endif
@if( $status == 'index')
	<div class="container">
		<h1>Indice de Enlaces</h1>
		<button class="btn-success btn-lg" wire:click="setStatus('create')">Agregar</button>
		<table class="table table-striped">
			<thead>
				<tr class="row">
			    	<th class="col-sm-1">Id</th>
			    	<th class="col-sm-1">Orden</th>
			    	<th class="col-sm-2">Nombre</th>
			    	<th class="col-sm-3">Descripción</th>
			    	<th class="col-sm-2">Enlace</th>
			    	<th class="col-sm-1">Activo</th>
			    	<th class="col-sm-2">Acciones</th>
				</tr>
			</thead>
			<tbody>
			    @foreach($index as $item)
			        <tr class="row">
			        	<td class="col-sm-1">{{ $item->id }}</td>
			        	<td class="col-sm-1">{{ $item->order }}</td>
			        	<td class="col-sm-2">{{ $item->name }}</td>
			        	<td class="col-sm-3">{{ $item->description }}</td>
			        	<td class="col-sm-2">
							<a href="{{ $item->link }}" target="_blank">{{ $item->link }}</a>
			        		</td>
			        	<td class="col-sm-1">{{ $item->active ? 'activo' : 'inactivo' }}</td>
			        	<td class="col-sm-2">
							<button class="btn-success btn-md" wire:click="setStatus('edit', {{ $item->id }})">Editar</button>
							<button class="btn-danger btn-md" wire:click="setStatus('destroy', {{ $item->id }})">Eliminar</button>
			        	</td>
			        </tr>
			    @endforeach
			</tbody>
		</table>
	</div>
	{{ $index->links() }}
@endif
@if( $status == 'create' || $status == 'edit')
	<div class="container">
		<div class="card-header">
			@if( $status == 'edit' )
				<div>
					<h1>Edición de Enlace Id: {{ $link_id }}</h1>
				</div>
			@endif
			@if( $status == 'create' )
				<h1>Nuevo Enlace</h1>
			@endif
			<div class="row">
				<div class="col-sm-3">
					<button class="btn-warning btn-lg" wire:click="setStatus('index')">Regresar</button>
				</div>
				<div class="col-sm-3">
					<button class="btn-danger btn-lg" wire:click="save">Grabar</button>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="input-group mb-3">
				<div class="col-sm-4">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Orden</span>
						<input type="number" wire:model="order" min="1" class="form-control" >
						@error('order') <span class="error">{{ $message }}</span> @enderror
					</div>
				</div>


				<div class="col-sm-2">
				  <div class="input-group-prepend">
				    {{-- <div class="input-group-text"> --}}
						<span class="input-group-text" id="basic-addon1">Activo?</span>
				      	<input type="checkbox" wire:model='active' class="form-control">
				    {{-- </div> --}}
				  </div>
				</div>
			</div>

			<div class="input-group mb-3">
				<div class="col-sm-12">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Nombre</span>
						<input type="text" class="form-control" wire:model="name">
						@error('name') <span class="error">{{ $message }}</span> @enderror
					</div>
				</div>
			</div>

			<div class="input-group mb-3">
				<div class="col-sm-12">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Descripción</span>
						<textarea  wire:model="description" class="form-control" aria-label="With textarea"></textarea>
						@error('description') <span class="error">{{ $message }}</span> @enderror
					</div>
				</div>
			</div>

			<div class="input-group mb-3">
				<div class="col-sm-12">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Enlace</span>
						<input type="text" class="form-control" wire:model="link">
						@error('link') <span class="error">{{ $message }}</span> @enderror
					</div>
				</div>
			</div>
		</div>
	</div>
@endif
@if( $status == 'destroy' )
	<div class="container">
		<div class="card-header">
			<h1>Enlace a Eliminar</h1>
			<div>Id: {{ $link_id }}</div>
			<button class="btn-warning btn-lg" wire:click="setStatus('index')">Regresar</button>
			<button class="btn-danger btn-lg" wire:click="save">Eliminar</button>
		</div>
		<div class="card-body">
			<div class="input-group mb-3">
				<div class="col-sm-4">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Orden</span>
						<input readonly type="text" wire:model="order" min="1" class="form-control" >
					</div>
				</div>
				<div class="col-sm-2">
				  <div class="input-group-prepend">
				    {{-- <div class="input-group-text"> --}}
						<span class="input-group-text" id="basic-addon1">Activo?</span>
				      	<input readonly type="checkbox" wire:model='active' class="form-control">
				    {{-- </div> --}}
				  </div>
				</div>
			</div>
			<div class="input-group mb-3">
				<div class="col-sm-12">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Nombre</span>
						<input readonly type="text" class="form-control" wire:model="name">
					</div>
				</div>
			</div>
			<div class="input-group mb-3">
				<div class="col-sm-12">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Descripción</span>
						<textarea readonly wire:model="description" class="form-control" aria-label="With textarea"></textarea>
					</div>
				</div>
			</div>
			<div class="input-group mb-3">
				<div class="col-sm-12">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Enlace</span>
						<input readonly type="text" class="form-control" wire:model="link">
					</div>
				</div>
			</div>
		</div>
	</div>
@endif
</div>
