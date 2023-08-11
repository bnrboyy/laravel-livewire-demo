<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <livewire:styles />
    @livewireStyles
    @vite('resources/css/app.css')
    <title>Laravel Livewire</title>
</head>
<body>
    <main class="flex flex-col justify-center items-center w-full h-full">
        <livewire:comments />
        {{-- @livewire('comments') --}}

    </main>



    <livewire:scripts />
    {{-- @livewireScripts --}}
</body>
</html>