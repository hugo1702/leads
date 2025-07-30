<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Auth')</title>
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gradient-to-br from-gray-900  to-gray-500 font-sans leading-normal tracking-normal h-screen invisible"
    onload="document.body.classList.remove('invisible')">

    <div class=" pt-24 ">
        @yield('content')
    </div>
</body>

</html>
