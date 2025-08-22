@props([
    'addLabel' => null,
    'addTarget' => null,
    'filterLabel' => null,
    'searchPlaceholder' => null,
])

<header class="topbar d-flex align-items-center py-3 px-4 border-bottom">
    <div class="d-flex align-items-center gap-2">
        @if($addLabel)
            <button class="btn btn-primary" @if($addTarget) data-bs-toggle="offcanvas" data-bs-target="#{{ $addTarget }}" @endif>{{ $addLabel }}</button>
        @endif
        @if($filterLabel)
            <button class="btn btn-outline-secondary">{{ $filterLabel }}</button>
        @endif
    </div>
    <div class="ms-auto d-flex align-items-center gap-3">
        @if($searchPlaceholder)
            <div class="search-box position-relative me-3">
                <input type="text" class="form-control search-input" placeholder="{{ $searchPlaceholder }}">
                <span class="search-icon">@include('partials.icons.search')</span>
            </div>
        @endif
        <div class="position-relative me-3">
            <span class="notification-icon">@include('partials.icons.bell')</span>
        </div>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userMenuHeader" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://i.pravatar.cc/40" alt="Avatar" class="rounded-circle me-2" width="36" height="36">
                <div class="user-info text-start">
                    <span class="d-block fw-bold" style="font-size: 0.9rem;">Pedro</span>
                    <span class="d-block" style="font-size: 0.75rem; color: #7D7D7D;">Administrador</span>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenuHeader">
                <li><a class="dropdown-item d-flex align-items-center" href="{{ route('users.index') }}"><span class="me-2">@include('partials.icons.user')</span>Usuários</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button class="dropdown-item d-flex align-items-center" type="submit" style="border: none; background: none; width: 100%; text-align: left;">
                            <span class="me-2">@include('partials.icons.logout')</span>Sair
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>