@props(['active' => ''])

<aside class="sidebar d-flex flex-column align-items-stretch">
    <div class="text-center py-4">
        <a href="{{ route('users.index') }}">
            <img src="{{ asset('images/logo-white.png') }}" alt="Coinpel" class="img-fluid" style="max-width: 120px;">
        </a>
    </div>
    <nav class="nav flex-column px-3">
        <a class="nav-link {{ $active === 'clientes' ? 'active' : '' }}" href="#">
            <span class="me-2">@include('partials.icons.user')</span> Clientes
        </a>
        <a class="nav-link {{ $active === 'motoristas' ? 'active' : '' }}" href="{{ route('drivers.index') }}">
            <span class="me-2">@include('partials.icons.driver')</span> Motoristas
        </a>
        <a class="nav-link {{ $active === 'estatisticas' ? 'active' : '' }}" href="#">
            <span class="me-2">@include('partials.icons.stats')</span> Estatísticas
        </a>
        <a class="nav-link {{ $active === 'veiculos' ? 'active' : '' }}" href="{{ route('vehicles.index') }}">
            <span class="me-2">@include('partials.icons.vehicle')</span> Veículos
        </a>
        <a class="nav-link {{ $active === 'viagens' ? 'active' : '' }}" href="{{ route('trips.index') }}">
            <span class="me-2">@include('partials.icons.vehicle')</span> Viagens
        </a>
        <a class="nav-link {{ $active === 'contratos' ? 'active' : '' }}" href="#">
            <span class="me-2">@include('partials.icons.contract')</span> Contratos
        </a>
        <a class="nav-link {{ $active === 'pacotes' ? 'active' : '' }}" href="#">
            <span class="me-2">@include('partials.icons.package')</span> Pacotes
        </a>
    </nav>
</aside>