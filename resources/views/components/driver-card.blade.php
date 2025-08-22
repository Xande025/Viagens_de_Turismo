@props([
    'name',
    'email',
    'image' => null,
    'offcanvasId' => null,
    'driverId' => null,
    'cnh' => null
])

<div class="driver-card p-3 d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-3">
        <img src="{{ $image ?? 'https://i.pravatar.cc/60' }}" alt="Motorista" class="rounded-circle" width="50" height="50">
        <div>
            <div class="fw-semibold">{{ $name }}</div>
            <div class="text-muted" style="font-size: 0.85rem;">{{ $email }}</div>
        </div>
    </div>
    <div class="dropdown">
        <button class="btn btn-sm btn-link px-2 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            @include('partials.icons.ellipsis')
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item d-flex align-items-center" 
                   href="#" 
                   data-bs-toggle="offcanvas" 
                   data-bs-target="#driverEditOffcanvas"
                   onclick="loadDriverData({{ $driverId }}, '{{ $name }}', '{{ $email }}')">
                    <span class="me-2">@include('partials.icons.edit')</span>Editar motorista
                </a>
            </li>
            <li>
                <form method="POST" action="{{ $driverId ? route('drivers.destroy', $driverId) : '#' }}" 
                      onsubmit="return confirm('Tem certeza que deseja deletar este motorista?')" style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="dropdown-item d-flex align-items-center text-danger">
                        <span class="me-2">@include('partials.icons.delete')</span>Deletar motorista
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>