<x-layouts.layout>

    <x-form title="Register an account" subtitle="start tracking your ideas today">
        <form action="/register" method="post" class="space-y-3">
            @csrf

            <x-form.field label="Name" name="name"/>
            <x-form.field label="Email" name="email" type="email"/>
            <x-form.field label="Password" name="password" type="password"/>

            <button type="submit" class="btn mt-2 h-10">
                Create Account
            </button>
        </form>
    </x-form>

</x-layouts.layout>
