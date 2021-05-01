<div>
	<h1>Livewire index-chat.blade.php</h1>
	<div>user: {{ $user }}</div>
	<div>others: {{ $others }}</div>
	{{-- livewire.index-chat --}}
    <video-chat :user="{{ $user }}" :others="{{ $others }}" pusher-key="{{ config('broadcasting.connections.pusher.key') }}" pusher-cluster="{{ config('broadcasting.connections.pusher.options.cluster') }}"></video-chat>
</div>
