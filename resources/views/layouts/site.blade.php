<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Document</title>

        @vite(['resources/css/site.css'])
    </head>
    <body class="antialiased">
        <div class="min-h-screen">
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
