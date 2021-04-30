<?php

namespace App\Http\Livewire\Window;

use App\Models\Window;
use Livewire\Component;
use Livewire\WithPagination;

class IndexScreen extends Component
{
	use WithPagination;

	protected $paginationTheme = 'bootstrap';


    public function render()
    {
        return view('livewire.window.index-screen', [
        	'windows' => Window::paginate(3)
        ]);
    }

}
