

@extends('layouts.admin-simple')
@section('title', 'Detalhes da Viagem')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="bi bi-map"></i> {{ $trip->origin }} → {{ $trip->destination }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('trips.edit', $trip) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('trips.index') }}" class="btn btn-secondary">
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
                    <i class="bi bi-info-circle"></i> Informações da Viagem
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Origem:</td>
                                <td>{{ $trip->origin }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Destino:</td>
                                <td>{{ $trip->destination }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Partida:</td>
                                <td>{{ $trip->departure_time->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Chegada:</td>
                                <td>{{ $trip->arrival_time->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Nº de Passageiros:</td>
                                <td>{{ $trip->passenger_count }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Valor:</td>
                                <td>R$ {{ number_format($trip->price, 2, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">Veículo:</td>
                                <td>{{ $trip->vehicle->plate }} - {{ $trip->vehicle->model }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Motorista:</td>
                                <td>{{ $trip->driver->name }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status:</td>
                                <td>
                                    @php
                                        $statusConfig = [
                                            'scheduled' => ['class' => 'primary', 'icon' => 'calendar-check', 'text' => 'Agendada'],
                                            'in_progress' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Em andamento'],
                                            'completed' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Concluída'],
                                            'cancelled' => ['class' => 'danger', 'icon' => 'slash-circle', 'text' => 'Cancelada']
                                        ];
                                        $config = $statusConfig[$trip->status] ?? $statusConfig['scheduled'];
                                    @endphp
                                    <span class="badge bg-{{ $config['class'] }}">
                                        <i class="bi bi-{{ $config['icon'] }}"></i> {{ $config['text'] }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Cadastrada em:</td>
                                <td>{{ $trip->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Última atualização:</td>
                                <td>{{ $trip->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="fw-bold">Descrição:</h6>
                        <p class="text-muted">{{ $trip->description }}</p>
                        <h6 class="fw-bold">Observações:</h6>
                        <p class="text-muted">{{ $trip->observations }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Ações -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="bi bi-gear"></i> Ações
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('trips.edit', $trip) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Editar Viagem
                    </a>
                    <form action="{{ route('trips.destroy', $trip) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta viagem?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Excluir Viagem
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
