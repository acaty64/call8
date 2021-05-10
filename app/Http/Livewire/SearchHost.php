<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class SearchHost extends Component
{
	public $hosts;
	public $selectedHost;

    public function render()
    {
        return view('livewire.search-host');
    }

    public function mount()
    {
    	$this->hosts = User::where('id', '<', 4)->get();
    	$this->selectedHost = '';
    }
}
