<?php

namespace App\Http\Livewire;

use App\Models\Office;
use Livewire\Component;
use Livewire\WithPagination;

class OfficeIndex extends Component
{
	use WithPagination;

	protected $paginationTheme = 'bootstrap';

	public $status;
	public $office_id;
    public $code;
	public $name;

    protected $rules = [
            'code' => 'required',
            'name' => 'required',
    ];


    public function render()
    {
        return view('livewire.office-index', ['index' => Office::orderBy('id', 'desc')->paginate(5)]);
    }

    public function mount()
    {
    	$this->status = 'index';
    }

    public function setStatus($value, $id = null)
    {
    	$this->status = $value;
    	$this->office_id = $id;
    	if($value == 'create')
    	{
    		$this->create();
    	}
    	if($value == 'edit')
    	{
    		$this->office_id = $id;
    		$this->edit();
    	}
        if($value == 'destroy')
        {
            $this->office_id = $id;
            $this->destroy();
        }

    }

    public function create()
    {
		$this->code = '';
		$this->name = '';
    }

    public function edit()
    {
    	$office = Office::find($this->office_id);
		$this->code = $office->code;
		$this->name = $office->name;
    }

    public function destroy()
    {
    	$office = Office::find($this->office_id);
		$this->code = $office->code;
		$this->name = $office->name;
    }

    public function save()
    {
    	if($this->status == 'edit')
    	{
        	$this->validate();
	    	$office = Office::find($this->office_id);
			$office->code = $this->code ;
			$office->name = $this->name ;
			$office->save();
    	}elseif( $this->status == 'create'){
            $this->validate();
            Office::create([
				'code' => $this->code ,
				'name' => $this->name ,
	    	]);
    	}elseif( $this->status == 'destroy'){
            $office = Office::find($this->office_id);
            $office->delete();
        }

    	$this->status = 'index';
        $this->render();

    }


}
