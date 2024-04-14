<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Complete Care Automotive</title>

        @vite(['resources/css/site.css', 'resources/js/site.js'])

    </head>
    <body class="antialiased">
        <div class="min-h-screen">

            @include('components.site.layout.header')

            <main class="mt-[60px]">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
