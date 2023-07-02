<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Posts extends Component
{
    public $post_id, $user_id, $header, $content, $photo;
    public $isModalOpen;
    public $limitPerPage = 10;
    public $confirm;

    public $listeners = [Trix::EVENT_VALUE_UPDATED, 'post-data' => 'postData'];
    public function postData()
    {
        $this->limitPerPage = $this->limitPerPage + 6;
    }

    public function trix_value_updated($value)
    {
        $this->content = $value;
    }

    public function save()
    {
        $this->validate([
            'header' => ['required', 'string', 'max:255'],
            'content' => ['required'],
        ]);
        Post::updateOrCreate(
            ['id' => $this->post_id],
            [
                'header' => $this->header,
                'content' => $this->content,
                'user_id' => $this->user_id ? $this->user_id : Auth::user()->id,
            ],
        );
        $this->closeModalPopover();
        session()->flash('message', 'Success');
    }
    public function edit($id)
    {
        $posts = Post::findOrFail($id);
        $this->post_id = $posts['id'];
        $this->header = $posts['header'];
        $this->content = $posts['content'];
        $this->user_id = $posts['user_id'];
        $this->openModalPopover();
    }
    public function delete($id)
    {
        $post = Post::find($id);
        $pattern = '/src\s*=\s*"(.+?)"/';
        preg_match_all($pattern, $post['content'], $matches);
        foreach ($matches[1] as $path) {
            Storage::delete(str_replace('storage', 'public', $path));
        }
        $post->delete();
        session()->flash('message', 'Success deleted.');
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }
    public function closeModalPopover()
    {
        $this->isModalOpen = false;
        $this->resetCreateForm();
    }
    private function resetCreateForm()
    {
        $this->header = '';
        $this->content = '';
    }
    public function render()
    {
        $posts = Post::with('user')
            ->latest()
            ->paginate($this->limitPerPage);
        $this->emit('postStore');
        return view('livewire.posts.dashboard', ['posts' => $posts]);
    }
}
