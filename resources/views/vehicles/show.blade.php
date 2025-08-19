@extends('layouts.admin')

@section('title', 'Detalhes do Veículo')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-truck"></i> {{ $vehicle->brand }} {{ $vehicle->model }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-info-circle"></i> Informações do Veículo
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Placa:</td>
                                <td>{{ $vehicle->plate }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Marca:</td>
                                <td>{{ $vehicle->brand }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Modelo:</td>
                                <td>{{ $vehicle->model }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Ano:</td>
                                <td>{{ $vehicle->year }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Capacidade:</td>
                                <td><i class="bi bi-people"></i> {{ $vehicle->capacity }} passageiros</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status:</td>
                                <td>
                                    @php
                                        $statusConfig = [
                                            'available' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Disponível'],
                                            'in_use' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Em Uso'],
                                            'maintenance' => ['class' => 'danger', 'icon' => 'tools', 'text' => 'Manutenção']
                                        ];
                                        $config = $statusConfig[$vehicle->status];
                                    @endphp
                                    <span class="badge bg-{{ $config['class'] }}">
                                        <i class="bi bi-{{ $config['icon'] }}"></i> {{ $config['text'] }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Cadastrado em:</td>
                                <td>{{ $vehicle->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Última atualização:</td>
                                <td>{{ $vehicle->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if($vehicle->description)
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="fw-bold">Descrição:</h6>
                        <p class="text-muted">{{ $vehicle->description }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Viagens do Veículo -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-map"></i> Viagens Recentes
                </h6>
            </div>
            <div class="card-body">
                @if($vehicle->trips()->count() > 0)
                    @php
                        $recentTrips = $vehicle->trips()->with('driver')->latest()->take(5)->get();
                    @endphp
                    @foreach($recentTrips as $trip)
                    <div class="d-flex align-items-center border-bottom pb-2 mb-2">
                        <div class="flex-shrink-0">
                            <div class="bg-{{ $trip->status === 'completed' ? 'success' : 'primary' }} rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                <i class="bi bi-geo-alt text-white"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="fw-bold">{{ $trip->origin }} → {{ $trip->destination }}</div>
                            <small class="text-muted">{{ $trip->departure_time->format('d/m/Y') }}</small>
                        </div>
                    </div>
                    @endforeach
                @else
                    <p class="text-center text-muted py-3">
                        <i class="bi bi-inbox"></i><br>
                        Nenhuma viagem registrada
                    </p>
                @endif
            </div>
        </div>

        <!-- Ações -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-gear"></i> Ações
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Editar Veículo
                    </a>
                    
                    @if($vehicle->trips()->count() === 0)
                    <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" 
                          onsubmit="return confirm('Tem certeza que deseja excluir este veículo?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Excluir Veículo
                        </button>
                    </form>
                    @else
                    <button type="button" class="btn btn-danger" disabled title="Não é possível excluir veículos com viagens">
                        <i class="bi bi-trash"></i> Excluir Veículo
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
