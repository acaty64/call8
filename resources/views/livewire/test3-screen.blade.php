<div>
	<div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
				<div class="card-body">
					<div class="card">
            <div class="card-header">Livewire Tests Presence Channel</div>
            	<div class="card-body">
								<h3>resources/views/livewire/test3-screen.blade.php</h3>
								Mensaje Recibido: {{ $mensaje }}
                    {{-- <span v-show="userTyping">{{userTyping}} is typing ..</span> --}}
                <textarea class="form-control" rows="3" name="body" placeholder="Leave a comment" wire:model="mensaje"></textarea>
                    {{-- <textarea class="form-control" rows="3" name="body" placeholder="Leave a comment" v-model="commentBox" @keydown="typingComment"></textarea> --}}
                <div class="card-body">
  								<button wire:click="send" class="btn btn-large btn-danger">Prueba Presence Channel</button>
                </div>

                <div class="card-body">
              	@foreach ($here as $user)
              		@if(\Auth::user()->is_host)
              			<p>id: {{$user['id']}} is_client: {{$user['is_client']}} is_free: {{$user['is_free']}} </p>
                		@if($user['is_client'] && $user['is_free'])
                			<button>{{$user['name']}}</button>
                		@endif
                	@endif
              		@if(\Auth::user()->is_client)
              		<p>id: {{$user['id']}} is_host: {{$user['is_host']}} is_free: {{$user['is_free']}} window->status_id: {{$user['window']['status_id']}}</p>
                		@if($user['is_host'] && $user['is_free'])
                			<button>{{$user['name']}}</button>
                		@endif
                	@endif
              	@endforeach
              </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>