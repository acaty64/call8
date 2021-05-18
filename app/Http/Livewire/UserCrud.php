<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserCrud extends Component
{

	use WithPagination;

	protected $paginationTheme = 'bootstrap';

	public $status;
	public $user_id;
	public $name;
	public $given_name;
	public $email;
	public $code;

    public function render()
    {
        return view('livewire.user-crud', ['index' => User::orderBy('id', 'desc')->paginate(10)]);

        return view('livewire.user-crud');
    }

    protected $rules = [
            'name' => 'required',
            'given_name' => 'required',
            'email' => 'required',
    ];

    public function mount()
    {
    	$this->status = 'index';
    }

    public function setStatus($value, $id = null)
    {
    	$this->status = $value;
    	$this->user_id = $id;
    	if($value == 'create')
    	{
    		$this->create();
    	}
    	if($value == 'edit')
    	{
    		$this->user_id = $id;
    		$this->edit();
    	}
        if($value == 'destroy')
        {
            $this->user_id = $id;
            $this->destroy();
        }

    }

    public function create()
    {
		$this->name = '';
		$this->given_name = '';
		$this->email = '';
		$this->code = '';
    }

    public function edit()
    {
    	$user = User::find($this->user_id);
		$this->name = $user->name;
		$this->given_name = $user->given_name;
		$this->email = $user->email;
		$this->code = $user->code;
    }

  //   public function destroy()
  //   {
  //   	$user = User::find($this->user_id);
		// $this->name = $user->name;
		// $this->given_name = $user->given_name;
		// $this->email = $user->email;
		// $this->code = $user->code;
  //   }

    public function save()
    {
    	if($this->status == 'edit')
    	{
        	$this->validate();
	    	$user = User::find($this->user_id);
			$user->name = $this->name ;
			$user->given_name = $this->given_name ;
			$user->email = $this->email ;
			$user->code = $this->code ;
			$user->save();
    	}elseif( $this->status == 'create'){
            $this->validate();
	    	User::create([
				'name' => $this->name ,
				'given_name' => $this->given_name ,
				'email' => $this->email ,
				'code' => $this->code ,
	    	]);
    	}elseif( $this->status == 'destroy'){
            $user = User::find($this->user_id);
            $user->delete();
        }

    	$this->status = 'index';
        $this->render();

    }




}
