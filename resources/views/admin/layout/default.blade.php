<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link href=/resources/admin/css/app.css rel=preload as=style>
    <link href=/resources/admin/js/app.js rel=preload as=script>
    <link href=/resources/admin/css/app.css rel=stylesheet>
</head>

<body>
    <div id="app">
        <div class="container">
            @yield('content')
        </div>
    </div>
    <script src=/resources/admin/js/app.js></script>
</body>

</html>
