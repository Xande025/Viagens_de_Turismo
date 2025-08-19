<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Dashboard')</title>
    
    <!-- Bootstrap CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        .sidebar {
            min-height: calc(100vh - 56px);
        }
        .sidebar .nav-link {
            color: #333;
            padding: 0.75rem 1rem;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #e9ecef;
            color: #007bff;
        }
        .main-content {
            min-height: calc(100vh - 56px);
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navbar Superior -->
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <i class="bi bi-geo-alt-fill me-2"></i>{{ config('app.name', 'Viagens Turismo') }}
                </a>
                
                <!-- Toggle para mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <!-- Menu principal -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="bi bi-house-door"></i> Dashboard
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Menu do usuário -->
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('password.change') }}">
                                        <i class="bi bi-key"></i> Alterar Senha
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Sair
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Layout Principal -->
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                    <div class="position-sticky pt-3">
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Gerenciamento</span>
                        </h6>
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                    <i class="bi bi-house-door"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                    <i class="bi bi-people"></i> Usuários
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}" href="{{ route('vehicles.index') }}">
                                    <i class="bi bi-car-front"></i> Veículos
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('drivers.*') ? 'active' : '' }}" href="{{ route('drivers.index') }}">
                                    <i class="bi bi-person-badge"></i> Motoristas
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('trips.*') ? 'active' : '' }}" href="{{ route('trips.index') }}">
                                    <i class="bi bi-geo-alt"></i> Viagens
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
                
                <!-- Área de Conteúdo -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                    <!-- Breadcrumbs (se existir) -->
                    @if(isset($breadcrumbs) && is_array($breadcrumbs))
                        <nav aria-label="breadcrumb" class="pt-3">
                            <ol class="breadcrumb">
                                @foreach($breadcrumbs as $breadcrumb)
                                    @if($loop->last)
                                        <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['title'] }}</li>
                                    @else
                                        <li class="breadcrumb-item">
                                            <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                                        </li>
                                    @endif
                                @endforeach
                            </ol>
                        </nav>
                    @endif
                    
                    <!-- Mensagens de sucesso/erro -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {!! session('success') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <!-- Conteúdo da página -->
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts customizados -->
    @stack('scripts')
</body>
</html>
