<x-layouts.layout>

    <x-form title="Edit your Account">
        <form action="/profile" method="post" class="space-y-3">
            @csrf
            @method('PATCH')

            <x-form.field label="Name" name="name" :value="$user->name"/>
            <x-form.field label="Email" name="email" type="email" :value="$user->email"/>
            <x-form.field label="New Password" name="password" type="password"/>

            <button type="submit" class="btn mt-3 h-10 ml-auto flex items-center justify-center">
                Update account
            </button>
        </form>
    </x-form>

</x-layouts.layout>
