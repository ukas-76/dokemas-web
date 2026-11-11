<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DOKEMAS - Dolan Keliling Banyumas')</title>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
    @hasSection('custom_footer')
        @yield('custom_footer')
    @else
        @include('layouts.footer')
    @endif

    @if(session('login_required'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var modalEl = document.getElementById('modalAuth');
                if (modalEl) {
                    if (window.bootstrap && window.bootstrap.Modal) {
                        var modal = window.bootstrap.Modal.getOrCreateInstance(modalEl);
                        modal.show();
                    } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                        modal.show();
                    }
                }
            });
        </script>
    @endif

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof showGlobalToast === 'function') {
                    showGlobalToast("{{ session('success') }}", 'success');
                }
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof showGlobalToast === 'function') {
                    showGlobalToast("{{ session('error') }}", 'danger');
                }
            });
        </script>
    @endif

</body>
</html>