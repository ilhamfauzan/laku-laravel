<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="text-center">
                <h2 class="text-xl font-semibold text-red-600">Not Authorized</h2>
                <p class="mt-4 text-gray-600">You need to wait until the owner verifies your access.</p>
            </div>
            <div class="mt-6 flex justify-center space-x-4">
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700">Refresh</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700">Logout</button>
                </form>
            </div>
            </div>
        </div>
    </body>
</html>
