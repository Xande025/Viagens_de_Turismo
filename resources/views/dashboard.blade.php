@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2"><i class="bi bi-speedometer2"></i> Dashboard</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-calendar3"></i> Hoje
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cards de Estatísticas -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total de Viagens
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_trips'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-map text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Viagens Ativas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active_trips'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-arrow-right-circle text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Veículos Disponíveis
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['available_vehicles'] }}/{{ $stats['total_vehicles'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-truck text-info" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Motoristas Ativos
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active_drivers'] }}/{{ $stats['total_drivers'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-person-badge text-warning" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Próximas Viagens e Viagens Recentes -->
<div class="row">
    <!-- Próximas Viagens -->
    <div class="col-xl-6 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-clock"></i> Próximas Viagens
                </h6>
                <a href="{{ route('trips.index') }}" class="btn btn-sm btn-primary">Ver Todas</a>
            </div>
            <div class="card-body">
                @if($upcoming_trips->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Origem → Destino</th>
                                    <th>Partida</th>
                                    <th>Veículo</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcoming_trips as $trip)
                                <tr>
                                    <td>
                                        <strong>{{ $trip->origin }}</strong> → {{ $trip->destination }}
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $trip->departure_time->format('d/m/Y H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <small>{{ $trip->vehicle->brand }} {{ $trip->vehicle->model }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $trip->status === 'scheduled' ? 'primary' : 'warning' }}">
                                            {{ ucfirst(str_replace('_', ' ', $trip->status)) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted py-4">
                        <i class="bi bi-calendar-x"></i><br>
                        Nenhuma viagem agendada
                    </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Viagens Recentes -->
    <div class="col-xl-6 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-list"></i> Viagens Recentes
                </h6>
            </div>
            <div class="card-body">
                @if($recent_trips->count() > 0)
                    @foreach($recent_trips as $trip)
                    <div class="d-flex align-items-center border-bottom pb-2 mb-2">
                        <div class="flex-shrink-0">
                            <div class="bg-{{ $trip->status === 'completed' ? 'success' : 'primary' }} rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-geo-alt text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold">{{ $trip->origin }} → {{ $trip->destination }}</div>
                            <small class="text-muted">{{ $trip->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-center text-muted py-4">
                        <i class="bi bi-inbox"></i><br>
                        Nenhuma viagem recente
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
</style>
@endsection
