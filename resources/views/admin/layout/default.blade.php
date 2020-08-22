<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('resources/admin/main.js') }}" defer></script>


    <!-- Styles -->
    {{-- <link href="{{ asset('resources/admin/app.css') }}" rel="stylesheet"> --}}

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css">

</head>
<body>
    <div id="app">
        layout
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
