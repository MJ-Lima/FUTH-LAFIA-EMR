<?php

namespace App\Livewire\Users;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;

class UserCreate extends Component
{
    public string $name = '';
    public string $email = '';
    public string|null $password = null;
	
	protected function rules(): array{
		return[
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->email, 'email')],
			'password' => ['required', 'string', 'min:8'],
		];
	}
	
	public function createUser()
	{
		$this->validate();
		
		\App\Models\User::create([
			'name' => 		$this->name,
			'email' => 		$this->email,
			'password' =>	bcrypt($this->password),
		]);
		//session()->flash('message', 'User created successfully');
		//$this->reset(['name', 'email', 'password']);
		return redirect()->route('users.index');
	}
	
	public function render()
    {
        return view('livewire.users.user-create');
    }
}
