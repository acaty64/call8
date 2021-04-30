<div>
	<div class="container">
		<h1>Windows Index</h1>
		<table class="table table-striped">
			<thead>
				<tr>
			    	<th class="col">Id</th>
			    	<th class="col">Modulo</th>
			    	<th class="col">Operador</th>
			    	<th class="col">Usuario</th>
			    	<th class="col">Estado</th>
				</tr>
			</thead>
			<tbody>
			    @foreach($windows as $item)
			        <tr>
			        	<td class="col">{{ $item->id }}</td>
			        	<td class="col">{{ $item->window }}</td>
			        	<td class="col">{{ $item->host['name'] }}</td>
			        	<td class="col">{{ is_null($item->client) ?  '' : $item->client['name']  }}</td>
			        	<td class="col">{{ $item->status['status'] }}</td>
			        </tr>
			    @endforeach
			</tbody>
		</table>
	</div>
	{{ $windows->links() }}
</div>
