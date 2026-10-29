<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOKEMAS - Dolan Keliling Banyumas</title>
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>

    <!-- NAVBAR COMPONENT -->
    @include('layouts.navbar')

    <!-- MAIN CONTENT -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER COMPONENT -->
    @include('layouts.footer')

</body>
</html>