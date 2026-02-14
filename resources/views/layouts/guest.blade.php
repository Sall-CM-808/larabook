<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Larabook') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-200 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-900">
            <div class="flex items-center gap-2 mb-6">
                <svg class="w-8 h-8 text-indigo-400" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M21 4H3a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1zM8 18H4V6h4v12zm6 0h-4V6h4v12zm6 0h-4V6h4v12z"/>
                </svg>
                <span class="text-2xl font-bold text-white tracking-wide">LARA<span class="text-indigo-400">BOOK</span></span>
            </div>

            <div class="w-full sm:max-w-md mt-2 px-6 py-6 bg-slate-800 border border-white/10 overflow-hidden sm:rounded-2xl shadow-xl shadow-black/20">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
