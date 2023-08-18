<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <livewire:styles />
    <livewire:scripts />
    @livewireStyles
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.4.2-web/css/all.min.css') }}">
    <title>Laravel Livewire</title>
</head>
<body>
    <main class="flex flex-col justify-center items-center w-full h-full">
        <livewire:comments />
        {{-- <livewire:comments :comments="$comments" /> --}}
        {{-- @livewire('comments') --}}
    </main>



    {{-- @livewireScripts --}}
</body>
</html>
