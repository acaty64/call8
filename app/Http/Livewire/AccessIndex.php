<?php

namespace App\Http\Livewire;

use App\Models\Access;
use Livewire\Component;
use Livewire\WithPagination;

class AccessIndex extends Component
{
	use WithPagination;

	protected $paginationTheme = 'bootstrap';

	public $status;
	public $access_id;
    public $user_id;
	public $type_id;
	public $office_id;

    protected $rules = [
            'user_id' => 'required',
            'type_id' => 'required',
            'office_id' => 'required',
    ];


    public function render()
    {
        return view('livewire.access-index', ['index' => Access::orderBy('id', 'desc')->paginate(1)]);
    }

    public function mount()
    {
    	$this->status = 'index';
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
		$this->office_id = '';
    }

    public function edit()
    {
    	$access = Access::find($this->access_id);
		$this->user_id = $access->user_id;
		$this->type_id = $access->type_id;
		$this->office_id = $access->_officeid;
    }

    public function destroy()
    {
    	$access = Access::find($this->access_id);
		$this->user_id = $access->user_id;
		$this->type_id = $access->type_id;
		$this->office_id = $access->_officeid;
    }

    public function save()
    {
    	if($this->status == 'edit')
    	{
        	$this->validate();
	    	$access = Access::find($this->access_id);
			$access->user_id = $this->user_id ;
			$access->type_id = $this->type_id ;
			$access->office_id = $this->office_id ;
			$access->save();
    	}elseif( $this->status == 'create'){
            $this->validate();
            Access::create([
				'user_id' => $this->user_id ,
				'type_id' => $this->type_id ,
				'office_id' => $this->office_id ,
	    	]);
    	}elseif( $this->status == 'destroy'){
            $access = Access::find($this->access_id);
            $access->delete();
        }

    	$this->status = 'index';
        $this->render();

    }


}
