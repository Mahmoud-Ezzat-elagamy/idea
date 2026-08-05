<x-layouts.layout>

    <x-form title="Log In" subtitle="Glad to have you back">
        <form action="/login" method="post" class="space-y-3">
            @csrf

            <x-form.field label="Email" name="email" type="email"/>
            <x-form.field label="Password" name="password" type="password"/>

            <button type="submit" class="btn mt-2 h-10" data-test="login">
                Sign In
            </button>
        </form>
    </x-form>

</x-layouts.layout>
