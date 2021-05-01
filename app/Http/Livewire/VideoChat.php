<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Component;

class IndexChat extends Component
{
    // public function render(Request $request)
    public function render()
    {
        $user = \Auth::user();
        $others = User::where('id', '!=', $user->id)->pluck('name', 'id');
        return view('livewire.video-chat')->with([
            'user' => collect($user()->only(['id', 'name'])),
            'other' => $others->first()
        ]);
    }
}
