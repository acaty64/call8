<div>
	<div class="form-group row">
		<div class="col-sm-12">
			<div class="input-group mb">
				<div class="input-group-prepend">
					<span class="input-group-text" id="basic-addon0">Host</span>
				</div>
				{{-- ///////// --}}
				<div class="col-md-8 pl-0">
					<select wire:model="selectedHost" class="form-control" aria-describedby="basic-addon0">
						<option value="" selected>Choose host</option>
						@foreach($hosts as $host)
						<option value="{{ $host->id }}">{{ $host->name }}</option>
						@endforeach
					</select>
				</div>
				{{-- ///////// --}}
			</div>
		</div>
	</div>
</div>