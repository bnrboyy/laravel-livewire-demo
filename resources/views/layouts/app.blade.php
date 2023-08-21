<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <livewire:styles />
    <livewire:scripts /> --}}
    @livewireStyles
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.4.2-web/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Laravel Livewire</title>
</head>

<body>
    <main class="flex flex-col justify-center items-center w-full h-full">
        <div class="navbar bg-neutral text-neutral-content flex justify-between">
            <a class="btn btn-ghost normal-case text-xl w-[10%]">Livewire App</a>
            <nav class="flex justify-center items-center gap-10 w-[90%]">
                <a class="menu home" href="/" data-slug="/">HOME</a>
                <a class="menu comment cursor-pointer" onclick="toComment()" data-slug="/comment">COMMENT</a>
                {{-- <a class="menu comment" href="{{ route('comment') }}" data-slug="/comment">COMMENT</a> --}}
                <a class="menu login" href="/login" data-slug="/login">LOGIN</a>
                <a class="menu login" href="/" data-slug="">ABOUT US</a>
                <a class="menu login" href="/" data-slug="">CONTACT US</a>
            </nav>
        </div>
        {{ $slot }}
        {{-- @yield('content') --}}
        {{-- <livewire:comments /> --}}
        {{-- <livewire:comments :comments="$comments" /> --}}
        {{-- @livewire('comments') --}}
    </main>


    @livewireScripts
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="module">
        import hotwiredTurbo from 'https://cdn.skypack.dev/@hotwired/turbo';
    </script>
    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js"
        data-turbolinks-eval="false"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "newestOnTop": false,
            "progressBar": true,
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }

        function toComment() {
            window.location.href = "/comment"
        }

        function init() {
            const menu = document.querySelectorAll('a.menu')
            const pathURL = window.location.pathname;

            menu.forEach(item => {
                if (item.getAttribute('data-slug') === pathURL) {
                    item.classList.add('border-b-[3px]', 'border-[#ff3c78]')
                }
            });
        }
        init();
    </script>
    {{-- @yield('scripts') --}}
</body>

</html>
