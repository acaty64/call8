<?php

namespace App\Http\Livewire;

use App\Models\Access;
use App\Models\Type;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AccessIndex extends Component
{
	use WithPagination;

	protected $paginationTheme = 'bootstrap';

	public $status;
	public $access_id;
    public $access;
    public $user_id;
	public $type_id;
    public $users;
    public $types;
    public $item_name;
    public $item_type;

    protected $rules = [
            'user_id' => 'required',
            'type_id' => 'required',
    ];


    public function render()
    {
        if(\Auth::user()->is_master){
            return view('livewire.access-index', ['index' => Access::orderBy('id', 'desc')->paginate(5)]);
        }else{
            $type_host = Type::where('acronym', 'host')->first();
            return view('livewire.access-index', ['index' => Access::where('type_id', $type_host->id)->orderBy('id', 'desc')->paginate(5)]);
        }
    }

    public function mount()
    {
    	$this->status = 'index';
        $this->users = User::orderBy('id', 'desc')->get()->filter(function ($val)
        {
            return !$val->is_host;
        });
        if(\Auth::user()->is_master){
            $this->types = Type::all();
        }else{
            $this->types = Type::where('acronym', 'host')->get();
        }
    }

    public function setStatus($value, $id = null)
    {
    	$this->status = $value;
    	$this->access_id = $id;
    	if($value == 'create')
    	{
    		$this->create();
    	}
    	if($value == 'edit')
    	{
    		$this->access_id = $id;
    		$this->edit();
    	}
        if($value == 'destroy')
        {
            $this->access_id = $id;
            $this->destroy();
        }

    }

    public function create()
    {
		$this->user_id = '';
		$this->type_id = '';
    }

    public function edit()
    {
    	$access = Access::find($this->access_id);
        $this->access = $access;
		$this->user_id = $access->user_id;
		$this->type_id = $access->type_id;
        $this->item_name = $access->user->name;
    }

    public function destroy()
    {
    	$access = Access::find($this->access_id);
		$this->access_id = $access->id;
        $this->user_id = $access->user_id;
		$this->type_id = $access->type_id;
        $this->item_name = $access->user->name;
        $this->item_type = $access->type->name;
    }

    public function save()
    {
    	if($this->status == 'edit')
    	{
        	$this->validate();
	    	$access = Access::find($this->access_id);
			$access->user_id = $this->user_id ;
			$access->type_id = $this->type_id ;
			$access->save();
    	}elseif( $this->status == 'create'){
            $this->validate();
            Access::create([
				'user_id' => $this->user_id ,
				'type_id' => $this->type_id ,
	    	]);
    	}elseif( $this->status == 'destroy'){
            $access = Access::find($this->access_id);
            $access->delete();
        }

    	$this->status = 'index';
        $this->render();

    }


}
