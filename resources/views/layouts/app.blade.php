<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body class="bg-gray-100 antialiased">
    @include('componentes.sidebaradmin') 

    <main >
        <div class="container mx-auto px-4 py-6">
            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>
 