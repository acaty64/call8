<?php

namespace App\Http\Livewire;

use App\Models\Link;
use Livewire\Component;
use Livewire\WithPagination;

class LinkIndex extends Component
{
	use WithPagination;

	protected $paginationTheme = 'bootstrap';

	public $status;
	public $link_id;
	public $order;
	public $name;
	public $description;
	public $link;
	public $active;

    protected $rules = [
            'order' => 'required',
            'name' => 'required',
            'description' => 'required',
            'link' => 'required',
    ];

    public function render()
    {
        return view('livewire.link-index', ['index' => Link::orderBy('order')->paginate(1)]);
    }

    public function mount()
    {
    	$this->status = 'index';
    	// $this->index = Link::orderBy('id', 'desc')->get();

    }

    public function setStatus($value, $id = null)
    {
    	$this->status = $value;
    	$this->link_id = $id;
    	if($value == 'create')
    	{
    		$this->create();
    	}
    	if($value == 'edit')
    	{
    		$this->link_id = $id;
    		$this->edit();
    	}
        if($value == 'destroy')
        {
            $this->link_id = $id;
            $this->destroy();
        }

    }

    public function create()
    {
    	$link = Link::orderBy('order', 'desc')->first();

		$this->order = $link->order + 1;
		$this->name = '';
		$this->description = '';
		$this->link = '';
		$this->active = 0;
    }

    public function edit()
    {
    	$link = Link::find($this->link_id);
		$this->order = $link->order;
		$this->name = $link->name;
		$this->description = $link->description;
		$this->link = $link->link;
		$this->active = $link->active;
    }

    public function destroy()
    {
        $link = Link::find($this->link_id);
        $this->order = $link->order;
        $this->name = $link->name;
        $this->description = $link->description;
        $this->link = $link->link;
        $this->active = $link->active;
    }

    public function save()
    {
    	if($this->status == 'edit')
    	{
        	$this->validate();
	    	$link = Link::find($this->link_id);
			$link->order = $this->order ;
			$link->name = $this->name ;
			$link->description = $this->description ;
			$link->link = $this->link ;
			$link->active = $this->active ;
			$link->save();
    	}elseif( $this->status == 'create'){
            $this->validate();
	    	Link::create([
				'order' => $this->order ,
				'name' => $this->name ,
				'description' => $this->description ,
				'link' => $this->link ,
				'active' => $this->active ,
	    	]);
    	}elseif( $this->status == 'destroy'){
            $link = Link::find($this->link_id);
            $link->delete();
        }

    	$this->status = 'index';
        $this->render();

    }



}
