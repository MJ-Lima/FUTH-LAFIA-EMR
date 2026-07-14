<?php

namespace App\Livewire\Users;

use Livewire\Component;

class UserIndex extends Component
{
    public function render()
    {
        //$data['users'] = App\Models\User::all();
		return view('livewire.users.user-index',['users' => \App\Models\User::paginate(20)]);
    }
	
	public function deleteUser($id) {
		$user = \App\Models\User::findOrFail($id);
		$user->delete();
	}
}
