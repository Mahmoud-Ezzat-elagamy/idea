<nav class="border-b border-border px-6">
    <div class="max-w-7xl mx-auto h-16 flex justify-between items-center">
        <div>
            <a href="/"><img src="/idea-logo.svg" alt="logo" class="h-30 w-30"></a>
        </div>

        <div class="flex gap-4">
            @auth
                <a href="{{ route('profile.edit') }}" class=" btn btn-outlined">Edit profile</a>
                <form action="/logout" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" data-test="logout">Logout</button>
                </form>

            @endauth
            @guest
                <a href="/login">Sign In</a>
                <a href="/register" class="btn">Register</a>
            @endguest
        </div>
    </div>
</nav>
