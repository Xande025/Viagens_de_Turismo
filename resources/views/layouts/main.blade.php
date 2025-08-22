<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Sistema de Viagens' }}</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS Global -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    
    <!-- Page-specific CSS -->
    @yield('styles')
</head>
<body>
    <div class="d-flex">
        <x-sidebar :active="$active ?? ''" />
        <div class="flex-grow-1 d-flex flex-column" style="min-height: 100vh;">
            @yield('header')
            @yield('content')
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Global JavaScript -->
    <script>
        // Configurar CSRF token para requisições AJAX
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}'
        };
        
        // Auto-hide alerts após 5 segundos
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert-dismissible');
                alerts.forEach(function(alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    if (bsAlert) {
                        bsAlert.close();
                    }
                });
            }, 5000);
        });
    </script>
    
    <!-- Page-specific scripts -->
    @stack('scripts')
</body>
</html>