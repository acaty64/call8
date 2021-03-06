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
    	// $this->hosts = User::where('id', '<', 4)->get();
        $this->hosts = User::all()->filter(function($model){
                return $model->is_host == true;
            });
    	$this->selectedHost = '';
    }

    public function updated($selectedHost, $value)
    {
        $this->emit('newHost', $value);
    }

}
