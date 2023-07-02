<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\Auth;

class Users extends Component
{
    public $isDisabled = false;
    public $users, $user_id, $name, $email, $password, $role, $password_confirmation;
    public $isModalOpen;
    public $search = '';
    public function render()
    {
        $this->users = User::query();
        if ($this->search != '') {
            $this->users
                ->where('name', 'like', "%{$this->search}%")
                ->orWhere('id', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%");
        }
        $this->users = (Auth::user()->role == 'konselor' ? $this->users->get()->where('role', 'like', 'mahasiswa') : $this->users->get())->sortBy(['role', 'id']);
        return view('livewire.users.users');
    }
    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
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
        $this->isDisabled = false;
        $this->user_id = '';
        $this->name = '';
        $this->email = '';
        $this->role = '';
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function store()
    {
        $this->validate([
            'user_id' => ['required', 'integer', 'unique:users,id,' . $this->user_id],
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $this->user_id],
            'password' => ['required', 'string', new Password(), 'confirmed'],
        ]);

        User::updateOrCreate(
            [
                'id' => $this->user_id,
            ],
            [
                'name' => $this->name,
                'role' => $this->role,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ],
        );
        session()->flash('message', 'Success');
        if (Auth::user()->id == $this->user_id) {
            return redirect('/');
        }
        $this->closeModalPopover();
    }
    public function edit($id)
    {
        $this->isDisabled = true;
        $this->users = User::findOrFail($id);
        $this->user_id = $this->users['id'];
        $this->name = $this->users['name'];
        $this->role = $this->users['role'];
        $this->email = $this->users['email'];
        $this->openModalPopover();
    }

    public function delete($id)
    {
        $user = User::find($id);
        if (count($user->post)) {
            session()->flash('message', 'Cannot Delete, User Have Relation with Other');
        } else {
            $user->deleteProfilePhoto();
            $user->tokens->each->delete();
            $user->delete();
            if (Auth::user()->id == $id) {
                return redirect('/');
            }
            session()->flash('message', 'Success deleted.');
        }
    }
}
