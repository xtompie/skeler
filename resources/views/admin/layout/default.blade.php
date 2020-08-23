<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link rel=stylesheet href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900">
    <link rel=stylesheet href=https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css>
    <link href=/resources/admin/css/app.css rel=preload as=style>
    <link href=/resources/admin/js/app.js rel=preload as=script>
    <link href=/resources/admin/css/app.css rel=stylesheet>
</head>

<body>
    <div id="app">
        <v-app>
            <v-navigation-drawer v-model="$admin.drawer" app clipped>
                <v-switch v-model="$vuetify.theme.dark" hide-details inset label="Theme Dark"></v-switch>
            </v-navigation-drawer>

            <v-app-bar app clipped-left blue darken-3>
                <v-app-bar-nav-icon @click.stop="$admin.drawer = !$admin.drawer"></v-app-bar-nav-icon>
                @yield('toolbar-title')
            </v-app-bar>

            <v-main>
               @yield('content')
            </v-main>
        </v-app>
    </div>
    <script src=/resources/admin/js/app.js></script>
</body>

</html>
