<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="min-h-screen grid grid-cols-1 grid-rows-[5rem_1fr] bg-gray-100">
        @include('layouts.navigation')

        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>