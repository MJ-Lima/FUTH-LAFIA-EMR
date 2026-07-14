<x-layouts::app :title="__('Users')">

<flux:card>
    <flux:heading size="lg">User Index</flux:heading>

    <flux:text class="mt-2 mb-4">
        List of Users
    </flux:text>

    <flux:button variant="primary" color="blue" href="{{route('users.create')}}">Create user</flux:button>
</flux:card>

<div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
    	
	<table class="w-full text-sm text-left rtl:text-right text-body">
        <thead class="text-sm text-body bg-neutral-secondary-soft border-b rounded-base border-default">
            <tr>
                <th scope="col" class="px-6 py-3 font-medium">
                    Id
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Full names
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Email
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Role
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    
                </th>
            </tr>
        </thead>
        <tbody>
		@foreach($users as $user)
            <tr class="bg-neutral-primary border-b border-default">
                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
				{{$user->id}}
                </th>
                <td class="px-6 py-4">
                    {{$user->name}}
                </td>
                <td class="px-6 py-4">
                    {{$user->email}}
                </td>
                <td class="px-6 py-4">
                   
                </td>
                <td class="px-6 py-4">
                    <flux:dropdown>
						<flux:button icon:trailing="chevron-down">Actions</flux:button>

						<flux:menu>
							<flux:menu.item icon="pencil-square" href="{{route('users.edit', $user->id)}}">Edit</flux:menu.item>

							<flux:menu.separator />

<flux:menu.item wire:click="deleteUser({{$user->id}})" wire:confirm.prompt="Are you sure you want to delete this user?" variant="danger" icon="trash"  >Delete</flux:menu.item>
						</flux:menu>
					</flux:dropdown>
                </td>
            </tr>
		@endforeach	
		</tbody>
    </table>
</div>

</x-layouts::app>


