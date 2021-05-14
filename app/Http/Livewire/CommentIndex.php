<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;
use Livewire\WithPagination;

class CommentIndex extends Component
{

	use WithPagination;

	protected $paginationTheme = 'bootstrap';

	public $status, $client_name, $host_name, $client_comment, $host_comment, $comment_id;

    public function render()
    {
        return view('livewire.comment-index', ['index' => Comment::orderBy('id', 'desc')->paginate(2)]);
    }

    public function mount()
    {
    	$this->status = 'index';

    }

    public function setStatus($value, $id = null)
    {
    	$this->status = $value;
    	$this->comment_id = $id;

        if($value == 'destroy')
        {
            $this->comment_id = $id;
            $this->destroy();
        }

    }

    public function destroy()
    {
        $comment = Comment::find($this->comment_id);
        $this->client_name = $comment->client->name;
        $this->host_name = $comment->host->name;
        $this->client_comment = $comment->client_comment;
        $this->host_comment = $comment->host_comment;

    }

    public function save()
    {

	    if( $this->status == 'destroy'){
            $comment = Comment::find($this->comment_id);
            $comment->delete();
        }

    	$this->status = 'index';
        $this->render();

    }

}
