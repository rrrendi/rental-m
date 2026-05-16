<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'RENTAL-M') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#f4f6f9] text-gray-800 flex flex-col justify-center items-center min-h-screen p-4">
    <div class="mb-6 text-center">
        <span class="text-3xl font-extrabold text-[#0098f0] tracking-wide"># RENTAL-M</span>
    </div>

    <div class="w-full sm:max-w-md bg-white p-8 rounded-lg shadow-sm border border-gray-100">
        {{ $slot }}
    </div>
</body>
</html>