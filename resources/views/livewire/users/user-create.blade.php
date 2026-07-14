<x-layouts::app :title="__('Create User')">

        <flux:heading size="lg">Create New User</flux:heading>
        <flux:text class="mt-2 text-zinc-500 dark:text-zinc-400">Fill in the details to add a new user.</flux:text>
		<flux:separator />
    
<form wire:submit.prevent="createUser">
   
    <!-- Name -->
	
    <flux:input 
        label="Full Name" 
        wire:model="name" 
        placeholder="Jane Doe" 
		type="text" autofocus
		autocomplte="name"
    />
	@error('name') <span class="error">{{ $message }}</span> @enderror 
    

    <!-- Email -->
    <flux:input 
        type="email" 
        label="Email Address" 
        wire:model="email" 
        placeholder="jane@example.com" 
		autocomplte="email"
    />

    <!-- Password -->
    <flux:input 
        type="password" 
        label="Password" 
        wire:model="password" 
        placeholder="Min. 8 characters"
		autocomplte="new-password"
    />

    <!-- Submit Button -->
    <div class="flex justify-end mt-6">
        <flux:button type="submit" variant="primary">
            Create User
        </flux:button>
    </div>
</form>

</x-layouts::app>
