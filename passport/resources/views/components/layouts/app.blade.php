<!doctype html>
<html class="h-full font-inter bg-black text-white" lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('vendor/inter/4.0/inter.min.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full pb-20">
    <div class="px-10">
        <nav class="flex justify-between items-center py-4 border-b border-white/10">
            <div>
                <a href="{{ route('home') }}">
                    <img src="{{ Vite::asset('resources/images/logo.svg') }}" alt="">
                </a>
            </div>

            <div class="space-x-6 font-bold">
                <a href="{{ route('home') }}" @class(['underline' => Route::is('home')])>Jobs</a>
                <a href="#">Careers</a>
                <a href="#">Salaries</a>
                <a href="#">Companies</a>
            </div>

            @auth
                <div class="space-x-6 font-bold flex">
                    <a href="{{ route('jobs.create') }}" @class(['underline' => Route::is('jobs.create')])>Post a Job</a>

                    <form method="POST" action="/logout">
                        @csrf
                        @method('DELETE')

                        <button>Log Out</button>
                    </form>
                </div>
            @endauth

            @guest
                <div class="space-x-6 font-bold">
                    <a href="{{ route('register') }}">Sign Up</a>
                    <a href="{{ route('login') }}">Log In</a>
                </div>
            @endguest
        </nav>

        <main class="my-10 max-w-[986px] mx-auto">
            {{ $slot }}
        </main>

        <nav class="flex justify-center items-center py-4 border-t border-white/10">
            <div class="space-x-6 font-bold">
                <a href="#">User</a>
                <a href="#">Applications</a>
                <a href="{{ route('jobs.index') }}" @class(['underline' => Route::is('jobs.index')])>My Jobs</a>
            </div>
        </nav>
    </div>

</body>

</html>
